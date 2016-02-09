frontend\models\ContactForm
===============






* Class name: ContactForm
* Namespace: frontend\models
* Parent class: yii\base\Model





Properties
----------


### $name

    public mixed $name





* Visibility: **public**


### $email

    public mixed $email





* Visibility: **public**


### $subject

    public mixed $subject





* Visibility: **public**


### $body

    public mixed $body





* Visibility: **public**


### $verifyCode

    public mixed $verifyCode





* Visibility: **public**


Methods
-------


### rules

    array frontend\models\ContactForm::rules()

Имя, email и тело письма обязательны



* Visibility: **public**




### contact

    boolean frontend\models\ContactForm::contact(string $email)

Отправка email на указанную электронную почту используя информацию, полученной этой моделью.



* Visibility: **public**


#### Arguments
* $email **string** - &lt;p&gt;целевой адрес email.&lt;/p&gt;


