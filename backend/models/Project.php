<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace backend\models;

use backend\models\query\ProjectQuery;
use common\components\nested\NestedSetBehavior;
use Yii;
use yii\db\ActiveRecord;

/**
 * Класс модели для таблицы "projects".
 *
 * @property int        $id
 * @property string     $listName
 * @property int        $lft
 * @property int        $rgt
 * @property int        $lvl
 * @property string     $badgeColor
 * @property integer    $userId
 */
class Project extends ActiveRecord
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

    public function rules()
    {
        return [
            [['lft', 'rgt', 'lvl'], 'integer'],
            [['badgeColor'], 'string'],
            [['listName'], 'string', 'max' => 255],
            ['userId', 'default', 'value' => Yii::$app->user->id]
        ];
    }

    public static function tableName()
    {
        return 'projects';
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL
        ];
    }

    public static function find()
    {
        return new ProjectQuery(get_called_class());
    }

    /**
     * Отношение с таблицей "tasks"
     * @return ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasOne(Task::className(), ['listId' => 'id']);
    }
}
