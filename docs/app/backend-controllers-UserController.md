backend\controllers\UserController
===============

Class UserController




* Class name: UserController
* Namespace: backend\controllers
* Parent class: yii\web\Controller





Properties
----------


### $defaultAction

    public mixed $defaultAction = 'profile'





* Visibility: **public**


Methods
-------


### behaviors

    mixed backend\controllers\UserController::behaviors()





* Visibility: **public**




### actionProfile

    string backend\controllers\UserController::actionProfile()

Отображение одиночной модели пользователя.



* Visibility: **public**




### actionAccount

    mixed backend\controllers\UserController::actionAccount()

Обновление существующей модели пользовательского профиля.



* Visibility: **public**




### actionLogout

    \backend\controllers\редирект backend\controllers\UserController::actionLogout()

Выход из системы и удаление аутентификационных данных.



* Visibility: **public**




### actionUpload

    string backend\controllers\UserController::actionUpload()

Загрузка аватарки на сервер и смена пути к ней в профиле БД.

Если загрузка осуществилась успешно, плагину DropZone отправляется имя файла в JSON.

* Visibility: **public**




### findModel

    \backend\controllers\модель backend\controllers\UserController::findModel(integer $id)

Поиск модели пользователя по его PK.

Если модель не найдена, будет сгенерировано исключение.

* Visibility: **protected**


#### Arguments
* $id **integer**


