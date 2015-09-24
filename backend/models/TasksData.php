<?php

/**
 * This file is part of the Inely project.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author rootkit
 */

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tasks_data", containing structure "Nested Set".
 *
 * @property integer    $dataId
 * @property integer    $lft key left
 * @property integer    $rgt key right
 * @property integer    $lvl nesting level
 * @property integer    $pid parent id
 * @property integer    $pos
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
            [ [ 'lft', 'rgt', 'lvl', 'pid', 'pos' ], 'integer' ],
            [ [ 'name' ], 'string', 'max' => 255 ]
        ];
    }

    /**
     * @param $node
     *
     * @return array|null|ActiveRecord
     */
    public static function getPriority($node)
    {
        return Task::find()
            ->select('priority')
            ->where([ 'author' => Yii::$app->user->getId() ])
            ->andWhere([ 'id' => $node ])
            ->asArray()->one();
    }

    /**
     * Relation with the table "tasks"
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasOne(Task::className(), [ 'id' => 'dataId' ]);
    }
}
