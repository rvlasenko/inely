backend\models\GamifyUsersAch
===============

This is the model class for table &quot;gamify_users_ach&quot;.




* Class name: GamifyUsersAch
* Namespace: backend\models
* Parent class: yii\db\ActiveRecord





Properties
----------


### $ID

    public integer $ID





* Visibility: **public**


### $userID

    public integer $userID





* Visibility: **public**


### $achID

    public integer $achID





* Visibility: **public**


### $amount

    public integer $amount





* Visibility: **public**


### $last_time

    public integer $last_time





* Visibility: **public**


### $status

    public string $status





* Visibility: **public**


### $user

    public \backend\models\GamifyUserStats $user





* Visibility: **public**


### $ach

    public \backend\models\GamifyAchievements $ach





* Visibility: **public**


Methods
-------


### tableName

    mixed backend\models\GamifyUsersAch::tableName()





* Visibility: **public**
* This method is **static**.




### rules

    mixed backend\models\GamifyUsersAch::rules()





* Visibility: **public**




### getUser

    \yii\db\ActiveQuery backend\models\GamifyUsersAch::getUser()





* Visibility: **public**




### getAch

    \yii\db\ActiveQuery backend\models\GamifyUsersAch::getAch()





* Visibility: **public**



