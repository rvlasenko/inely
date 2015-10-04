<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace backend\modules\user\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Модель авторизации
 */
class LoginForm extends Model
{
    public $identity;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    public function rules()
    {
        return [
            [['identity', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Собственный метод валидации пароля.
     *
     * Этот метод служит для inline валидации.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', Yii::t('backend', 'Incorrect username or password.'));
            }
        }
    }

    /**
     * Вход в систему используя полученные и валидированные пароль и имя пользователя.
     *
     * @return boolean если пользователь успешной вошел в систему.
     */
    public function login()
    {
        if ($this->validate()) {
            if (Yii::$app->user->login($this->getUser(), $this->rememberMe ? 2592000 : 0)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Поиск пользователя по [[username]]
     *
     * @return User|null объект модели или null, если сохранение не удалось.
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::find()->where([
                'or',
                ['username' => $this->identity],
                ['email' => $this->identity]
            ])->one();
        }

        return $this->_user;
    }
}
