<?php

/**
 * Эта модель является частью проекта Inely.
 *
 * @link    http://github.com/hirootkit/inely
 * @licence http://github.com/hirootkit/inely/blob/master/LICENSE.md GPL
 * @author  hirootkit <admiralexo@gmail.com>
 */

namespace backend\models;

use common\components\formatter\FormatterComponent;
use common\models\User;
use common\models\UserProfile;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Класс модели для таблицы "task_comments"
 *
 * @property integer $commentId
 * @property integer $taskId
 * @property integer $userId
 * @property string  $comment
 * @property string  $timePosted
 *
 * @property Tasks   $task
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

    /**
     * Ищем комментарии к полученной задаче, формируем JSON и отправляем
     *
     * @param $taskId
     *
     * @return array
     */
    public function getComments($taskId)
    {
        $result    = [];
        $formatter = new FormatterComponent();
        $task      = Task::findOne($taskId);

        foreach (TaskComments::find()->where(['taskId' => $task->taskId])->each() as $comment) {
            $result[] = [
                'author'  => User::findOne($comment->userId)->username,
                'time'    => $formatter->asRelativeDate($comment->timePosted),
                'comment' => $comment->comment,
                'picture' => (new UserProfile())->getAvatar($comment->userId)
            ];
        }

        return $result;
    }

    /**
     * @param $data
     *
     * @return array
     * @throws \Exception
     */
    public function setComment($data)
    {
        $formatter   = new FormatterComponent();
        $taskComment = new TaskComments();

        if ($taskComment->load($data) && $taskComment->insert()) {
            return [
                'author'  => Yii::$app->user->identity->username,
                'time'    => $formatter->asRelativeDate(ArrayHelper::getValue($data, 'timePosted')),
                'comment' => ArrayHelper::getValue($data, 'comment'),
                'picture' => (new UserProfile())->getAvatar(Yii::$app->user->id)
            ];
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['taskId' => 'taskId']);
    }

    /**
     * Запись данных в модель. Метод перегружен от базового класса Model.
     *
     * @param array  $data     массив данных.
     * @param string $formName имя формы, использующееся для записи данных в модель.
     *
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
