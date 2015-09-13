<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * This is the model class for table "tasks".
 *
 * @property integer    $id
 * @property string     $name
 * @property string     $note
 * @property integer    $list
 * @property integer    $author
 * @property integer    $isDone
 * @property string     $priority
 * @property timestamp  $time
 */
class Task extends ActiveRecord
{
    const ACTIVE_TASK = 0;

    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::className(),
                'createdAtAttribute' => false,
                'updatedAtAttribute' => 'updated_at',
                'value'              => (new Expression('NOW()'))
            ]
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [ 'name', 'string', 'max' => 255 ],
            [ 'note', 'string', 'max' => 255 ],
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
            'query' => Task::find()
                           ->where([ 'author' => Yii::$app->user->getId(), 'list' => $id ])
                           ->joinWith('tasks_cat')
        ]);
    }

    /**
     * @return array
     */
    public static function getCount()
    {
        // Define some useful variables
        $result    = [ ];
        $condition = [ 'author' => Yii::$app->user->getId(), 'isDone' => 0 ];

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
                'author' => Yii::$app->user->getId(),
                'isDone' => self::ACTIVE_TASK
            ])->joinWith('tasks_cat')
        ]);
    }

    /**
     * Relation with the table "tasks_cat"
     * @return \yii\db\ActiveQuery
     */
    public function getTasks_cat()
    {
        return $this->hasOne(TaskCat::className(), [ 'id' => 'list' ]);
    }
}
