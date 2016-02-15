<?php

/**
 * Эта модель является частью проекта Inely.
 *
 * @link    http://github.com/hirootkit/inely
 * @licence http://github.com/hirootkit/inely/blob/master/LICENSE.md GPL
 * @author  hirootkit <admiralexo@gmail.com>
 */

namespace backend\models;

use common\models\User;
use common\models\UserProfile;
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
     * Создание уникального корневого узла проекта.
     *
     * @param $userData
     *
     * @return array
     */
    private function createProjectRoot(array $userData)
    {
        $childTask     = new Task();
        $childTaskData = new TaskData();

        if ($childTaskData->load($userData) && $childTaskData->makeRoot()) {
            $userData['taskId'] = $childTaskData->getPrimaryKey();

            if ($childTask->load($userData) && $childTask->save()) {
                return [
                    'name' => $userData['request'],
                    'id'   => $userData['listId']
                ];
            }
        }
    }

    /**
     * Создание проекта.
     *
     * @param $data
     * @method boolean makeRoot() Создает корень, если Active Record объект новый.
     *
     * @return array
     */
    public function createProject(array $data)
    {
        $newProject = new Project();
        $userData   = [
            'ownerId' => Yii::$app->user->id,
            'name'    => 'Root',
            'isDone'  => null
        ];

        if ($newProject->load($data) && $newProject->save()) {
            $userData['listId']  = $newProject->getPrimaryKey();
            $userData['request'] = $data;

            return $this->createProjectRoot($userData);
        }
    }

    /**
     * @param $listId
     *
     * @return array
     */
    public function getAssignedUsers($listId)
    {
        $project  = Project::findOne($listId);
        $result[] = [
            'id'      => 0,
            'text'    => 'Нет',
            'picture' => '/images/avatars/none.png'
        ];

        foreach (User::find()
                     ->with('userProfile')
                     ->where(['id' => [$project->ownerId, $project->sharedWith]])
                     ->each() as $user) {
            $result[] = [
                'id'      => $user->id,
                'text'    => $user->username,
                'picture' => (new UserProfile())->getAvatar($user->id)
            ];
        }

        return $result;
    }

    /**
     * Ищем id пользователя по email, а также id корневого узла проекта и исключаем из списка.
     *
     * @param $userData
     *
     * @return bool
     */
    public function removeCollaborator(array $userData)
    {
        $rootId  = TaskData::find()->rootId($userData['userID'], $userData['listID']);
        $task    = Task::findOne($rootId);
        $project = Project::findOne($userData['listID']);
        $attr    = ['sharedWith' => null];

        $task->attributes    = $attr;
        $project->attributes = $attr;

        if ($task->save() && $project->save()) {
            return true;
        }
    }

    /**
     * Ищем id пользователя по email, а также id корневого узла проекта и добавляем в список.
     * @method ActiveQuery rootId(string $author, integer $listId) Получает id корневого списка.
     *
     * @param $userData
     *
     * @return bool
     */
    public function shareWithUser(array $userData)
    {
        $ownerId = Yii::$app->user->id;
        $rootId  = TaskData::find()->rootId($ownerId, $userData['listID']);
        $task    = Task::findOne($rootId);
        $project = Project::findOne($userData['listID']);
        $attr    = ['sharedWith' => User::findByEmail($userData['email'])->getId()];

        $task->attributes    = $attr;
        $project->attributes = $attr;

        if ($task->save() && $project->save()) {
            return true;
        }
    }

    /**
     * @param $listId
     *
     * @return array
     */
    public function getCollaborators($listId)
    {
        $result  = [];
        $project = Project::findOne($listId);

        foreach (User::find()
                     ->with('userProfile')
                     ->where(['id' => [$project->ownerId, $project->sharedWith]])
                     ->each() as $user) {
            $result[] = [
                'owner'   => $user->id == $project->ownerId ? 'Владелец' : '',
                'name'    => $user->username,
                'key'     => $user->id,
                'picture' => (new UserProfile())->getAvatar($user->id),
                'email'   => $user->email
            ];
        }

        return $result;
    }

    /**
     * Запись данных в модель. Метод перегружен от базового класса Model.
     *
     * @param array|boolean $data     массив данных.
     * @param string        $formName имя формы, использующееся для записи данных в модель.
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
