<?php

/**
 * Эта модель является частью проекта Inely.
 *
 * @link    http://github.com/hirootkit/inely
 * @licence http://github.com/hirootkit/inely/blob/master/LICENSE.md GPL
 * @author  hirootkit <admiralexo@gmail.com>
 */

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\caching\DbDependency;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\db\Query;

/**
 * Класс модели для таблицы "task"
 *
 * @property int        $taskId
 * @property int        $listId
 * @property int        $ownerId
 * @property int        $isDone
 * @property string     $priority
 * @property timestamp  $dueDate
 */
class Task extends ActiveRecord
{
    const ACTIVE_TASK     = 0;
    const COMPLETED_TASK  = 1;
    const INCOMPLETE_TASK = 2;
    const PR_HIGH         = 'high';
    const PR_MEDIUM       = 'medium';
    const PR_LOW          = 'low';
    const FORMAT_BOLD     = 'bold';
    const FORMAT_CURSIVE  = 'cursive';

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
            ['ownerId', 'default', 'value' => Yii::$app->user->id],
            [['listId', 'sharedWith'], 'safe'],
            ['isDone', 'default', 'value' => self::ACTIVE_TASK],
            ['dueDate', 'date', 'format' => 'yyyy-MM-dd'],
            ['isDone', 'in', 'range' => [0, 1, 2]],
            ['priority', 'in', 'range' => [1, 2, 3]],
            ['assignedTo', 'integer']
        ];
    }

    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * Получение количества задач по группам.
     * @return array результаты запроса. Если результатов нет, будет возвращен [].
     */
    public static function getCountOfGroups()
    {
        $cond  = ['ownerId' => Yii::$app->user->id, 'isDone' => self::ACTIVE_TASK];
        $inbox = ['listId' => null];
        $db    = Task::getDb();
        $dep   = new DbDependency();

        // Создание подзапроса с уникальными выражениями (входящие / задачи на сегодня, на след. неделю)
        $inboxSubQuery = (new Query())->select('COUNT(*)')
                                      ->from(self::tableName())
                                      ->innerJoin(TaskData::tableName(), 'dataId = taskId')
                                      ->where($cond)
                                      ->andWhere($inbox);

        $todaySubQuery = (new Query())->select('COUNT(*)')
                                      ->from(self::tableName())
                                      ->innerJoin(TaskData::tableName(), 'dataId = taskId')
                                      ->where($cond)
                                      ->andWhere((new Expression('DATE(IFNULL(dueDate, createdAt)) = CURDATE()')));

        $nextSubQuery = (new Query())->select('COUNT(*)')
                                     ->from(self::tableName())
                                     ->innerJoin(TaskData::tableName(), 'dataId = taskId')
                                     ->where($cond)
                                     ->andWhere((new Expression('IFNULL(dueDate, createdAt)
                                        BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)')));

        $assignQuery = (new Query())->select('COUNT(*)')
                                     ->from(self::tableName())
                                     ->where(['assignedTo' => Yii::$app->user->id]);


        $dep->sql = 'SELECT MAX(updatedAt) FROM tasks';

        $result = $db->cache(function() use ($inboxSubQuery, $todaySubQuery, $nextSubQuery, $assignQuery) {
            $query[] = (new Query)->select(['inbox' => $inboxSubQuery])->all();
            $query[] = (new Query)->select(['today' => $todaySubQuery])->all();
            $query[] = (new Query)->select(['week'   => $nextSubQuery])->all();
            $query[] = (new Query)->select(['assign' => $assignQuery])->all();

            return $query;
        }, 3600, $dep);

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
        return $this->hasOne(TaskData::className(), ['dataId' => 'taskId']);
    }

    /**
     * Запись данных в модель. Метод перегружен от базового класса Model.
     * @param array|boolean $data массив данных.
     * @param string $formName имя формы, использующееся для записи данных в модель.
     * @return boolean если `$data` содержит некие данные, которые связываются с атрибутами модели.
     */
    public function load($data, $formName = '')
    {
        $scope = $formName === null ? $this->formName() : $formName;
        if ($scope === '' && !empty($data)) {
            $this->setAttributes($data);

            return true;
        } elseif (isset($data[$scope])) {
            $this->setAttributes($data[$scope]);

            return true;
        } else {
            return false;
        }
    }
}
