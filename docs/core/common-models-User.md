common\models\User
===============

User model




* Class name: User
* Namespace: common\models
* Parent class: yii\db\ActiveRecord
* This class implements: yii\web\IdentityInterface


Constants
----------


### STATUS_INACTIVE

    const STATUS_INACTIVE = 0





### STATUS_ACTIVE

    const STATUS_ACTIVE = 1





### STATUS_UNCONFIRMED

    const STATUS_UNCONFIRMED = 2





### ROLE_USER

    const ROLE_USER = 'user'





### ROLE_ADMINISTRATOR

    const ROLE_ADMINISTRATOR = 'administrator'





### EVENT_AFTER_SIGNUP

    const EVENT_AFTER_SIGNUP = 'afterSignup'





### EVENT_AFTER_LOGIN

    const EVENT_AFTER_LOGIN = 'afterLogin'





Properties
----------


### $id

    public integer $id





* Visibility: **public**


### $username

    public string $username





* Visibility: **public**


### $password_hash

    public string $password_hash





* Visibility: **public**


### $password_reset_token

    public string $password_reset_token





* Visibility: **public**


### $email

    public string $email





* Visibility: **public**


### $auth_key

    public string $auth_key





* Visibility: **public**


### $publicIdentity

    public string $publicIdentity





* Visibility: **public**


### $status

    public integer $status





* Visibility: **public**


### $email_confirm_token

    public string $email_confirm_token





* Visibility: **public**


### $created_at

    public integer $created_at





* Visibility: **public**


### $updated_at

    public integer $updated_at





* Visibility: **public**


### $logged_at

    public integer $logged_at





* Visibility: **public**


### $password

    public string $password

write-only password



* Visibility: **public**


### $userProfile

    public \common\models\UserProfile $userProfile





* Visibility: **public**


Methods
-------


### tableName

    mixed common\models\User::tableName()





* Visibility: **public**
* This method is **static**.




### behaviors

    mixed common\models\User::behaviors()





* Visibility: **public**




### scenarios

    mixed common\models\User::scenarios()





* Visibility: **public**




### rules

    mixed common\models\User::rules()

Unique username and Email
Default status is Active
Status can be Active and Deleted



* Visibility: **public**




### getUserProfile

    \yii\db\ActiveQuery common\models\User::getUserProfile()

Get user profile by id



* Visibility: **public**




### findIdentity

    mixed common\models\User::findIdentity($id)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $id **mixed**



### findIdentityByAccessToken

    mixed common\models\User::findIdentityByAccessToken($token, $type)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $token **mixed**
* $type **mixed**



### findByUsername

    static|null common\models\User::findByUsername(string $username)

Finds user by username



* Visibility: **public**
* This method is **static**.


#### Arguments
* $username **string**



### findByEmail

    mixed common\models\User::findByEmail($email)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $email **mixed**



### findByLogin

    static|null common\models\User::findByLogin(string $login)

Finds user by username or email



* Visibility: **public**
* This method is **static**.


#### Arguments
* $login **string**



### findByPasswordResetToken

    static|null common\models\User::findByPasswordResetToken(string $token)

Finds user by password reset token



* Visibility: **public**
* This method is **static**.


#### Arguments
* $token **string** - &lt;p&gt;password reset token&lt;/p&gt;



### getId

    mixed common\models\User::getId()





* Visibility: **public**




### setActive

    mixed common\models\User::setActive()





* Visibility: **public**




### getAuthKey

    mixed common\models\User::getAuthKey()





* Visibility: **public**




### validateAuthKey

    mixed common\models\User::validateAuthKey($authKey)





* Visibility: **public**


#### Arguments
* $authKey **mixed**



### validatePassword

    boolean common\models\User::validatePassword(string $password)

Validates password



* Visibility: **public**


#### Arguments
* $password **string** - &lt;p&gt;password to validate&lt;/p&gt;



### setPassword

    mixed common\models\User::setPassword(string $password)

Generates password hash from password and sets it to the model



* Visibility: **public**


#### Arguments
* $password **string**



### generatePasswordResetToken

    mixed common\models\User::generatePasswordResetToken()

Generates new password reset token



* Visibility: **public**




### removePasswordResetToken

    mixed common\models\User::removePasswordResetToken()

Removes password reset token



* Visibility: **public**




### getStatusName

    mixed common\models\User::getStatusName()





* Visibility: **public**




### getStatuses

    array|mixed common\models\User::getStatuses()

Returns user statuses list



* Visibility: **public**
* This method is **static**.




### afterSignup

    mixed common\models\User::afterSignup(array $profileData, $userData)





* Visibility: **public**


#### Arguments
* $profileData **array**
* $userData **mixed**



### getPublicIdentity

    mixed common\models\User::getPublicIdentity()





* Visibility: **public**




### findByEmailConfirmToken

    static|null common\models\User::findByEmailConfirmToken(string $email_confirm_token)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $email_confirm_token **string**



### generateEmailConfirmToken

    mixed common\models\User::generateEmailConfirmToken()

Generates email confirmation token



* Visibility: **public**




### removeEmailConfirmToken

    mixed common\models\User::removeEmailConfirmToken()

Removes email confirmation token



* Visibility: **public**



