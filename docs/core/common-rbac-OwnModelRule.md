common\rbac\OwnModelRule
===============






* Class name: OwnModelRule
* Namespace: common\rbac
* Parent class: yii\rbac\Rule





Properties
----------


### $name

    public string $name = 'ownModelRule'





* Visibility: **public**


Methods
-------


### execute

    boolean common\rbac\OwnModelRule::execute(integer $user, \yii\rbac\Item $item, array $params)





* Visibility: **public**


#### Arguments
* $user **integer**
* $item **yii\rbac\Item**
* $params **array** - &lt;ul&gt;
&lt;li&gt;model: model to check owner&lt;/li&gt;
&lt;li&gt;attribute: attribute that will be compared to user ID&lt;/li&gt;
&lt;/ul&gt;


