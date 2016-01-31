<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "gamify_users_ach".
 *
 * @property integer $ID
 * @property integer $userID
 * @property integer $achID
 * @property integer $amount
 * @property integer $last_time
 * @property string $status
 *
 * @property GamifyUserStats $user
 * @property GamifyAchievements $ach
 */
class GamifyUsersAch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gamify_users_ach';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'achID', 'amount', 'last_time'], 'required'],
            [['userID', 'achID', 'amount', 'last_time'], 'integer'],
            [['status'], 'string'],
            [['userID', 'achID'], 'unique', 'targetAttribute' => ['userID', 'achID'], 'message' => 'The combination of User ID and Ach ID has already been taken.']
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(GamifyUserStats::className(), ['ID' => 'userID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAch()
    {
        return $this->hasOne(GamifyAchievements::className(), ['ID' => 'achID']);
    }
}
