<?php

namespace backend\models;

use yii\base\Model;
use Yii;

class TaskForm extends Model
{
    /**
     * @param $data
     *
     * @return the PK or null if saving fails
     */
    public function make($data)
    {
        $user = new Task();

        if ($user->save()) {
            return $user->afterCreate($data);
        }

        return null;
    }
}
