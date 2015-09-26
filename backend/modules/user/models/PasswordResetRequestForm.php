<?php

namespace backend\modules\user\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Модель передачи токена для сброса пароля.
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email',
                'exist',
                'targetClass' => '\common\models\User',
                'filter'      => ['status' => User::STATUS_ACTIVE],
                'message'     => Yii::t('backend', 'There is no user with such email')
            ],
        ];
    }

    /**
     * Передача сообщения о востановлении данных на email со ссылкой для сброса пароля.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /**
         * @var $user User
         */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email'  => $this->email
        ]);

        if ($user) {
            $user->generatePasswordResetToken();
            if ($user->save()) {
                $this->addError('email', Yii::t('backend', 'Check your email for further instructions'));

                return User::sendEmail($user, 'passwordResetToken', $this->email, Yii::t('mail', 'Inely password reset'));
            }
        }

        return false;
    }
}
