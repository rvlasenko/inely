backend\models\TaskComments
===============

Класс модели для таблицы &quot;task_comments&quot;




* Class name: TaskComments
* Namespace: backend\models
* Parent class: yii\db\ActiveRecord



Constants
----------


### ICON_CLASS

    const ICON_CLASS = 'entypo-chat'





Properties
----------


### $commentId

    public integer $commentId





* Visibility: **public**


### $taskId

    public integer $taskId





* Visibility: **public**


### $userId

    public integer $userId





* Visibility: **public**


### $comment

    public string $comment





* Visibility: **public**


### $timePosted

    public string $timePosted





* Visibility: **public**


### $task

    public \backend\models\Tasks $task





* Visibility: **public**


Methods
-------


### tableName

    mixed backend\models\TaskComments::tableName()





* Visibility: **public**
* This method is **static**.




### rules

    mixed backend\models\TaskComments::rules()





* Visibility: **public**




### getComments

    array backend\models\TaskComments::getComments($taskId)

Ищем комментарии к полученной задаче, формируем JSON и отправляем



* Visibility: **public**


#### Arguments
* $taskId **mixed**



### setComment

    array backend\models\TaskComments::setComment($data)





* Visibility: **public**


#### Arguments
* $data **mixed**



### getTask

    \yii\db\ActiveQuery backend\models\TaskComments::getTask()





* Visibility: **public**




### load

    boolean backend\models\TaskComments::load(array $data, string $formName)

Запись данных в модель. Метод перегружен от базового класса Model.



* Visibility: **public**


#### Arguments
* $data **array** - &lt;p&gt;массив данных.&lt;/p&gt;
* $formName **string** - &lt;p&gt;имя формы, использующееся для записи данных в модель.&lt;/p&gt;


