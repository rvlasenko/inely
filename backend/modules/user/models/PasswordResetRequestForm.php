<?php

namespace backend\modules\user\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ 'email', 'filter', 'filter' => 'trim' ],
            [ 'email', 'required' ],
            [ 'email', 'email' ],
            [
                'email',
                'exist',
                'targetClass' => '\common\models\User',
                'filter' => [ 'status' => User::STATUS_ACTIVE ],
                'message' => Yii::t('backend', 'There is no user with such email')
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email
        ]);

        if ($user) {
            $user->generatePasswordResetToken();
            if ($user->save()) {
                $this->addError('email', Yii::t('backend', 'Check your email for further instructions'));
                return User::sendEmail($user, 'passwordResetToken', $this->email,
                    Yii::t('mail', 'Inely password reset'));
            }
        }

        return false;
    }
}
