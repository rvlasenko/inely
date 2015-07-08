<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class TaskCat extends ActiveRecord
{
    public static function tableName()
    {
        return 'tasks_cat';
    }

    public function getTask()
    {
        return $this->hasOne(Task::className(), ['category' => 'id']);
    }
}