common\components\nested\NestedSetBehavior
===============

NestedSetsBehavior




* Class name: NestedSetBehavior
* Namespace: common\components\nested
* Parent class: yii\base\Behavior



Constants
----------


### OPERATION_MAKE_ROOT

    const OPERATION_MAKE_ROOT = 'makeRoot'





### OPERATION_PREPEND_TO

    const OPERATION_PREPEND_TO = 'prependTo'





### OPERATION_APPEND_TO

    const OPERATION_APPEND_TO = 'appendTo'





### OPERATION_INSERT_BEFORE

    const OPERATION_INSERT_BEFORE = 'insertBefore'





### OPERATION_INSERT_AFTER

    const OPERATION_INSERT_AFTER = 'insertAfter'





### OPERATION_DELETE_WITH_CHILDREN

    const OPERATION_DELETE_WITH_CHILDREN = 'deleteWithChildren'





Properties
----------


### $treeAttribute

    public string $treeAttribute = false





* Visibility: **public**


### $leftAttribute

    public string $leftAttribute = 'lft'





* Visibility: **public**


### $rightAttribute

    public string $rightAttribute = 'rgt'





* Visibility: **public**


### $depthAttribute

    public string $depthAttribute = 'depth'





* Visibility: **public**


### $operation

    protected string $operation





* Visibility: **protected**


### $node

    protected \yii\db\ActiveRecord $node





* Visibility: **protected**


### $owner

    public \yii\db\ActiveRecord $owner





* Visibility: **public**


Methods
-------


### events

    mixed common\components\nested\NestedSetBehavior::events()





* Visibility: **public**




### makeRoot

    boolean common\components\nested\NestedSetBehavior::makeRoot(boolean $runValidation, array $attributes)

Creates the root node if the active record is new or moves it
as the root node.



* Visibility: **public**


#### Arguments
* $runValidation **boolean**
* $attributes **array**



### prependTo

    boolean common\components\nested\NestedSetBehavior::prependTo(\yii\db\ActiveRecord $node, boolean $runValidation, array $attributes)

Creates a node as the first child of the target node if the active
record is new or moves it as the first child of the target node.



* Visibility: **public**


#### Arguments
* $node **yii\db\ActiveRecord**
* $runValidation **boolean**
* $attributes **array**



### appendTo

    boolean common\components\nested\NestedSetBehavior::appendTo(\yii\db\ActiveRecord $node, boolean $runValidation, array $attributes)

Creates a node as the last child of the target node if the active
record is new or moves it as the last child of the target node.



* Visibility: **public**


#### Arguments
* $node **yii\db\ActiveRecord**
* $runValidation **boolean**
* $attributes **array**



### insertBefore

    boolean common\components\nested\NestedSetBehavior::insertBefore(\yii\db\ActiveRecord $node, boolean $runValidation, array $attributes)

Creates a node as the previous sibling of the target node if the active
record is new or moves it as the previous sibling of the target node.



* Visibility: **public**


#### Arguments
* $node **yii\db\ActiveRecord**
* $runValidation **boolean**
* $attributes **array**



### insertAfter

    boolean common\components\nested\NestedSetBehavior::insertAfter(\yii\db\ActiveRecord $node, boolean $runValidation, array $attributes)

Creates a node as the next sibling of the target node if the active
record is new or moves it as the next sibling of the target node.



* Visibility: **public**


#### Arguments
* $node **yii\db\ActiveRecord**
* $runValidation **boolean**
* $attributes **array**



### deleteWithChildren

    integer|false common\components\nested\NestedSetBehavior::deleteWithChildren()

Deletes a node and its children.



* Visibility: **public**




### deleteWithChildrenInternal

    integer|false common\components\nested\NestedSetBehavior::deleteWithChildrenInternal()





* Visibility: **public**




### parents

    \yii\db\ActiveQuery common\components\nested\NestedSetBehavior::parents(integer|null $depth)

Gets the parents of the node.



* Visibility: **public**


#### Arguments
* $depth **integer|null** - &lt;p&gt;the depth&lt;/p&gt;



### children

    \yii\db\ActiveQuery common\components\nested\NestedSetBehavior::children(array $data, array $depth)

Gets the children of the node.



* Visibility: **public**


#### Arguments
* $data **array**
* $depth **array**



### leaves

    \yii\db\ActiveQuery common\components\nested\NestedSetBehavior::leaves()

Gets the leaves of the node.



* Visibility: **public**




### prev

    \yii\db\ActiveQuery common\components\nested\NestedSetBehavior::prev()

Gets the previous sibling of the node.



* Visibility: **public**




### next

    \yii\db\ActiveQuery common\components\nested\NestedSetBehavior::next()

Gets the next sibling of the node.



* Visibility: **public**




### isRoot

    boolean common\components\nested\NestedSetBehavior::isRoot()

Determines whether the node is root.



* Visibility: **public**




### isChildOf

    boolean common\components\nested\NestedSetBehavior::isChildOf(\yii\db\ActiveRecord $node)

Determines whether the node is child of the parent node.



* Visibility: **public**


#### Arguments
* $node **yii\db\ActiveRecord** - &lt;p&gt;the parent node&lt;/p&gt;



### isLeaf

    boolean common\components\nested\NestedSetBehavior::isLeaf()

Determines whether the node is leaf.



* Visibility: **public**




### beforeInsert

    mixed common\components\nested\NestedSetBehavior::beforeInsert()





* Visibility: **public**




### beforeInsertRootNode

    mixed common\components\nested\NestedSetBehavior::beforeInsertRootNode()





* Visibility: **protected**




### beforeInsertNode

    mixed common\components\nested\NestedSetBehavior::beforeInsertNode(integer $value, integer $depth)





* Visibility: **protected**


#### Arguments
* $value **integer**
* $depth **integer**



### afterInsert

    mixed common\components\nested\NestedSetBehavior::afterInsert()





* Visibility: **public**




### beforeUpdate

    mixed common\components\nested\NestedSetBehavior::beforeUpdate()





* Visibility: **public**




### afterUpdate

    void common\components\nested\NestedSetBehavior::afterUpdate()





* Visibility: **public**




### moveNodeAsRoot

    void common\components\nested\NestedSetBehavior::moveNodeAsRoot()





* Visibility: **protected**




### moveNode

    mixed common\components\nested\NestedSetBehavior::moveNode(integer $value, integer $depth)





* Visibility: **protected**


#### Arguments
* $value **integer**
* $depth **integer**



### beforeDelete

    mixed common\components\nested\NestedSetBehavior::beforeDelete()





* Visibility: **public**




### afterDelete

    void common\components\nested\NestedSetBehavior::afterDelete()





* Visibility: **public**




### shiftLeftRightAttribute

    mixed common\components\nested\NestedSetBehavior::shiftLeftRightAttribute(integer $value, integer $delta)





* Visibility: **protected**


#### Arguments
* $value **integer**
* $delta **integer**



### applyTreeAttributeCondition

    mixed common\components\nested\NestedSetBehavior::applyTreeAttributeCondition(array $condition)





* Visibility: **protected**


#### Arguments
* $condition **array**


