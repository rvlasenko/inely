<?php

/**
 * Эта модель является частью проекта Inely.
 *
 * @link    http://github.com/hirootkit/inely
 * @licence http://github.com/hirootkit/inely/blob/master/LICENSE.md GPL
 * @author  hirootkit <admiralexo@gmail.com>
 */

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Класс модели для таблицы "projects".
 *
 * @property int        $id
 * @property string     $listName
 * @property string     $badgeColor
 * @property integer    $ownerId
 */
class Project extends ActiveRecord
{
    public function rules()
    {
        return [
            ['sharedWith', 'integer'],
            [['listName', 'badgeColor'], 'string', 'max' => 255],
            ['ownerId', 'default', 'value' => Yii::$app->user->id]
        ];
    }

    public static function tableName()
    {
        return 'projects';
    }

    /**
     * Отношение с таблицей "tasks"
     * @return ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasOne(Task::className(), ['listId' => 'id']);
    }

    /**
     * Запись данных в модель. Метод перегружен от базового класса Model.
     * @param array|boolean $data массив данных.
     * @param string $formName имя формы, использующееся для записи данных в модель.
     * @return boolean если `$data` содержит некие данные, которые связываются с атрибутами модели.
     */
    public function load($data, $formName = '')
    {
        $scope = $formName === null ? $this->formName() : $formName;
        if ($scope === '' && !empty($data)) {
            $this->setAttributes($data);

            return true;
        } elseif (isset($data[$scope])) {
            $this->setAttributes($data[$scope]);

            return true;
        } else {
            return false;
        }
    }
}
