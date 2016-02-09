backend\models\GamifyLevels
===============

This is the model class for table &quot;gamify_levels&quot;.




* Class name: GamifyLevels
* Namespace: backend\models
* Parent class: yii\db\ActiveRecord





Properties
----------


### $ID

    public integer $ID





* Visibility: **public**


### $level_name

    public string $level_name





* Visibility: **public**


### $experience_needed

    public integer $experience_needed





* Visibility: **public**


### $gamifyUserStats

    public array<mixed,\backend\models\GamifyUserStats> $gamifyUserStats





* Visibility: **public**


Methods
-------


### tableName

    mixed backend\models\GamifyLevels::tableName()





* Visibility: **public**
* This method is **static**.




### rules

    mixed backend\models\GamifyLevels::rules()





* Visibility: **public**




### getGamifyUserStats

    \yii\db\ActiveQuery backend\models\GamifyLevels::getGamifyUserStats()





* Visibility: **public**




### updateLevel

    boolean|integer backend\models\GamifyLevels::updateLevel($experience, $levelID, $userID)

Обновить опыт и данные об уровне



* Visibility: **private**


#### Arguments
* $experience **mixed**
* $levelID **mixed**
* $userID **mixed**



### checkLevel

    boolean|integer backend\models\GamifyLevels::checkLevel($experience, $userStats)





* Visibility: **private**


#### Arguments
* $experience **mixed**
* $userStats **mixed**



### addExperience

    boolean|integer backend\models\GamifyLevels::addExperience($username, $experience)





* Visibility: **public**


#### Arguments
* $username **mixed**
* $experience **mixed**


