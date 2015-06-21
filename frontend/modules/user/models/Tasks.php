<?php

namespace frontend\modules\user\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property integer $id
 * @property string $name
 * @property integer $category
 * @property integer $is_done
 * @property integer $priority
 * @property string $time
 */
class Tasks extends \yii\db\ActiveRecord
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
            [['category', 'is_done', 'priority'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['time'], 'string', 'max' => 15]
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
            'is_done' => 'Is Done',
            'priority' => 'Priority',
            'time' => 'Time',
        ];
    }
}
