backend\models\TaskData
===============

Класс модели для таблицы &quot;tasks_data&quot;




* Class name: TaskData
* Namespace: backend\models
* Parent class: yii\db\ActiveRecord





Properties
----------


### $dataId

    public integer $dataId





* Visibility: **public**


### $lft

    public integer $lft





* Visibility: **public**


### $rgt

    public integer $rgt





* Visibility: **public**


### $lvl

    public integer $lvl





* Visibility: **public**


### $pid

    public integer $pid





* Visibility: **public**


### $name

    public string $name





* Visibility: **public**


Methods
-------


### behaviors

    mixed backend\models\TaskData::behaviors()





* Visibility: **public**




### tableName

    mixed backend\models\TaskData::tableName()





* Visibility: **public**
* This method is **static**.




### transactions

    mixed backend\models\TaskData::transactions()





* Visibility: **public**




### find

    mixed backend\models\TaskData::find()





* Visibility: **public**
* This method is **static**.




### rules

    mixed backend\models\TaskData::rules()





* Visibility: **public**




### getTasks

    \backend\models\ActiveQuery backend\models\TaskData::getTasks()

Отношение с таблицей "tasks"



* Visibility: **public**




### load

    boolean backend\models\TaskData::load(array $data, string $formName)

Запись данных в модель. Метод перегружен от базового класса Model.



* Visibility: **public**


#### Arguments
* $data **array** - &lt;p&gt;массив данных.&lt;/p&gt;
* $formName **string** - &lt;p&gt;имя формы, использующееся для записи данных в модель.&lt;/p&gt;


