<?php

namespace common\models;

use Yii;
use yii\web\HttpException;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_profile".
 * @property integer $user_id
 * @property integer $locale
 * @property string  $firstname
 * @property string  $lastname
 * @property string  $user_char_path
 * @property string  $user_char_name
 * @property string  $def_char_name
 * @property string  $picture
 * @property integer $gender
 * @property User    $user
 */
class UserProfile extends ActiveRecord
{
    const GENDER_MALE = 2;
    const GENDER_FEMALE = 1;

    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    public function rules()
    {
        return [
            [ [ 'user_id' ], 'required' ],
            [ [ 'user_id', 'gender' ], 'integer' ],
            [ [ 'gender' ], 'in', 'range' => [ self::GENDER_FEMALE, self::GENDER_MALE ] ],
            [ [ 'firstname',
                'lastname',
                'def_char_name',
                'user_char_name',
                'user_char_name' ], 'string', 'max' => 255
            ],
            [ 'locale', 'default', 'value' => Yii::$app->language ],
            [ 'locale', 'in', 'range' => array_keys(Yii::$app->params[ 'availableLocales' ]) ]
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->session->setFlash('forceUpdateLocale');
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), [ 'id' => 'user_id' ]);
    }

    public function getFullName()
    {
        if ($this->firstname || $this->lastname) {
            return implode(' ', [ $this->firstname, $this->lastname ]);
        }

        return null;
    }

    public function getChar()
    {
        $user = UserProfile::findOne([ Yii::$app->user->id ]);

        if ($user->user_char_path !== null || $user->user_char_name !== null) {
            return [ 'own' => $user->user_char_path ];
        } elseif ($user->def_char_name !== null) {
            return [ 'default' => $user->def_char_name ];
        } else {
            throw new HttpException(500, 'Unable to detect user character');
        }
    }
}
