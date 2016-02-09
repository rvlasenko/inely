frontend\modules\user\models\ResetPasswordForm
===============

Модель сброса пароля




* Class name: ResetPasswordForm
* Namespace: frontend\modules\user\models
* Parent class: yii\base\Model





Properties
----------


### $password

    public mixed $password





* Visibility: **public**


### $passwordConfirm

    public mixed $passwordConfirm





* Visibility: **public**


### $_user

    private \common\models\User $_user





* Visibility: **private**


Methods
-------


### __construct

    mixed frontend\modules\user\models\ResetPasswordForm::__construct(string $token, array $config)

Конструктор создания модели по данному токену.



* Visibility: **public**


#### Arguments
* $token **string** - &lt;p&gt;уникальный токен.&lt;/p&gt;
* $config **array** - &lt;p&gt;пары имен-значений, которые будут использоваться для инициализации свойств объектов.&lt;/p&gt;



### rules

    mixed frontend\modules\user\models\ResetPasswordForm::rules()





* Visibility: **public**




### resetPassword

    boolean frontend\modules\user\models\ResetPasswordForm::resetPassword()

Сброс пароля.



* Visibility: **public**



