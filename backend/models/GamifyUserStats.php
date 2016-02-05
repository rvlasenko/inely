<?php

namespace backend\models;

use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "gamify_user_stats".
 *
 * @property integer $ID
 * @property string $username
 * @property integer $experience
 * @property integer $level
 * @property integer $tasks_done
 *
 * @property GamifyLevels $level0
 * @property GamifyUsersAch[] $gamifyUsersAches
 */
class GamifyUserStats extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gamify_user_stats';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['experience', 'level'], 'integer'],
            [['username'], 'string', 'max' => 250],
            [['username'], 'unique']
        ];
    }

    /**
     * Обновление счетчика выполненных задач.
     * @param $data
     *
     * @throws Exception
     * @throws \Exception
     */
    public function updateCounter(array $data)
    {
        $userStats = self::findOne(['username' => $data['userName']]);

        if ($data['isDone'] == Task::COMPLETED_TASK) {
            $userStats->tasks_done++;
        } elseif ($data['isDone'] == Task::ACTIVE_TASK) {
            $userStats->tasks_done--;
        }

        if (!$userStats->update()) {
            throw new Exception('Ошибка при увеличении счетчика');
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel()
    {
        return $this->hasOne(GamifyLevels::className(), ['ID' => 'level']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGamifyUsersAches()
    {
        return $this->hasMany(GamifyUsersAch::className(), ['userID' => 'ID']);
    }

    /**
     * Получение игровой статистики текущего пользователя.
     * @return array статистика
     */
    public function getUserStats()
    {
        $db    = Yii::$app->db;
        $param = [':username' => Yii::$app->user->identity->username];
        $sql   = 'SELECT a.ID, a.username, a.tasks_done, a.experience, b.level_name as level, b.experience_needed
				  FROM `gamify_user_stats` as a, `gamify_levels` as b
				  WHERE a.level = b.ID and `username` = :username';

        $userInfo = $db->createCommand($sql)->bindValues($param)->queryAll();

        if (isset($userInfo)) {
            $param = [':userID' => ArrayHelper::getValue($userInfo, '0.ID')];
            $sql   = 'SELECT b.achievement_name, b.badge_src, a.last_time as time, a.status
                      FROM `gamify_users_ach` as a, `gamify_achievements` as b
                      WHERE a.achID = b.ID and a.userID = :userID';

            $userInfo['achievements'] = $db->createCommand($sql)->bindValues($param)->queryAll();
        }

        return $userInfo;
    }

    /**
     * Получение игровой статистики всех пользователей.
     * @return array статистика
     */
    public function getManyUserStats()
    {
        $sql = 'SELECT a.ID, a.username, a.experience, b.level_name as level
                FROM `gamify_user_stats` as a, `gamify_levels` as b
                WHERE a.level = b.ID';

        $usersInfo = Yii::$app->db->createCommand($sql)->queryAll();

        return $usersInfo;
    }
}
