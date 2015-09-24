<?php

namespace backend\modules\user\models;

use common\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class ConfirmEmailForm extends Model
{
    /**
     * @var User
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param  string $token
     * @param  array  $config
     *
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [ ])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException(Yii::t('backend', 'No confirmation code'));
        }
        $this->_user = User::findByEmailConfirmToken($token);
        if (!$this->_user) {
            throw new InvalidParamException(Yii::t('backend', 'Invalid token. Maybe you have already confirmed your account?'));
        }
        parent::__construct($config);
    }

    /**
     * Resets token.
     *
     * @return boolean if password was reset.
     */
    public function confirmEmail()
    {
        $user = $this->_user;
        $user->removeEmailConfirmToken();

        return $user->save();
    }
}