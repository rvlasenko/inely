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
 * @property integer $author
 * @property integer $is_done
 * @property integer $priority
 * @property string $time
 */
class Tasks extends ActiveRecord
{
    const NULL_CAT = 1;
    const IS_DONE = 1;
    const NULL_PRIOR = 0;

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
            ->where(['author' => \Yii::$app->user->id])
            ->asArray()
            ->all();

        return $tasks;
    }


    public function done()
    {
        $tasks = Tasks::find($this->id);

        $tasks->is_done = $this->val;

        if ($tasks->save())
            return true;
        else
            return false;
    }

    /**
     * @param int $cat
     * @param int $isDone
     * @param int $priority
     * @param int $time
     * @param $name
     * @return array|\yii\db\ActiveRecord[]
     * Метод сохранения записи
     */
    public function setTasks($name, $time, $cat = self::NULL_CAT, $isDone = self::NULL_IS_DONE, $priority = self::NULL_PRIOR)
    {
        $tasks = new Tasks();

        $tasks->author = \Yii::$app->user->id;
        $tasks->category = $cat;
        $tasks->is_done = $isDone;
        $tasks->priority = $priority;
        $tasks->name = $name;
        $tasks->time = $time;

        $tasks->save();
    }
}
