<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "gamify_achievements".
 *
 * @property integer $ID
 * @property string $achievement_name
 * @property string $badge_src
 * @property string $description
 * @property integer $amount_needed
 * @property integer $time_period
 * @property string $status
 *
 * @property GamifyUsersAch[] $gamifyUsersAches
 */
class GamifyAchievements extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gamify_achievements';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['achievement_name', 'badge_src', 'amount_needed'], 'required'],
            [['badge_src', 'description', 'status'], 'string'],
            [['amount_needed', 'time_period'], 'integer'],
            [['achievement_name'], 'string', 'max' => 250]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGamifyUsersAches()
    {
        return $this->hasMany(GamifyUsersAch::className(), ['achID' => 'ID']);
    }
}
