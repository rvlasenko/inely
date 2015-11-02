<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\db\Query;

/**
 * Класс модели для таблицы "tasks"
 *
 * @property int        $id
 * @property int        $list
 * @property int        $author
 * @property int        $isDone
 * @property string     $priority
 * @property timestamp  $dueDate
 */
class Task extends ActiveRecord
{
    const ACTIVE_TASK    = 0;
    const COMPLETED_TASK = 1;

    const PR_HIGH        = 'high';
    const PR_MEDIUM      = 'medium';
    const PR_LOW         = 'low';

    const FORMAT_BOLD    = 'bold';
    const FORMAT_CURSIVE = 'cursive';

    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
            ]
        ];
    }

    /**
     * Правила валидации для атрибутов.
     * @return array
     */
    public function rules()
    {
        return [
            ['author', 'default', 'value' => Yii::$app->user->id],
            ['isDone', 'default', 'value' => self::ACTIVE_TASK],
            ['priority', 'in', 'range' => [1, 2, 3]],
            ['isDone', 'boolean']
        ];
    }

    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * Получение количества задач по категориям.
     * @return array результаты запроса. Если результатов нет, будет возвращен [].
     */
    public static function getCountOfLists()
    {
        $result    = [];
        $condition = ['author' => Yii::$app->user->id, 'isDone' => self::ACTIVE_TASK];
        $ids       = Project::find()->where(['userId' => null])->orWhere(['userId' => Yii::$app->user->id])->all();
        foreach ($ids as $id) {
            $result[$id->id] = (new Query())->select('id')
                                            ->from(self::tableName())
                                            ->where($condition)
                                            ->andWhere(['listId' => $id->id])
                                            ->count();
        }

        return $result;
    }

    /**
     * Получение количества задач по группам.
     * @return array результаты запроса. Если результатов нет, будет возвращен [].
     */
    public static function getCountOfGroups()
    {
        $result     = [];
        $condition  = ['author' => Yii::$app->user->id, 'isDone' => self::ACTIVE_TASK];
        $inboxList  = ['listId' => null];

        // Создание подзапроса с уникальными выражениями (входящие / задачи на сегодня, на след. неделю)
        $inboxSubQuery = (new Query())->select('COUNT(*)')
                                      ->from(self::tableName())
                                      ->innerJoin(TaskData::tableName(), 'dataId = id')
                                      ->where($condition)
                                      ->andWhere($inboxList);

        $todaySubQuery = (new Query())->select('COUNT(*)')
                                      ->from(self::tableName())
                                      ->innerJoin(TaskData::tableName(), 'dataId = id')
                                      ->where($condition)
                                      ->andWhere((new Expression('DATE(IFNULL(dueDate, createdAt)) = CURDATE()')));

        $nextSubQuery = (new Query())->select('COUNT(*)')
                                     ->from(self::tableName())
                                     ->innerJoin(TaskData::tableName(), 'dataId = id')
                                     ->where($condition)
                                     ->andWhere((new Expression('IFNULL(dueDate, createdAt)
                                        BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)')));

        /* SELECT ( (SELECT COUNT(*) AS `inbox` FROM `tasks`... */
        $result[] = (new Query)->select(['inbox' => $inboxSubQuery])->all();
        $result[] = (new Query)->select(['today' => $todaySubQuery])->all();
        $result[] = (new Query)->select(['next'  => $nextSubQuery])->all();

        return $result;
    }

    /**
     * Отношение с таблицей "tasks_cat"
     * @return ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'listId']);
    }

    /**
     * Отношение с таблицей "tasks_data"
     * @return ActiveQuery
     */
    public function getTaskData()
    {
        return $this->hasOne(TaskData::className(), ['dataId' => 'id']);
    }
}
