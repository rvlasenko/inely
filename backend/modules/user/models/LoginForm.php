<?php

namespace backend\modules\user\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $identity;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * Username and password are both required
     * Password is validated by validatePassword()
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ [ 'identity', 'password' ], 'required' ],
            [ 'password', 'validatePassword' ],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
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
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
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
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::find()->where([
                'or',
                [ 'username' => $this->identity ],
                [ 'email' => $this->identity ]
            ])->one();
        }

        return $this->_user;
    }
}
