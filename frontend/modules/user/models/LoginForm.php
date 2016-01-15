<?php

/**
 * Эта модель является частью проекта Inely.
 *
 * @link    http://github.com/hirootkit/inely
 * @licence http://github.com/hirootkit/inely/blob/master/LICENSE.md GPL
 * @author  hirootkit <admiralexo@gmail.com>
 */

namespace frontend\modules\user\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Модель авторизации
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
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
                return false;
            }
        }

        return null;
    }

    /**
     * Вход в систему используя полученные и валидированные пароль и имя пользователя.
     *
     * @return boolean если пользователь успешной вошел в систему.
     */
    public function login()
    {
        $user = $this->getUser();
        if ($this->validate() && $user !== null) {
            if (Yii::$app->user->login($user, 2592000)) {
                return true;
            }
        } else {
            return false;
        }

        return false;
    }

    /**
     * Поиск пользователя по [[email]]
     *
     * @return User|null объект модели User или null, если пользоателя не существует
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findOne(['email' => $this->email]);
        }

        return $this->_user;
    }
}
