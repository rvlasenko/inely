<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author hirootkit
 */

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Это класс модели для таблицы "tasks_data", содержащий структуру "Nested Set"
 *
 * @property int        $dataId
 * @property int        $lft key left
 * @property int        $rgt key right
 * @property int        $lvl nesting level
 * @property int        $pid parent id
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
     * Получение приоритета задачи по её идентификатору.
     *
     * @param int $node идентификатор узла
     *
     * @return array|ActiveRecord[] результат запроса. Если результат равен null, то будет возвращен пустой массив.
     */
    public static function getPriority($node)
    {
        return Task::find()
                   ->select('priority')
                   ->where(['author' => Yii::$app->user->id])
                   ->andWhere(['id' => $node])
                   ->asArray()
                   ->one();
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
