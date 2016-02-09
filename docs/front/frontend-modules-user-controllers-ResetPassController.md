frontend\modules\user\controllers\ResetPassController
===============






* Class name: ResetPassController
* Namespace: frontend\modules\user\controllers
* Parent class: [frontend\modules\user\controllers\AuthController](frontend-modules-user-controllers-AuthController.md)





Properties
----------


### $layout

    public mixed $layout = 'main'





* Visibility: **public**


Methods
-------


### actionRequestPasswordReset

    string|\yii\web\Response frontend\modules\user\controllers\ResetPassController::actionRequestPasswordReset()

Передача сообщения о востановлении данных на email со ссылкой для сброса пароля.



* Visibility: **public**




### actionResetPassword

    string|\yii\web\Response frontend\modules\user\controllers\ResetPassController::actionResetPassword($token)

Сброс пароля и запись flash сообщения.



* Visibility: **public**


#### Arguments
* $token **mixed** - &lt;p&gt;уникальный токен.&lt;/p&gt;



### actions

    mixed frontend\modules\user\controllers\AuthController::actions()





* Visibility: **public**
* This method is defined by [frontend\modules\user\controllers\AuthController](frontend-modules-user-controllers-AuthController.md)




### behaviors

    mixed frontend\modules\user\controllers\AuthController::behaviors()





* Visibility: **public**
* This method is defined by [frontend\modules\user\controllers\AuthController](frontend-modules-user-controllers-AuthController.md)




### setInfoFacebook

    object frontend\modules\user\controllers\AuthController::setInfoFacebook(array $attributes, object $user)

Запись набора пользовательской информации полученной через OAuth от facebook.



* Visibility: **protected**
* This method is defined by [frontend\modules\user\controllers\AuthController](frontend-modules-user-controllers-AuthController.md)


#### Arguments
* $attributes **array** - &lt;p&gt;массив пользовательских данных.&lt;/p&gt;
* $user **object** - &lt;p&gt;объект пользователя.&lt;/p&gt;



### setInfoGoogle

    object frontend\modules\user\controllers\AuthController::setInfoGoogle(array $attributes, object $user)

Запись набора пользовательской информации полученной от google.



* Visibility: **protected**
* This method is defined by [frontend\modules\user\controllers\AuthController](frontend-modules-user-controllers-AuthController.md)


#### Arguments
* $attributes **array** - &lt;p&gt;массив пользовательских данных.&lt;/p&gt;
* $user **object** - &lt;p&gt;объект пользователя.&lt;/p&gt;



### setInfoVk

    object frontend\modules\user\controllers\AuthController::setInfoVk(array $attributes, object $user)

Запись набора пользовательской информации полученной от vk.com.



* Visibility: **protected**
* This method is defined by [frontend\modules\user\controllers\AuthController](frontend-modules-user-controllers-AuthController.md)


#### Arguments
* $attributes **array** - &lt;p&gt;массив пользовательских данных.&lt;/p&gt;
* $user **object** - &lt;p&gt;объект пользователя.&lt;/p&gt;



### successOAuthCallback

    \yii\web\Response frontend\modules\user\controllers\AuthController::successOAuthCallback($client)

Callback метод успешной регистрации через OAuth.



* Visibility: **public**
* This method is defined by [frontend\modules\user\controllers\AuthController](frontend-modules-user-controllers-AuthController.md)


#### Arguments
* $client **mixed** - &lt;p&gt;\yii\authclient\BaseClient&lt;/p&gt;


