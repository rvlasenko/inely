backend\models\Project
===============

Класс модели для таблицы &quot;projects&quot;.




* Class name: Project
* Namespace: backend\models
* Parent class: yii\db\ActiveRecord





Properties
----------


### $id

    public integer $id





* Visibility: **public**


### $listName

    public string $listName





* Visibility: **public**


### $badgeColor

    public string $badgeColor





* Visibility: **public**


### $ownerId

    public integer $ownerId





* Visibility: **public**


Methods
-------


### rules

    mixed backend\models\Project::rules()





* Visibility: **public**




### tableName

    mixed backend\models\Project::tableName()





* Visibility: **public**
* This method is **static**.




### getTasks

    \backend\models\ActiveQuery backend\models\Project::getTasks()

Отношение с таблицей "tasks"



* Visibility: **public**




### createProjectRoot

    array backend\models\Project::createProjectRoot($userData)

Создание уникального корневого узла проекта.



* Visibility: **private**


#### Arguments
* $userData **mixed**



### createProject

    array backend\models\Project::createProject($data)

Создание проекта.



* Visibility: **public**


#### Arguments
* $data **mixed**



### getAssignedUsers

    array backend\models\Project::getAssignedUsers($listId)





* Visibility: **public**


#### Arguments
* $listId **mixed**



### removeCollaborator

    boolean backend\models\Project::removeCollaborator($userData)

Ищем id пользователя по email, а также id корневого узла проекта и исключаем из списка.



* Visibility: **public**


#### Arguments
* $userData **mixed**



### shareWithUser

    boolean backend\models\Project::shareWithUser($userData)

Ищем id пользователя по email, а также id корневого узла проекта и добавляем в список.



* Visibility: **public**


#### Arguments
* $userData **mixed**



### getCollaborators

    array backend\models\Project::getCollaborators($listId)





* Visibility: **public**


#### Arguments
* $listId **mixed**



### load

    boolean backend\models\Project::load(array|boolean $data, string $formName)

Запись данных в модель. Метод перегружен от базового класса Model.



* Visibility: **public**


#### Arguments
* $data **array|boolean** - &lt;p&gt;массив данных.&lt;/p&gt;
* $formName **string** - &lt;p&gt;имя формы, использующееся для записи данных в модель.&lt;/p&gt;


