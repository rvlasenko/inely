<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\db\Query;

/**
 * This is the model class for table "tasks".
 *
 * @property integer    $id
 * @property integer    $list
 * @property integer    $author
 * @property integer    $isDone
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
     * @return array
     */
    public function rules()
    {
        return [
            [ 'author', 'default', 'value' => Yii::$app->user->getId() ],
            [ 'time', 'default', 'value' => (new Expression('NOW()')) ],
            [ 'isDone', 'default', 'value' => 0 ],
            [ 'priority', 'in', 'range' => [ 'low', 'medium', 'high' ] ],
            [ 'isDone', 'boolean' ]
        ];
    }

    /**
     * @return string
     */
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
            'query' => Task::find()->where([ 'author' => Yii::$app->user->getId(), 'list' => $id ])->joinWith('tasks_cat')
        ]);
    }

    /**
     * @return array
     */
    public static function getCount()
    {
        // Define some useful variables
        $result    = [ ];
        $condition = [ 'author' => Yii::$app->user->id, 'isDone' => 0 ];

        // Create subquery with unique expression (inbox / today tasks, tasks at next week)
        $inboxSubQuery = (new Query())->select('COUNT(*)')->from('tasks')->where($condition);
        $todaySubQuery = (new Query())->select('COUNT(*)')
                                      ->from('tasks')
                                      ->where($condition)
                                      ->andWhere((new Expression('DATE(TIME) = CURDATE()')));

        $nextSubQuery = (new Query())->select('COUNT(*)')
                                     ->from('tasks')
                                     ->where($condition)
                                     ->andWhere((new Expression('TIME BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)')));

        /* SELECT ( (SELECT COUNT(*) AS `inbox` FROM `tasks`... */
        $result[ ] = (new Query)->select([ 'inbox' => $inboxSubQuery ])->all();
        $result[ ] = (new Query)->select([ 'today' => $todaySubQuery ])->all();
        $result[ ] = (new Query)->select([ 'next' => $nextSubQuery ])->all();

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
     * Establishes the relationship between "tasks" and "tasks_data".
     *
     * @param array $data
     *
     * @return mixed
     */
    public function afterCreate($data = [ ])
    {
        $this->trigger(self::EVENT_AFTER_INSERT);

        $tasksDataModel = new TasksData();
        $tasksDataModel->setAttributes($data, false);
        $this->link('tasksData', $tasksDataModel);

        return $tasksDataModel->getPrimaryKey();
    }

    /**
     * Relation with the table "tasks_cat"
     * @return \yii\db\ActiveQuery
     */
    public function getTasksCat()
    {
        return $this->hasOne(TaskCat::className(), [ 'id' => 'list' ]);
    }

    /**
     * Relation with the table "tasks_data"
     * @return \yii\db\ActiveQuery
     */
    public function getTasksData()
    {
        return $this->hasOne(TasksData::className(), [ 'dataId' => 'id' ]);
    }
}
