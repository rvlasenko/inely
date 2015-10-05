<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace backend\modules\user\models;

use common\commands\SendEmailCommand;
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
            ['email', 'exist',
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
        $user = User::findOne(['status' => User::STATUS_ACTIVE, 'email' => $this->email]);

        if ($user) {
            $user->generatePasswordResetToken();
            if ($user->save()) {
                $this->addError('email', Yii::t('backend', 'Check your email for further instructions'));

                return Yii::$app->commandBus->handle(new SendEmailCommand([
                    'from'    => Yii::$app->params['adminEmail'],
                    'to'      => $this->email,
                    'subject' => Yii::t('backend', 'Inely password reset'),
                    'view'    => 'passwordResetToken',
                    'params'  => ['user' => $user]
                ]));
            }
        }

        return false;
    }
}
