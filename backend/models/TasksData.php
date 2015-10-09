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
 * Класс модели для таблицы "tasks_data", содержащий структуру "Nested Set"
 *
 * @property int        $dataId
 * @property int        $lft
 * @property int        $rgt
 * @property int        $lvl
 * @property int        $pid
 * @property int        $pos
 * @property string     $name
 *
 */
class TasksData extends ActiveRecord
{
    public static function tableName()
    {
        return 'tasks_data';
    }

    public function rules()
    {
        return [
            [['lft', 'rgt', 'lvl', 'pid', 'pos'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * Отношение с таблицей "tasks"
     * @return ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasOne(Task::className(), ['id' => 'dataId']);
    }
}
