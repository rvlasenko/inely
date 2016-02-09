frontend\modules\user\models\LoginForm
===============

Модель авторизации




* Class name: LoginForm
* Namespace: frontend\modules\user\models
* Parent class: yii\base\Model





Properties
----------


### $email

    public mixed $email





* Visibility: **public**


### $password

    public mixed $password





* Visibility: **public**


### $rememberMe

    public mixed $rememberMe = true





* Visibility: **public**


### $_user

    private mixed $_user = false





* Visibility: **private**


Methods
-------


### rules

    mixed frontend\modules\user\models\LoginForm::rules()





* Visibility: **public**




### validatePassword

    mixed frontend\modules\user\models\LoginForm::validatePassword()

Собственный метод валидации пароля.

Этот метод служит для inline валидации.

* Visibility: **public**




### login

    boolean frontend\modules\user\models\LoginForm::login()

Вход в систему используя полученные и валидированные пароль и имя пользователя.



* Visibility: **public**




### getUser

    \common\models\User|null frontend\modules\user\models\LoginForm::getUser()

Поиск пользователя по [[email]]



* Visibility: **public**



