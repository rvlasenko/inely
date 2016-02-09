<?php

namespace backend\models;

use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "gamify_achievements".
 *
 * @property integer          $ID
 * @property string           $achievement_name
 * @property string           $badge_src
 * @property string           $description
 * @property integer          $amount_needed
 * @property integer          $time_period
 * @property string           $status
 *
 * @property GamifyUsersAch[] $gamifyUsersAches
 */
class GamifyAchievements extends \yii\db\ActiveRecord
{
    const ACTIVE    = 'active';
    const COMPLETED = 'completed';

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
     * @param     $username
     * @param     $achievement
     * @param int $amount
     *
     * @return null|static
     * @throws \Exception
     */
    public function action($username, $achievement, $amount = 1)
    {
        $user = GamifyUserStats::findOne(['username' => $username]);
        $ach  = GamifyAchievements::findOne(['ID' => $achievement]);

        // Проверяем, активно ли достижение
        if ($ach->status === self::ACTIVE) {
            $now      = time();
            $complete = false;

            $rel   = GamifyUsersAch::findOne(['userID' => $user->ID, 'achID' => $ach->ID]);
            $model = GamifyUsersAch::findOne(['ID' => $rel->ID]);

            // Проверяем, выполнено ли достижение
            if ($rel->status === self::ACTIVE) {
                $amount += $rel->amount;

                // Если необходимый период времени прошел...
                if ($now >= $rel->last_time + $ach->time_period) {
                    // и юзер не выполнил достижение...
                    if ($amount >= $ach->amount_needed) {
                        // записать его как выполненное
                        $condition = [
                            'amount'    => $amount,
                            'status'    => self::COMPLETED,
                            'last_time' => $now
                        ];

                        $complete = true;
                    }
                } else {
                    // иначе обновить существующую запись
                    $condition = [
                        'amount'    => $amount,
                        'last_time' => $now
                    ];
                }

                if ($model->load($condition) && $model->update() || $complete) {
                    return $ach;
                }
            } else {
                $status = self::ACTIVE;
                $model  = new GamifyUsersAch();

                if ($amount >= $ach->amount_needed) {
                    $status   = self::COMPLETED;
                    $complete = true;
                }

                $condition = [
                    'userID'    => $user->ID,
                    'achID'     => $ach->ID,
                    'amount'    => $amount,
                    'last_time' => $now,
                    'status'    => $status
                ];

                if ($model->load($condition) && $model->insert() || $complete) {
                    return $ach;
                }
            }
        } else {
            throw new Exception('Достижения с именем ' . $ach->achievement_name . ' не существует');
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGamifyUsersAches()
    {
        return $this->hasMany(GamifyUsersAch::className(), ['achID' => 'ID']);
    }
}
