backend\models\TaskLabels
===============

Класс модели для таблицы &quot;task_labels&quot;.




* Class name: TaskLabels
* Namespace: backend\models
* Parent class: yii\db\ActiveRecord





Properties
----------


### $labelId

    public integer $labelId





* Visibility: **public**


### $ownerId

    public integer $ownerId





* Visibility: **public**


### $labelName

    public string $labelName





* Visibility: **public**


### $badgeColor

    public string $badgeColor





* Visibility: **public**


Methods
-------


### tableName

    mixed backend\models\TaskLabels::tableName()





* Visibility: **public**
* This method is **static**.




### rules

    mixed backend\models\TaskLabels::rules()





* Visibility: **public**




### setLabel

    boolean backend\models\TaskLabels::setLabel(array $data)

Установка к задаче контекстной метки во внешнюю таблицу, при наличии.



* Visibility: **public**


#### Arguments
* $data **array** - &lt;p&gt;Атрибуты для метки, ID задачи и название метки&lt;/p&gt;



### load

    boolean backend\models\TaskLabels::load(array|boolean $data, string $formName)

Запись данных в модель. Метод перегружен от базового класса Model.



* Visibility: **public**


#### Arguments
* $data **array|boolean** - &lt;p&gt;массив данных.&lt;/p&gt;
* $formName **string** - &lt;p&gt;имя формы, использующееся для записи данных в модель.&lt;/p&gt;


