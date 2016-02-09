frontend\modules\user\models\SignupForm
===============

Модель регистрации




* Class name: SignupForm
* Namespace: frontend\modules\user\models
* Parent class: yii\base\Model





Properties
----------


### $username

    public mixed $username





* Visibility: **public**


### $email

    public mixed $email





* Visibility: **public**


### $password

    public mixed $password





* Visibility: **public**


### $passwordConfirm

    public mixed $passwordConfirm





* Visibility: **public**


Methods
-------


### rules

    mixed frontend\modules\user\models\SignupForm::rules()





* Visibility: **public**




### signup

    \common\models\User|null frontend\modules\user\models\SignupForm::signup()

Запись полученных данных в базу данных и отправка письма подтверждения с уникальным хэшем.



* Visibility: **public**



