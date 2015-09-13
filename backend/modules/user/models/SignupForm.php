<?php

namespace backend\modules\user\models;

use common\models\User;
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
    public $passwordConfirm;

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
                'message'     => Yii::t('backend', 'This username has already been taken')
            ],
            [
                'email',
                'unique',
                'targetClass' => '\common\models\User',
                'message'     => Yii::t('backend', 'This email address has already been taken')
            ],
            [ 'email', 'filter', 'filter' => 'trim' ],
            [ 'email', 'required' ],
            [ 'email', 'email' ],
            [ 'password', 'required' ],
            [ 'password', 'string', 'min' => 6 ],
            [ [ 'passwordConfirm' ], 'required', 'on' => [ 'reset' ] ],
            [
                [ 'passwordConfirm' ],
                'compare',
                'compareAttribute' => 'password',
                'message'          => Yii::t('backend', 'Passwords do not match')
            ]
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
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;

            $user->setPassword($this->password);
            $user->generateEmailConfirmToken();

            if ($user->save()) {
                User::sendEmail($user, 'confirmEmail', $this->email, Yii::t('mail', 'Welcome to Inely - User account activation'));
            }

            $user->afterSignup();

            return $user;
        }

        return null;
    }
}
