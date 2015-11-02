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
use backend\models\query\TaskQuery;
use common\components\nested\NestedSetBehavior;

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
class TaskData extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'tree' => [
                'class' => NestedSetBehavior::className(),
                'leftAttribute'  => 'lft',
                'rightAttribute' => 'rgt',
                'depthAttribute' => 'lvl',
            ]
        ];
    }

    public static function tableName()
    {
        return 'task_data';
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL
        ];
    }

    public static function find()
    {
        return new TaskQuery(get_called_class());
    }

    public function rules()
    {
        return [
            [['dataId'], 'integer'],
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
