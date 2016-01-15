<?php

/**
 * Эта модель является частью проекта Inely.
 *
 * @link    http://github.com/hirootkit/inely
 * @licence http://github.com/hirootkit/inely/blob/master/LICENSE.md GPL
 * @author  hirootkit <admiralexo@gmail.com>
 */

namespace backend\models;

use Yii;
use yii\base\Model;

class UserForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User',
             'filter' => function ($query) {
                 $query->andWhere(['not', ['id' => Yii::$app->user->getId()]]);
             }
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email'
        ];
    }
}