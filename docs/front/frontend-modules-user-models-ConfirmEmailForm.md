frontend\modules\user\models\ConfirmEmailForm
===============

Модель сброса пароля




* Class name: ConfirmEmailForm
* Namespace: frontend\modules\user\models
* Parent class: yii\base\Model





Properties
----------


### $_user

    private \common\models\User $_user





* Visibility: **private**


Methods
-------


### __construct

    mixed frontend\modules\user\models\ConfirmEmailForm::__construct(string $token, array $config)

Конструктор создания модели по данному токену.



* Visibility: **public**


#### Arguments
* $token **string** - &lt;p&gt;уникальный токен.&lt;/p&gt;
* $config **array** - &lt;p&gt;пары имен-значений, которые будут использоваться для инициализации свойств объектов.&lt;/p&gt;



### confirmEmail

    boolean frontend\modules\user\models\ConfirmEmailForm::confirmEmail()

Сброс токена, который предназначен для подтверждения email.



* Visibility: **public**



