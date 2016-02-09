common\components\nested\NestedSetQueryBehavior
===============

NestedSetsQueryBehavior




* Class name: NestedSetQueryBehavior
* Namespace: common\components\nested
* Parent class: yii\base\Behavior





Properties
----------


### $owner

    public \yii\db\ActiveQuery $owner





* Visibility: **public**


Methods
-------


### roots

    \yii\db\ActiveQuery common\components\nested\NestedSetQueryBehavior::roots($data)

Gets the root nodes.



* Visibility: **public**


#### Arguments
* $data **mixed**



### rootId

    \yii\db\ActiveQuery common\components\nested\NestedSetQueryBehavior::rootId($author, $listId)

Gets the root id by list id.



* Visibility: **public**


#### Arguments
* $author **mixed**
* $listId **mixed**



### leaves

    \yii\db\ActiveQuery common\components\nested\NestedSetQueryBehavior::leaves()

Gets the leaf nodes.



* Visibility: **public**



