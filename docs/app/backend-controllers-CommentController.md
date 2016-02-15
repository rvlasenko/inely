backend\controllers\CommentController
===============

Class CommentController




* Class name: CommentController
* Namespace: backend\controllers
* Parent class: yii\web\Controller







Methods
-------


### behaviors

    mixed backend\controllers\CommentController::behaviors()





* Visibility: **public**




### actionGetComments

    array|null backend\controllers\CommentController::actionGetComments(integer $taskId)

Формирование комментариев задачи со свойствами в будущий объект и передача инициатору.

Инциатором запроса является callback $.magnificPopup.open в обработчике [[handleOpenSettings()]].

* Visibility: **public**


#### Arguments
* $taskId **integer** - &lt;p&gt;ID задачи, для которой требуется сформировать комментарии.&lt;/p&gt;



### actionSetComment

    array backend\controllers\CommentController::actionSetComment()

Запись комментария к необходимой задаче в базу данных, и передача инициатору запроса.



* Visibility: **public**



