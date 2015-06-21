<?php

namespace frontend\modules\user\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Это класс модели для таблицы tasks
 *
 * @property integer $id
 * @property string $name
 * @property integer $category
 * @property integer $is_done
 * @property integer $priority
 * @property string $time
 */
class Tasks extends ActiveRecord
{
    /**
     * Имя таблицы
     * @return string
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * @return \yii\db\ActiveQuery
     * Для дальнейшего использования JOIN в ActiveRecord потребуется объявлять связи :(
     * И в соседнем классе сделать то же самое
     */
    public function getTasks_cat()
    {
        return $this->hasOne(TasksCatForm::className(), ['id' => 'category']);
    }

    /**
     * Правила
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
     * Метки для полей
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

    /**
     * @return array|\yii\db\ActiveRecord[]
     * Метод получения всех записей таблицы tasks с join
     */
    public function getTasks()
    {

        $query = Tasks::find();

        $tasks = $query
            ->limit(8)
            ->joinWith('tasks_cat')
            ->orderBy('name')
            ->all();

        return $tasks;
    }
}
