<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

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
 */
class Task extends ActiveRecord
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
            [['category', 'author', 'isDone'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['priority'], 'string', 'max' => 12],
            [['time'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'author' => 'Автор',
            'isDone' => 'Статус',
            'priority' => 'Важность',
            'time' => 'Срок выполнения'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks_cat()
    {
        return $this->hasOne(TaskCat::className(), ['id' => 'category']);
    }

    /**
     * @return array
     */
    public static function getItems()
    {
        $items = [];
        $head = [];

        $models = TaskCat::find()
            ->where(['userId' => Yii::$app->user->id])
            ->all();

        foreach($models as $model) {
            $count = Task::find()
                ->where(['category' => $model->id])
                ->count();

            $head = [
                [
                    'label' => 'Все подряд',
                    'url' => '/todo'
                ],
            ];

            $items[] =
            [
                'label' => Html::tag('span', $model->name .
                    Html::tag('span', $count, [
                        'class' => 'pull-right badge',
                        'style' => "background-color: $model->badgeColor"
                    ]), []),
                'url' => "/sort?id={$model->id}"
            ];
        }

        return ArrayHelper::merge($head, $items);
    }
}
