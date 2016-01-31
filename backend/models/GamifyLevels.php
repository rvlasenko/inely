<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "gamify_levels".
 *
 * @property integer $ID
 * @property string $level_name
 * @property integer $experience_needed
 *
 * @property GamifyUserStats[] $gamifyUserStats
 */
class GamifyLevels extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gamify_levels';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level_name', 'experience_needed'], 'required'],
            [['experience_needed'], 'integer'],
            [['level_name'], 'string', 'max' => 250]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGamifyUserStats()
    {
        return $this->hasMany(GamifyUserStats::className(), ['level' => 'ID']);
    }

    /**
     * Обновить опыт и данные об уровне
     * @param $experience
     * @param $levelID
     * @param $userID
     *
     * @return bool|int
     * @throws \Exception
     */
    public function updateLevel($experience, $levelID, $userID)
    {
        $user = GamifyUserStats::findOne($userID);
        $user->experience = $experience;
        $user->level = $levelID;

        return $user->update();
    }

    /**
     * @param $experience
     * @param $userStats
     *
     * @return bool|int
     */
    public function checkLevel($experience, $userStats)
    {
        $level = self::findOne([
            'experience_needed' => self::find()
                ->select('MAX(experience_needed)')
                ->where(['<=', 'experience_needed', $experience])
        ]);

        if ($level && $level->ID != $userStats->level) {
            return $this->updateLevel($experience, $level->ID, $userStats->ID);
        } else {
            return false;
        }
    }

    /**
     * @param $username
     * @param $experience
     *
     * @return bool|int
     * @throws \Exception
     */
    public function addExperience($username, $experience)
    {
        // Получаем инфо о юзере
        $userStats  = GamifyUserStats::findOne(['username' => $username]);
        $experience += $userStats->experience;

        // Проверка на новый уровень
        if ($this->checkLevel($experience, $userStats)) {
            return true;
        } else {
            // Добавить опыт
            $user = GamifyUserStats::findOne($userStats->ID);
            $user->experience = $experience;

            return $user->update();
        }
    }
}
