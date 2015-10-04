<?php

namespace backend\modules\user\models;

use common\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Модель сброса пароля
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $passwordConfirm;

    /**
     * @var \common\models\User
     */
    private $_user;

    /**
     * Конструктор создания модели по данному токену.
     *
     * @param  string $token  уникальный токен.
     * @param  array  $config пары имен-значений, которые будут использоваться для инициализации свойств объектов.
     *
     * @throws \yii\base\InvalidParamException если токен пустой, либо неверный.
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            [['passwordConfirm'], 'required', 'on' => ['reset']],
            [['passwordConfirm'], 'compare',
                'compareAttribute' => 'password',
                'message'          => Yii::t('backend', 'Passwords do not match')
            ]
        ];
    }

    /**
     * Сброс пароля.
     *
     * @return boolean если пароль был сброшен.
     */
    public function resetPassword()
    {
        $user           = $this->_user;
        $user->password = $this->password;
        $user->removePasswordResetToken();

        return $user->save();
    }
}
