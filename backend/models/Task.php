<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author hirootkit
 */

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\db\Query;

/**
 * Это класс модели для таблицы "tasks"
 *
 * @property int        $id
 * @property int        $list
 * @property int        $author
 * @property int        $isDone
 * @property string     $priority
 * @property timestamp  $time
 */
class Task extends ActiveRecord
{
    const ACTIVE_TASK    = 0;
    const COMPLETED_TASK = 1;

    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::className(),
                'createdAtAttribute' => false,
                'updatedAtAttribute' => 'updated_at'
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
            ['time', 'default', 'value' => (new Expression('NOW()'))],
            ['isDone', 'default', 'value' => 0],
            ['priority', 'in', 'range' => ['low', 'medium', 'high']],
            ['isDone', 'boolean']
        ];
    }

    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * @param $id
     *
     * @return ActiveDataProvider
     */
    public static function getProject($id)
    {
        return new ActiveDataProvider([
            'query' => Task::find()->where(['author' => Yii::$app->user->getId(), 'list' => $id])->joinWith('tasks_cat')
        ]);
    }

    /**
     * Статический метод, выполняющий вложенные запросы для получения количества задач.
     * @return array результаты запроса. Если результатов нет, будет возвращен пустой массив.
     */
    public static function getCount()
    {
        $result  = [];
        $cond    = ['author' => Yii::$app->user->id, 'isDone' => 0];
        $condNot = ['<>', 'name', 'Root'];

        // Создание подзапроса с уникальными выражениями (входящие / задачи на сегодня, на след. неделю)
        $inboxSubQuery = (new Query())->select('COUNT(*)')
                                      ->from('tasks')
                                      ->innerJoin('tasks_data', 'dataId = id')
                                      ->where($cond)
                                      ->andWhere($condNot);

        $todaySubQuery = (new Query())->select('COUNT(*)')
                                      ->from('tasks')
                                      ->innerJoin('tasks_data', 'dataId = id')
                                      ->where($cond)
                                      ->andWhere($condNot)
                                      ->andWhere((new Expression('DATE(TIME) = CURDATE()')));

        $nextSubQuery = (new Query())->select('COUNT(*)')
                                     ->from('tasks')
                                     ->innerJoin('tasks_data', 'dataId = id')
                                     ->where($cond)
                                     ->andWhere($condNot)
                                     ->andWhere((new Expression('TIME BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)')));

        /* SELECT ( (SELECT COUNT(*) AS `inbox` FROM `tasks`... */
        $result[] = (new Query)->select(['inbox' => $inboxSubQuery])->all();
        $result[] = (new Query)->select(['today' => $todaySubQuery])->all();
        $result[] = (new Query)->select(['next' => $nextSubQuery])->all();

        return $result;
    }

    /**
     * @return ActiveDataProvider
     */
    public static function getInbox()
    {
        return new ActiveDataProvider([
            'query' => Task::find()->where([
                'author' => Yii::$app->user->id,
                'isDone' => self::ACTIVE_TASK
            ])->joinWith('tasksCat')
        ]);
    }

    /**
     * Установка отношений между "tasks" и "tasks_data".
     * Отношение устанавливается на основании вторичных ключей в первой модели, которые соответствуют ключам во второй.
     *
     * @param array $data массив индексов, которые будут сформированы в дереве.
     *
     * @return int значение первичного ключа.
     */
    public function afterCreate($data = [])
    {
        $tasksDataModel = new TasksData();
        $tasksDataModel->setAttributes($data, false);
        $this->link('tasksData', $tasksDataModel);

        return $tasksDataModel->getPrimaryKey();
    }

    /**
     * Отношение с таблицей "tasks_cat"
     * @return ActiveQuery
     */
    public function getTasksCat()
    {
        return $this->hasOne(TaskCat::className(), ['id' => 'list']);
    }

    /**
     * Отношение с таблицей "tasks_data"
     * @return ActiveQuery
     */
    public function getTasksData()
    {
        return $this->hasOne(TasksData::className(), ['dataId' => 'id']);
    }
}
