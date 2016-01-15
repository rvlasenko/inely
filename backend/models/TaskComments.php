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
 * Класс модели для таблицы "task_comments"
 *
 * @property integer $commentId
 * @property integer $taskId
 * @property integer $userId
 * @property string $comment
 * @property string $timePosted
 *
 * @property Tasks $task
 */
class TaskComments extends ActiveRecord
{
    const ICON_CLASS = 'entypo-chat';

    public static function tableName()
    {
        return 'task_comments';
    }

    public function rules()
    {
        return [
            [['taskId', 'comment', 'timePosted'], 'required'],
            [['taskId', 'userId'], 'integer'],
            [['userId'], 'default', 'value' => Yii::$app->user->id],
            [['comment'], 'string'],
            [['timePosted'], 'safe']
        ];
    }

    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['taskId' => 'taskId']);
    }

    /**
     * Запись данных в модель. Метод перегружен от базового класса Model.
     * @param array $data массив данных.
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
