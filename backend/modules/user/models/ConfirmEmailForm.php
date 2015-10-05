<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace backend\modules\user\models;

use common\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Модель сброса пароля
 */
class ConfirmEmailForm extends Model
{
    /**
     * @var User объект класса
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
            throw new InvalidParamException(Yii::t('backend', 'No confirmation code'));
        }
        $this->_user = User::findByEmailConfirmToken($token);
        if (!$this->_user) {
            throw new InvalidParamException(Yii::t('backend', 'Invalid token. Maybe you have already confirmed your account?'));
        }
        parent::__construct($config);
    }

    /**
     * Сброс токена.
     *
     * @return boolean если токен был сброшен.
     */
    public function confirmEmail()
    {
        $user = $this->_user;
        $user->removeEmailConfirmToken();

        return $user->save();
    }
}