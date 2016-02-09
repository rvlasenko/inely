frontend\modules\user\controllers\SignInController
===============






* Class name: SignInController
* Namespace: frontend\modules\user\controllers
* Parent class: [frontend\modules\user\controllers\AuthController](frontend-modules-user-controllers-AuthController.md)





Properties
----------


### $layout

    public mixed $layout = 'main'





* Visibility: **public**


Methods
-------


### actionLogin

    array|string|\yii\web\Response frontend\modules\user\controllers\SignInController::actionLogin()

Вход в систему, используя принятые данные.

Также выполняется проверка модели и возвращается массив сообщений об ошибке в JSON формате.

* Visibility: **public**




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


