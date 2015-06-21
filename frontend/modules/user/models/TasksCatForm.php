<?php

namespace frontend\modules\user\models;

use Yii;
use yii\db\ActiveRecord;

class TasksCatForm extends ActiveRecord
{
    public static function tableName()
    {
        return 'tasks_cat';
    }

    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['category' => 'id']);
    }
}