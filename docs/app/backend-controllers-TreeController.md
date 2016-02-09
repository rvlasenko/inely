backend\controllers\TreeController
===============

Class TreeController




* Class name: TreeController
* Namespace: backend\controllers
* Parent class: yii\web\Controller





Properties
----------


### $options

    protected array $options = array('structure' => array('id' => 'dataId', 'left' => 'lft', 'right' => 'rgt', 'level' => 'lvl', 'parentId' => 'pid', 'position' => 'pos'))





* Visibility: **protected**


### $root

    protected array $root = array('id' => 27, 'text' => 'Root', 'a_attr' => array('degree' => null, 'date' => null), 'children' => true)





* Visibility: **protected**


Methods
-------


### getNode

    array|null backend\controllers\TreeController::getNode(integer $id, array $options)

Создание экземпляра ActiveRecord таблицы "tasks_data".

Если у узла существуют дочерние элементы, то они формируются в ключе "children" по вызову [[getChildren()]].
Иначе возвращаются только сгруппированные узлы [[getPath()]].

* Visibility: **public**


#### Arguments
* $id **integer** - &lt;p&gt;идентификатор узла&lt;/p&gt;
* $options **array** - &lt;p&gt;дополнительные параметры&lt;/p&gt;



### getChildren

    array|array<mixed,\backend\controllers\ActiveRecord> backend\controllers\TreeController::getChildren(integer $id, boolean $recursive, array $params)

Создание экземпляра ActiveRecord и получение всех дочерних элементов требуемого узла.

Первичное обращение к методу выполняется из Task контроллера действием [[actionNode()]].

* Visibility: **public**


#### Arguments
* $id **integer** - &lt;p&gt;идентификатор узла&lt;/p&gt;
* $recursive **boolean** - &lt;p&gt;параметр задающий рекурсию&lt;/p&gt;
* $params **array** - &lt;p&gt;дополнительные параметры, к примеру, проект или сортировка&lt;/p&gt;



### getProjectChildren

    array|array<mixed,\backend\controllers\ActiveRecord> backend\controllers\TreeController::getProjectChildren(integer $id)

Создание экземпляра ActiveRecord и получение всех дочерних элементов требуемого узла.



* Visibility: **public**


#### Arguments
* $id **integer** - &lt;p&gt;идентификатор узла&lt;/p&gt;



### getPath

    array|array<mixed,\backend\controllers\ActiveRecord> backend\controllers\TreeController::getPath(integer $id)

Создание экземпляра ActiveRecord и получение всех сгруппированных элементов.



* Visibility: **public**


#### Arguments
* $id **integer** - &lt;p&gt;идентификатор узла.&lt;/p&gt;



### actionNode

    mixed backend\controllers\TreeController::actionNode($id)





* Visibility: **public**


#### Arguments
* $id **mixed**



### buildTree

    array backend\controllers\TreeController::buildTree($node)

Кодирует полученный массив в JSON строку.



* Visibility: **public**


#### Arguments
* $node **mixed**



### buildProjectTree

    array backend\controllers\TreeController::buildProjectTree($temp)

Кодирует полученный массив в JSON строку.



* Visibility: **public**


#### Arguments
* $temp **mixed**



### make

    \backend\controllers\id backend\controllers\TreeController::make(integer $parent, integer $position, array $data)

Выполнение SQL запросов по вставке нового узла и обновления позиции существующих.



* Visibility: **public**


#### Arguments
* $parent **integer** - &lt;p&gt;родительский элемент, куда был создан данный узел.&lt;/p&gt;
* $position **integer** - &lt;p&gt;позиция узла, куда он был впоследствии перемещен.&lt;/p&gt;
* $data **array** - &lt;p&gt;некоторые кастомные атрибуты.&lt;/p&gt;



### rename

    boolean backend\controllers\TreeController::rename(integer $id, array $data)

Выполнение SQL запросов для переименования данного узла.



* Visibility: **public**


#### Arguments
* $id **integer** - &lt;p&gt;идентификатор узла, который был переименован.&lt;/p&gt;
* $data **array** - &lt;p&gt;некоторые атрибуты, например, новое имя.&lt;/p&gt;



### move

    boolean backend\controllers\TreeController::move(integer $id, integer $parent, integer $position)

Выполнение SQL запросов для перемещения узла в указанную позицию некоего родителя.



* Visibility: **public**


#### Arguments
* $id **integer** - &lt;p&gt;идентификатор узла, который был перемещен&lt;/p&gt;
* $parent **integer** - &lt;p&gt;родительский элемент, куда был перемещен данный узел.&lt;/p&gt;
* $position **integer** - &lt;p&gt;позиция узла, куда он был впоследствии перемещен.&lt;/p&gt;



### remove

    boolean backend\controllers\TreeController::remove(integer $id)

Выполнение SQL запросов на удаление узла дерева и всех его дочерних элементов.



* Visibility: **public**


#### Arguments
* $id **integer** - &lt;p&gt;идентификатор узла, который был удален.&lt;/p&gt;



### updateRightIndexes

    integer backend\controllers\TreeController::updateRightIndexes(array $parent, integer $position)

Обновление структуры правых индексов.



* Visibility: **protected**


#### Arguments
* $parent **array** - &lt;p&gt;родительский элемент, куда был перемещен данный узел.&lt;/p&gt;
* $position **integer** - &lt;p&gt;позиция узла, куда он был впоследствии перемещен.&lt;/p&gt;



### updateLeftIndexes

    integer backend\controllers\TreeController::updateLeftIndexes(array $parent, integer $position)

Обновление структуры левых индексов.



* Visibility: **protected**


#### Arguments
* $parent **array** - &lt;p&gt;родительский элемент, куда был перемещен данный узел.&lt;/p&gt;
* $position **integer** - &lt;p&gt;позиция узла, куда он был впоследствии перемещен.&lt;/p&gt;



### checkParam

    string|boolean backend\controllers\TreeController::checkParam(string $param)

Метод обрабатывает GET параметр на наличие необходимых значений.



* Visibility: **protected**
* This method is **static**.


#### Arguments
* $param **string** - &lt;p&gt;параметр, который требуется проверить.&lt;/p&gt;


