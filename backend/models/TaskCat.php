<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tasks_cat".
 *
 * @property integer $id
 * @property string  $listName
 * @property string  $badgeColor
 * @property integer $userId
 */
class TaskCat extends ActiveRecord
{
    public static function tableName()
    {
        return 'tasks_cat';
    }

    /**
     * Relation with the table "tasks"
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), [ 'list' => 'id' ]);
    }
}
