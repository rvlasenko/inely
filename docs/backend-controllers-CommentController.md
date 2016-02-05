backend\controllers\CommentController
===============

Class CommentController




* Class name: CommentController
* Namespace: backend\controllers
* Parent class: [backend\controllers\TaskController](backend-controllers-TaskController.md)





Properties
----------


### $userId

    public mixed $userId





* Visibility: **public**


### $layout

    public mixed $layout = 'task'





* Visibility: **public**


Methods
-------


### behaviors

    mixed backend\controllers\TaskController::behaviors()





* Visibility: **public**
* This method is defined by [backend\controllers\TaskController](backend-controllers-TaskController.md)




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




### init

    mixed backend\controllers\TaskController::init()





* Visibility: **public**
* This method is defined by [backend\controllers\TaskController](backend-controllers-TaskController.md)




### actions

    mixed backend\controllers\TaskController::actions()





* Visibility: **public**
* This method is defined by [backend\controllers\TaskController](backend-controllers-TaskController.md)




### actionIndex

    string backend\controllers\TaskController::actionIndex()

Визуализация контента менеджера задач и передача списка проектов пользователя в layout блок.

Установка глабольных параметров, для приветствия пользователя и определения назначенных задач.

Единственный экшн, чьи ответные данные будут рассматриваться без преобразования.
Т.е. заголовок "Content-Type" примет вид "text/html", а не "application/json".

* Visibility: **public**
* This method is defined by [backend\controllers\TaskController](backend-controllers-TaskController.md)




### actionNode

    array backend\controllers\TaskController::actionNode(integer $id, string $sort, integer $listId, string $group)

Формирование объекта, содержащего в себе данные об узле, eg. имя, дата и т.д.

Первое обращение содержит параметр id со значением #, на этом этапе формируется корень.
При последующих обращениях выполняется поиск дочерних веток дерева у элемента с принятым id.
Является источником данных для [[$.jstree.core.data]].

* Visibility: **public**
* This method is defined by [backend\controllers\TaskController](backend-controllers-TaskController.md)


#### Arguments
* $id **integer** - &lt;p&gt;Уникальный идентификатор задачи.&lt;/p&gt;
* $sort **string** - &lt;p&gt;Сортировка по условию. По умолчанию происходит по левому индексу.&lt;/p&gt;
* $listId **integer** - &lt;p&gt;Уникальный идентификатор проекта (списка), по которому группируются задачи.&lt;/p&gt;
* $group **string** - &lt;p&gt;Распределение задач по группам: входящие, сегодня, неделя.&lt;/p&gt;



### actionEdit

    boolean backend\controllers\TaskController::actionEdit()

Валидация принятых атрибутов и массовое их присваивание.

В случае несоответствия формату, поле игнорируется и выбрасывается исключение.

* Visibility: **public**
* This method is defined by [backend\controllers\TaskController](backend-controllers-TaskController.md)




### actionDone

    boolean backend\controllers\TaskController::actionDone()

Поиск задачи по идентификатору для присовения выполненного статуса.



* Visibility: **public**
* This method is defined by [backend\controllers\TaskController](backend-controllers-TaskController.md)




### actionCreate

    array backend\controllers\TaskController::actionCreate()

Создание новой вложенной задачи в иную родительскую задачу, либо в корень.

Устанавливаем реляции в таблице "task_data", обновляем индексы.
Также принимаем параметры Smarty Add, если обнаружена метка, добавляем её во внешнюю таблицу.

* Visibility: **public**
* This method is defined by [backend\controllers\TaskController](backend-controllers-TaskController.md)




### actionMove

    boolean backend\controllers\TaskController::actionMove()

Перемещение задачи с помощью Drag'n'Drop.

Ищем существующие задачи в базе и присваиваем новые индексы.

* Visibility: **public**
* This method is defined by [backend\controllers\TaskController](backend-controllers-TaskController.md)




### actionDelete

    mixed|null backend\controllers\TaskController::actionDelete()

Удаление существующей задачи и всех её дочерних со статусом завершенности от 1 до 2.

Опциональный параметр - удаление всех завершенных задач в группах, либо в проектах.

* Visibility: **public**
* This method is defined by [backend\controllers\TaskController](backend-controllers-TaskController.md)




### actionGetTaskCount

    array backend\controllers\TaskController::actionGetTaskCount()

Получение количества задач в каждой группе [[getCountOfGroups()]].

Нормализация данных и отправка в jQuery.getJSON().

* Visibility: **public**
* This method is defined by [backend\controllers\TaskController](backend-controllers-TaskController.md)




### actionGetHistory

    array backend\controllers\TaskController::actionGetHistory(integer $id, integer $listId)

Формирование объекта, содержащего в себе данные о завершенных задачах.

Первое обращение содержит параметр id со значением #, на этом этапе формируется корень.
При последующих обращениях выполняется поиск дочерних веток дерева у элемента с принятым id.

* Visibility: **public**
* This method is defined by [backend\controllers\TaskController](backend-controllers-TaskController.md)


#### Arguments
* $id **integer** - &lt;p&gt;ID задачи.&lt;/p&gt;
* $listId **integer** - &lt;p&gt;ID проекта (списка), по которому группируются требуемые задачи.&lt;/p&gt;



### beforeAction

    boolean backend\controllers\TaskController::beforeAction(\yii\base\Action $action)





* Visibility: **public**
* This method is defined by [backend\controllers\TaskController](backend-controllers-TaskController.md)


#### Arguments
* $action **yii\base\Action**


