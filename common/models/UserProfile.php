<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_profile".
 * @property integer $user_id
 * @property integer $locale
 * @property string  $firstname
 * @property string  $lastname
 * @property string  $avatar_path
 * @property User    $user
 */
class UserProfile extends ActiveRecord
{
    const GENDER_MALE   = 2;
    const GENDER_FEMALE = 1;

    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['firstname', 'lastname'], 'string', 'max' => 50],
            ['locale', 'default', 'value' => Yii::$app->language],
            ['locale', 'in', 'range' => array_keys(Yii::$app->params['availableLocales'])]
        ];
    }

    public function attributeLabels()
    {
        return [
            'firstname' => 'Имя'
        ];
    }

    /**
     * @param bool  $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Yii::$app->session->setFlash('forceUpdateLocale');
    }

    /**
     * @param $id
     *
     * @return bool|string
     */
    public function getAvatar($id)
    {
        $model = $this::findOne($id);

        if (isset($model->avatar_path)) {
            return Yii::getAlias($model->avatar_path);
        }
    }

    /**
     * @param $fileName
     *
     * @return bool
     */
    public function setAvatar($fileName)
    {
        $model = $this::findOne(Yii::$app->user->id);
        $model->setAttribute('avatar_path', '/images/avatars/storage/' . $fileName);

        return $model->save();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return null|string
     */
    public function getFullName()
    {
        if ($this->firstname || $this->lastname) {
            return implode(' ', [$this->firstname, $this->lastname]);
        }

        return null;
    }
}
