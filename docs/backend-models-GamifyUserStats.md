backend\models\GamifyUserStats
===============

This is the model class for table &quot;gamify_user_stats&quot;.




* Class name: GamifyUserStats
* Namespace: backend\models
* Parent class: yii\db\ActiveRecord





Properties
----------


### $ID

    public integer $ID





* Visibility: **public**


### $username

    public string $username





* Visibility: **public**


### $experience

    public integer $experience





* Visibility: **public**


### $level

    public integer $level





* Visibility: **public**


### $tasks_done

    public integer $tasks_done





* Visibility: **public**


### $level0

    public \backend\models\GamifyLevels $level0





* Visibility: **public**


### $gamifyUsersAches

    public array<mixed,\backend\models\GamifyUsersAch> $gamifyUsersAches





* Visibility: **public**


Methods
-------


### tableName

    mixed backend\models\GamifyUserStats::tableName()





* Visibility: **public**
* This method is **static**.




### rules

    mixed backend\models\GamifyUserStats::rules()





* Visibility: **public**




### updateCounter

    mixed backend\models\GamifyUserStats::updateCounter($data)

Обновление счетчика выполненных задач.



* Visibility: **public**


#### Arguments
* $data **mixed**



### getLevel

    \yii\db\ActiveQuery backend\models\GamifyUserStats::getLevel()





* Visibility: **public**




### getGamifyUsersAches

    \yii\db\ActiveQuery backend\models\GamifyUserStats::getGamifyUsersAches()





* Visibility: **public**




### getUserStats

    array backend\models\GamifyUserStats::getUserStats()

Получение игровой статистики текущего пользователя.



* Visibility: **public**




### getManyUserStats

    array backend\models\GamifyUserStats::getManyUserStats()

Получение игровой статистики всех пользователей.



* Visibility: **public**



