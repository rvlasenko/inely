frontend\modules\user\models\PasswordResetRequestForm
===============

Модель передачи токена для сброса пароля.




* Class name: PasswordResetRequestForm
* Namespace: frontend\modules\user\models
* Parent class: yii\base\Model





Properties
----------


### $email

    public mixed $email





* Visibility: **public**


Methods
-------


### rules

    mixed frontend\modules\user\models\PasswordResetRequestForm::rules()





* Visibility: **public**




### sendEmail

    true frontend\modules\user\models\PasswordResetRequestForm::sendEmail()

Передача сообщения о востановлении данных на email со ссылкой для сброса пароля.

Перед отправкой пользователю генерируется уникальный хэш для пароля.

* Visibility: **public**



