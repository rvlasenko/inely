<?php

namespace frontend\modules\user\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property integer $id
 * @property string $name
 * @property integer $category
 * @property integer $author
 * @property integer $is_done
 * @property string $priority
 * @property string $time
 * @property string $is_done_date
 *
 * @property TasksCat $tasksCat
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'author', 'is_done'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['priority'], 'string', 'max' => 12],
            [['time'], 'string', 'max' => 15],
            [['is_done_date'], 'string', 'max' => 3]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'category' => 'Category',
            'author' => 'Author',
            'is_done' => 'Is Done',
            'priority' => 'Priority',
            'time' => 'Time',
            'is_done_date' => 'Is Done Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasksCat()
    {
        return $this->hasOne(TasksCat::className(), ['id' => 'id']);
    }
}
