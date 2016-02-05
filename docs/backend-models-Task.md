backend\models\Task
===============

Класс модели для таблицы &quot;task&quot;




* Class name: Task
* Namespace: backend\models
* Parent class: yii\db\ActiveRecord



Constants
----------


### ACTIVE_TASK

    const ACTIVE_TASK = 0





### COMPLETED_TASK

    const COMPLETED_TASK = 1





### INCOMPLETE_TASK

    const INCOMPLETE_TASK = 2





### PR_HIGH

    const PR_HIGH = 'high'





### PR_MEDIUM

    const PR_MEDIUM = 'medium'





### PR_LOW

    const PR_LOW = 'low'





Properties
----------


### $taskId

    public integer $taskId





* Visibility: **public**


### $listId

    public integer $listId





* Visibility: **public**


### $ownerId

    public integer $ownerId





* Visibility: **public**


### $isDone

    public integer $isDone





* Visibility: **public**


### $priority

    public string $priority





* Visibility: **public**


### $dueDate

    public \backend\models\timestamp $dueDate





* Visibility: **public**


Methods
-------


### behaviors

    mixed backend\models\Task::behaviors()





* Visibility: **public**




### rules

    array backend\models\Task::rules()

Правила валидации для атрибутов.



* Visibility: **public**




### tableName

    mixed backend\models\Task::tableName()





* Visibility: **public**
* This method is **static**.




### getCountOfGroups

    array backend\models\Task::getCountOfGroups()

Получение количества задач по группам.



* Visibility: **public**
* This method is **static**.




### buildTree

    array backend\models\Task::buildTree(array $node, boolean $showHistory)

Преоразование массива задач в объект вида:
[{
     "id":   "240",
     "text": "Child task",
     "a_attr": {
         "note":       "<p>Не забыть</p>",
         "degree":     "high",
         "incomplete": "true",
         "lname":      "новая метка",
         "assignedId": "26",
         "assigned":   "/images/avatars/some.jpg",
         "date":  "5 Янв",
         "rel":   "future",
         "hint":  "осталось 10 дней"
     },
     "icon":     "entypo-chat",
     "children": false
}]



* Visibility: **public**


#### Arguments
* $node **array** - &lt;p&gt;узел, сформированный в результате запроса&lt;/p&gt;
* $showHistory **boolean** - &lt;p&gt;отображение завершенных задач&lt;/p&gt;



### removeCompleted

    mixed backend\models\Task::removeCompleted($condition)





* Visibility: **public**


#### Arguments
* $condition **mixed**



### getProject

    \backend\models\ActiveQuery backend\models\Task::getProject()

Отношение с таблицей "tasks_cat"



* Visibility: **public**




### getTaskData

    \backend\models\ActiveQuery backend\models\Task::getTaskData()

Отношение с таблицей "tasks_data"



* Visibility: **public**




### load

    boolean backend\models\Task::load(array|boolean $data, string $formName)

Запись данных в модель. Метод перегружен от базового класса Model.



* Visibility: **public**


#### Arguments
* $data **array|boolean** - &lt;p&gt;массив данных.&lt;/p&gt;
* $formName **string** - &lt;p&gt;имя формы, использующееся для записи данных в модель.&lt;/p&gt;


