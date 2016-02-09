common\models\UserProfile
===============

This is the model class for table &quot;user_profile&quot;.




* Class name: UserProfile
* Namespace: common\models
* Parent class: yii\db\ActiveRecord



Constants
----------


### GENDER_MALE

    const GENDER_MALE = 2





### GENDER_FEMALE

    const GENDER_FEMALE = 1





Properties
----------


### $user_id

    public integer $user_id





* Visibility: **public**


### $locale

    public integer $locale





* Visibility: **public**


### $firstname

    public string $firstname





* Visibility: **public**


### $lastname

    public string $lastname





* Visibility: **public**


### $avatar_path

    public string $avatar_path





* Visibility: **public**


### $user

    public \common\models\User $user





* Visibility: **public**


Methods
-------


### tableName

    mixed common\models\UserProfile::tableName()





* Visibility: **public**
* This method is **static**.




### rules

    mixed common\models\UserProfile::rules()





* Visibility: **public**




### attributeLabels

    mixed common\models\UserProfile::attributeLabels()





* Visibility: **public**




### afterSave

    mixed common\models\UserProfile::afterSave(boolean $insert, array $changedAttributes)





* Visibility: **public**


#### Arguments
* $insert **boolean**
* $changedAttributes **array**



### getAvatar

    boolean|string common\models\UserProfile::getAvatar($id)





* Visibility: **public**


#### Arguments
* $id **mixed**



### setAvatar

    boolean common\models\UserProfile::setAvatar($fileName)





* Visibility: **public**


#### Arguments
* $fileName **mixed**



### getUser

    \yii\db\ActiveQuery common\models\UserProfile::getUser()





* Visibility: **public**




### getFullName

    null|string common\models\UserProfile::getFullName()





* Visibility: **public**



