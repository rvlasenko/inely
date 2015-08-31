<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer                    $id
 * @property string                     $username
 * @property string                     $password_hash
 * @property string                     $password_reset_token
 * @property string                     $email
 * @property string                     $auth_key
 * @property string                     $publicIdentity
 * @property integer                    $status
 * @property string                     $email_confirm_token
 * @property integer                    $created_at
 * @property integer                    $updated_at
 * @property integer                    $logged_at
 * @property string                     $password write-only password
 * @property \common\models\UserProfile $userProfile
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE  = 1;
    const STATUS_UNCONFIRMED = 2;

    const ROLE_USER          = 'user';
    const ROLE_ADMINISTRATOR = 'administrator';

    const EVENT_AFTER_SIGNUP = 'afterSignup';
    const EVENT_AFTER_LOGIN  = 'afterLogin';

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'auth_key' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [ ActiveRecord::EVENT_BEFORE_INSERT => 'auth_key' ],
                'value' => Yii::$app->getSecurity()->generateRandomString()
            ]
        ];
    }

    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            'oauth_create' => [
                'oauth_client',
                'oauth_client_user_id',
                'email',
                'username',
                '!status'
            ]
        ]);
    }

    /**
     * Unique username and Email
     * Default status is Active
     * Status can be Active and Deleted
     */
    public function rules()
    {
        return [
            [ [ 'username', 'email' ], 'unique' ],
            [ 'status', 'default', 'value' => self::STATUS_UNCONFIRMED ],
            [ 'status', 'in', 'range' => array_keys(self::getStatuses()) ],
        ];
    }

    /**
     * Get user profile by id
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::className(), [ 'user_id' => 'id' ]);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne([ 'auth_key' => $token, 'status' => self::STATUS_ACTIVE ]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     *
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne([ 'username' => $username, 'status' => self::STATUS_ACTIVE ]);
    }

    /**
     * Finds user by username or email
     *
     * @param string $login
     *
     * @return static|null
     */
    public static function findByLogin($login)
    {
        return static::findOne([
            'and',
            [ 'or', [ 'username' => $login ], [ 'email' => $login ] ],
            'status' => self::STATUS_ACTIVE
        ]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     *
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire    = 86400;
        $parts     = explode('_', $token);
        $timestamp = (int)end($parts);
        if ($timestamp + $expire < time()) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE
        ]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     *
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->getSecurity()->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatuses(), $this->status);
    }

    /**
     * Returns user statuses list
     *
     * @return array|mixed
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_UNCONFIRMED => 'Unconfirmed',
            self::STATUS_INACTIVE => 'Deleted'
        ];
    }

    /**
     * Send email confirmation to user
     *
     * @param $user
     * @param $layout
     * @param $email
     * @param $subject
     *
     * @return bool
     */
    public static function sendEmail($user, $layout, $email, $subject)
    {
        $mailer  = Yii::$app->mailer;
        $message = $mailer->compose($layout, [ 'user' => $user ])->setTo($email)->setSubject($subject);
        $message->setFrom([ Yii::$app->params[ 'adminEmail' ] => Yii::$app->name ]);

        $result = $message->send();

        return $result;
    }

    /**
     * Creates user profile and application event
     *
     * @param array $profileData
     */
    public function afterSignup(array $profileData = [ ])
    {
        $this->trigger(self::EVENT_AFTER_SIGNUP);

        $profile         = new UserProfile();
        $profile->locale = Yii::$app->language;
        $profile->load($profileData, '');

        $this->link('userProfile', $profile);

        // Default role
        $auth = Yii::$app->authManager;
        $auth->assign($auth->getRole(User::ROLE_USER), $this->getId());
    }

    public function getPublicIdentity()
    {
        if ($this->userProfile && $this->userProfile->getFullname() !== null) {
            return $this->userProfile->getFullname();
        }

        if ($this->username) {
            return $this->username;
        }

        return $this->email;
    }

    /**
     * @param string $email_confirm_token
     *
     * @return static|null
     */
    public static function findByEmailConfirmToken($email_confirm_token)
    {
        return static::findOne([
            'email_confirm_token' => $email_confirm_token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Generates email confirmation token
     */
    public function generateEmailConfirmToken()
    {
        $this->email_confirm_token = Yii::$app->security->generateRandomString();
    }

    /**
     * Removes email confirmation token
     */
    public function removeEmailConfirmToken()
    {
        $this->email_confirm_token = null;
    }
}
