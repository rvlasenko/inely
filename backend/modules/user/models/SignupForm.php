<?php

namespace backend\modules\user\models;

use common\models\User;
use himiklab\yii2\recaptcha\ReCaptchaValidator;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ 'username', 'filter', 'filter' => 'trim' ],
            [ 'username', 'required' ],
            [ 'username', 'string', 'min' => 2, 'max' => 255 ],
            [
                'username',
                'unique',
                'targetClass' => '\common\models\User',
                'message' => Yii::t('backend', 'This username has already been taken.')
            ],
            [
                'email',
                'unique',
                'targetClass' => '\common\models\User',
                'message' => Yii::t('backend', 'This email address has already been taken.')
            ],
            [ 'email', 'filter', 'filter' => 'trim' ],
            [ 'email', 'required' ],
            [ 'email', 'email' ],
            [ 'password', 'required' ],
            [ 'password', 'string', 'min' => 6 ]
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
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
                Yii::$app->mailer->compose('confirmEmail', [ 'user' => $user ])
                                 ->setTo($this->email)
                                 ->setSubject('Email confirmation for ' . Yii::$app->name)
                                 ->send();
            }

            $user->afterSignup();

            return $user;
        }

        return null;
    }
}
