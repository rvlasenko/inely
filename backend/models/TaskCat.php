<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Это класс модели для таблицы "tasks_cat".
 *
 * @property int     $id
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
     * Отношение с таблицей "tasks"
     * @return ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['list' => 'id']);
    }
}
