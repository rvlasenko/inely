backend\models\GamifyAchievements
===============

Модель таблицы &quot;gamify_achievements&quot;.




* Class name: GamifyAchievements
* Namespace: backend\models
* Parent class: yii\db\ActiveRecord



Constants
----------


### ACTIVE

    const ACTIVE = 'active'





### COMPLETED

    const COMPLETED = 'completed'





Properties
----------


### $ID

    public integer $ID





* Visibility: **public**


### $achievement_name

    public string $achievement_name





* Visibility: **public**


### $badge_src

    public string $badge_src





* Visibility: **public**


### $description

    public string $description





* Visibility: **public**


### $amount_needed

    public integer $amount_needed





* Visibility: **public**


### $time_period

    public integer $time_period





* Visibility: **public**


### $status

    public string $status





* Visibility: **public**


### $gamifyUsersAches

    public array<mixed,\backend\models\GamifyUsersAch> $gamifyUsersAches





* Visibility: **public**


Methods
-------


### tableName

    mixed backend\models\GamifyAchievements::tableName()





* Visibility: **public**
* This method is **static**.




### rules

    mixed backend\models\GamifyAchievements::rules()





* Visibility: **public**




### achievement

    null|static backend\models\GamifyAchievements::achievement(string $username, integer $achievement, integer $amount)





* Visibility: **public**


#### Arguments
* $username **string**
* $achievement **integer**
* $amount **integer**



### getGamifyUsersAches

    \yii\db\ActiveQuery backend\models\GamifyAchievements::getGamifyUsersAches()





* Visibility: **public**



