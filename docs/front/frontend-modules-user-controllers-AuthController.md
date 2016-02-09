frontend\modules\user\controllers\AuthController
===============






* Class name: AuthController
* Namespace: frontend\modules\user\controllers
* Parent class: yii\web\Controller





Properties
----------


### $layout

    public mixed $layout = 'main'





* Visibility: **public**


Methods
-------


### actions

    mixed frontend\modules\user\controllers\AuthController::actions()





* Visibility: **public**




### behaviors

    mixed frontend\modules\user\controllers\AuthController::behaviors()





* Visibility: **public**




### setInfoFacebook

    object frontend\modules\user\controllers\AuthController::setInfoFacebook(array $attributes, object $user)

Запись набора пользовательской информации полученной через OAuth от facebook.



* Visibility: **protected**


#### Arguments
* $attributes **array** - &lt;p&gt;массив пользовательских данных.&lt;/p&gt;
* $user **object** - &lt;p&gt;объект пользователя.&lt;/p&gt;



### setInfoGoogle

    object frontend\modules\user\controllers\AuthController::setInfoGoogle(array $attributes, object $user)

Запись набора пользовательской информации полученной от google.



* Visibility: **protected**


#### Arguments
* $attributes **array** - &lt;p&gt;массив пользовательских данных.&lt;/p&gt;
* $user **object** - &lt;p&gt;объект пользователя.&lt;/p&gt;



### setInfoVk

    object frontend\modules\user\controllers\AuthController::setInfoVk(array $attributes, object $user)

Запись набора пользовательской информации полученной от vk.com.



* Visibility: **protected**


#### Arguments
* $attributes **array** - &lt;p&gt;массив пользовательских данных.&lt;/p&gt;
* $user **object** - &lt;p&gt;объект пользователя.&lt;/p&gt;



### successOAuthCallback

    \yii\web\Response frontend\modules\user\controllers\AuthController::successOAuthCallback($client)

Callback метод успешной регистрации через OAuth.



* Visibility: **public**


#### Arguments
* $client **mixed** - &lt;p&gt;\yii\authclient\BaseClient&lt;/p&gt;


