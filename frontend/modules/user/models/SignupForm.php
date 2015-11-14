<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace frontend\modules\user\models;

use common\commands\SendEmailCommand;
use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Модель регистрации
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $passwordConfirm;

    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'unique', 'targetClass' => '\common\models\User',
                'message' => Yii::t('frontend', 'This email address has already been taken')
            ],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],

            ['password', 'required'],
            ['password', 'string', 'min' => 8]
        ];
    }

    /**
     * Запись полученных данных в базу данных и отправка письма подтверждения с уникальным хэшем.
     * @return User|null объект сохраненной модели или null, если сохранение не удалось.
     */
    public function signup()
    {
        if ($this->validate()) {
            $user           = new User();
            $user->username = $this->username;
            $user->email    = $this->email;
            $user->setPassword($this->password);
            $user->generateEmailConfirmToken();
            if ($user->save()) {
                Yii::$app->commandBus->handle(new SendEmailCommand([
                    'from'    => Yii::$app->params['adminEmail'],
                    'to'      => $this->email,
                    'subject' => Yii::t('mail', 'Inely ~ User account activation'),
                    'view'    => 'confirmEmail',
                    'params'  => ['user' => $user]
                ]));
            }
            $user->afterSignup([], [
                'userId'   => $user->id,
                'name'     => 'Root',
                'listName' => 'Root',
                'isDone'   => null
            ]);

            return $user;
        }

        return null;
    }
}
