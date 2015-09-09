<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "tasks".
 *
 * @property integer $id
 * @property string  $name
 * @property integer $list
 * @property integer $author
 * @property integer $isDone
 * @property string  $priority
 * @property string  $due
 */
class Task extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at'
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
            [ 'author', 'default', 'value' => Yii::$app->user->id ],
            [ 'due', 'default', 'value' => time() ],
            [ 'isDone', 'default', 'value' => 0 ],
            [ 'isDone', 'boolean' ],
            [ 'priority', 'in', 'range' => [ 'low', 'medium', 'high' ] ]
        ];
    }

    /**
     * Table name
     * @return string
     */
    public static function tableName()
    {
        return 'tasks';
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
