<?php

/**
 * Этот контроллер является частью проекта Inely.
 *
 * @link    http://github.com/hirootkit/inely
 * @licence http://github.com/hirootkit/inely/blob/master/LICENSE.md GPL
 * @author  hirootkit <admiralexo@gmail.com>
 */

namespace backend\controllers;

use backend\models\Project;
use backend\models\Task;
use backend\models\TaskData;
use common\models\User;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * Class ProjectController
 * @package backend\controllers
 */
class ProjectController extends TaskController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?']
                    ]
                ]
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'create'              => ['post'],
                    'delete'              => ['post'],
                    'edit'                => ['post'],
                    'share-with-user'     => ['post'],
                    'remove-collaborator' => ['post'],
                    'get-collaborators'   => ['get'],
                    'get-assigned'        => ['get'],
                ]
            ],
            [
                'class'   => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ];
    }

    /**
     * Валидация принятых атрибутов и добавление их значений в соответствующие поля базы данных.
     * В случае несоответствия формату, поле игнорируется и выбрасывается исключение.
     * @return bool если редактирование завершилось успешно.
     * @throws Exception если принятые атрибуты не прошли валидацию.
     */
    public function actionEdit()
    {
        $request = Yii::$app->request;
        $project = Project::findOne($request->post('id'));

        if ($project->load($request->post()) && !$project->save()) {
            throw new Exception('Переданы данные, несоответствующие формату');
        }

        return $request->post('listName');
    }

    /**
     * Создание нового проекта и его уникального корневого узла.
     * Чтобы добавленные в него задачи имели id корня проекта, а не общий.
     * @method boolean makeRoot() Создает корень, если Active Record объект новый.
     * @return array идентификатор и название созданного проекта, JSON.
     * @throws HttpException при неудачном сохранении.
     */
    public function actionCreate()
    {
        $newProject = new Project();
        $childTask  = new Task();
        $childTaskData   = new TaskData();
        $userData   = [
            'ownerId' => Yii::$app->user->id,
            'name'    => 'Root',
            'isDone'  => null
        ];

        if ($newProject->load(Yii::$app->request->post()) && $newProject->save()) {
            $userData['listId'] = $newProject->getPrimaryKey();

            if ($childTaskData->load($userData) && $childTaskData->makeRoot()) {
                $userData['taskId'] = $childTaskData->getPrimaryKey();

                if ($childTask->load($userData) && $childTask->save()) {
                    return [
                        'name' => Yii::$app->request->post('listName'),
                        'id'   => $newProject->getPrimaryKey()
                    ];
                }
            }
        } else {
            throw new HttpException(500, $newProject->getErrors());
        }
    }

    /**
     * Удаление существующего проекта и его корневого узла.
     * @method ActiveQuery roots(string $author, integer $listId) Получает корневой узел.
     * @return bool значение, если удаление записи всё-таки произошло.
     * @throws NotFoundHttpException если пользователь захотел удалить несуществующий проект.
     */
    public function actionDelete()
    {
        $project = Project::findOne(Yii::$app->request->post('id'));
        $root    = TaskData::find()->roots(Yii::$app->user->id, $project->getPrimaryKey())->one();

        if ($project->delete() && $root->delete()) {
            return true;
        }

        return null;
    }

    /**
     * Приглашение пользователя к совместной работе над проектом.
     * Такие пользователи, могут добавлять, удалять и завершать задачи из этого списка.
     * Ищем id пользователя по email, а также id корневого узла проекта и добавляем в список.
     * @method ActiveQuery rootId(string $author, integer $listId) Получает id корневого списка.
     * @return bool если юзер теперь имеет доступ к проекту.
     */
    public function actionShareWithUser()
    {
        $listId  = Yii::$app->request->post('listId');
        $email   = Yii::$app->request->post('email');
        $ownerId = Yii::$app->user->id;
        $rootId  = TaskData::find()->rootId($ownerId, $listId);

        $task    = Task::findOne($rootId);
        $project = Project::findOne($listId);
        $data    = ['sharedWith' => User::findByEmail($email)->getId()];

        if ($task->load($data) && $task->save()) {
            if ($project->load($data) && $project->save()) {
                return true;
            }
        }
    }

    /**
     * Исключение пользователя из совместного проекта.
     * Ищем id пользователя по email, а также id корневого узла проекта и исключаем из списка.
     * @method ActiveQuery rootId(string $author, integer $listId) Получает id корневого списка.
     * @return bool если юзер теперь не имеет доступа к проекту.
     */
    public function actionRemoveCollaborator()
    {
        $listId = Yii::$app->request->post('listId');
        $userId = Yii::$app->request->post('userId');
        $rootId = TaskData::find()->rootId($userId, $listId);

        $task    = Task::findOne($rootId);
        $project = Project::findOne($listId);
        $data    = ['sharedWith' => null];

        if ($task->load($data) && $task->save()) {
            if ($project->load($data) && $project->save()) {
                return true;
            }
        }

        return null;
    }

    /**
     * Возвращение списка пользователей, которые имеющих доступ к проекту, включая владельца.
     * Он может взаимодействовать с юзерами, добавлять и удалять их. (Пока не более двух)
     *
     * @param integer $listId ID проекта (списка), по которому группируются требуемые задачи.
     *
     * @return array|null объект участников в списке.
     */
    public function actionGetCollaborators($listId = null)
    {
        if (Yii::$app->request->isAjax && $listId !== null) {
            $result  = [];
            $project = Project::findOne($listId);

            foreach (User::find()->with('userProfile')->where(['id' => [$project->ownerId, $project->sharedWith]])->each() as $user) {
                $result[] = [
                    'owner'   => $user->id == $project->ownerId ? 'Владелец' : '',
                    'name'    => $user->username,
                    'key'     => $user->id,
                    'picture' => Yii::$app->user->identity->userProfile->getAvatar($user->id),
                    'email'   => $user->email
                ];
            }

            return $result;
        }

        return null;
    }

    /**
     * Возвращение списка пользователей, имеющих доступ к проекту, включая владельца.
     * Первым элементом в списке пользователей, которых можно назначить на задачу, следует "отключающий".
     *
     * @param integer $listId ID проекта (списка), по которому группируются требуемые задачи.
     *
     * @return array объект участников в списке.
     */
    public function actionGetAssigned($listId = null)
    {
        if (Yii::$app->request->isAjax && $listId !== null) {
            $project  = Project::findOne($listId);
            $result[] = [
                'id'      => 0,
                'text'    => 'Нет',
                'picture' => '/images/avatars/none.png'
            ];

            foreach (User::find()->with('userProfile')->where(['id' => [$project->ownerId, $project->sharedWith]])->each() as $user) {
                $result[] = [
                    'id'      => $user->id,
                    'text'    => $user->username,
                    'picture' => Yii::$app->user->identity->userProfile->getAvatar($user->id)
                ];
            }

            return $result;
        }
    }
}
