<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link   http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace frontend\modules\user\models;

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
            ['email', 'exist', 'targetClass' => '\common\models\User',
                'message' => Yii::t('frontend', 'There is no user with such email')
            ],
        ];
    }

    /**
     * Передача сообщения о востановлении данных на email со ссылкой для сброса пароля.
     * Перед отправкой пользователю генерируется уникальный хэш для пароля.
     *
     * @return true если сообщение было отправлено
     */
    public function sendEmail()
    {
        /**
         * @var $user User
         */
        $user = User::findOne(['email' => $this->email]);

        if ($user) {
            $user->generatePasswordResetToken();
            if ($user->save()) {
                return Yii::$app->commandBus->handle(new SendEmailCommand([
                    'from'    => Yii::$app->params['adminEmail'],
                    'to'      => $this->email,
                    'subject' => Yii::t('frontend', 'Reset password ~ Inely'),
                    'view'    => 'passwordResetToken',
                    'params'  => ['user' => $user]
                ]));
            }
        }

        return false;
    }
}
