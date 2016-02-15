backend\controllers\ProjectController
===============

Class ProjectController




* Class name: ProjectController
* Namespace: backend\controllers
* Parent class: yii\web\Controller







Methods
-------


### behaviors

    mixed backend\controllers\ProjectController::behaviors()





* Visibility: **public**




### actionEdit

    boolean backend\controllers\ProjectController::actionEdit()

Валидация принятых атрибутов и добавление их значений в соответствующие поля базы данных.

В случае несоответствия формату, поле игнорируется и выбрасывается исключение.

* Visibility: **public**




### actionCreate

    array backend\controllers\ProjectController::actionCreate()

Создание нового проекта и его уникального корневого узла.



* Visibility: **public**




### actionDelete

    boolean backend\controllers\ProjectController::actionDelete()

Удаление существующего проекта и его корневого узла.



* Visibility: **public**




### actionShare

    boolean backend\controllers\ProjectController::actionShare()

Приглашение пользователя к совместной работе над проектом.

Такие пользователи, могут добавлять, удалять и завершать задачи из этого списка.

* Visibility: **public**




### actionRemoveCollaborator

    boolean backend\controllers\ProjectController::actionRemoveCollaborator()

Исключение пользователя из совместного проекта.



* Visibility: **public**




### actionGetCollaborators

    array|null backend\controllers\ProjectController::actionGetCollaborators(integer $listId)

Возвращение списка пользователей, которые имеющих доступ к проекту, включая владельца.

Он может взаимодействовать с юзерами, добавлять и удалять их. (Пока не более двух)

* Visibility: **public**


#### Arguments
* $listId **integer** - &lt;p&gt;ID проекта (списка), по которому группируются требуемые задачи.&lt;/p&gt;



### actionGetAssigned

    array backend\controllers\ProjectController::actionGetAssigned(integer $listId)

Возвращение списка пользователей, имеющих доступ к проекту, включая владельца.

Первым элементом в списке пользователей, которых можно назначить на задачу, следует "отключающий".

* Visibility: **public**


#### Arguments
* $listId **integer** - &lt;p&gt;ID проекта (списка), по которому группируются требуемые задачи.&lt;/p&gt;



### findModel

    null|static backend\controllers\ProjectController::findModel(integer $id)

Поиск модели пользователя по его PK.

Если модель не найдена, будет сгенерировано исключение.

* Visibility: **protected**


#### Arguments
* $id **integer**


