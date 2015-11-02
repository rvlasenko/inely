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
use yii\db\ActiveRecord;

/**
 * Это класс модели для таблицы "projects".
 *
 * @property int     $id
 * @property string  $listName
 * @property string  $badgeColor
 * @property integer $userId
 */
class Project extends ActiveRecord
{
    public static function tableName()
    {
        return 'projects';
    }

    /**
     * Отношение с таблицей "tasks"
     * @return ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['listId' => 'id']);
    }
}
