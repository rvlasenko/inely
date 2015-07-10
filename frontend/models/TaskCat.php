<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tasks_cat".
 *
 * @property integer $id
 * @property string $name
 * @property string $badgeColor
 * @property integer $userId
 */
class TaskCat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tasks_cat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['badgeColor'], 'string', 'max' => 7]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'badgeColor' => 'Цвет значка',
            'userId' => 'User ID',
        ];
    }

    public function getTask()
    {
        return $this->hasOne(Task::className(), ['category' => 'id']);
    }
}
