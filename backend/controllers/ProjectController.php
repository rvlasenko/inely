<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link   http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace backend\controllers;

use backend\models\Project;
use backend\models\Task;
use backend\models\TaskData;
use common\models\User;
use Yii;
use yii\base\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

class ProjectController extends Controller
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
                    'create'             => ['post'],
                    'delete'             => ['post'],
                    'rename'             => ['post'],
                    'assign-user'        => ['post'],
                    'unassign-user'      => ['post'],
                    'get-assigned-users' => ['get'],
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
     * Переименовывание проекта.
     * @return bool результат сконвертированный в JSON.
     * @throws HttpException если переименовывание завершилось неудачей.
     */
    public function actionRename()
    {
        $request = Yii::$app->request;
        $project = Project::findOne($request->post('id'));

        if ($project->load($request->post()) && $project->save()) {
            return $request->post('listName');
        } else {
            throw new HttpException(500, $project->getErrors());
        }
    }

    /**
     * Создание нового проекта и его уникального корневого узла.
     * @return array идентификатор и название созданного проекта, JSON.
     * @throws HttpException при неудачном сохранении.
     */
    public function actionCreate()
    {
        $newProject = new Project();
        $taskModel  = new Task();
        $newChild   = new TaskData();
        $userData   = [
            'ownerId' => Yii::$app->user->id,
            'name'    => 'Root',
            'isDone'  => null
        ];

        if ($newProject->load(Yii::$app->request->post()) && $newProject->save()) {
            $userData['listId'] = $newProject->getPrimaryKey();

            if ($newChild->load($userData) && $newChild->makeRoot()) {
                $userData['taskId'] = $newChild->getPrimaryKey();

                if ($taskModel->load($userData) && $taskModel->save()) {
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
     * Удаление существующего проекта.
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
     * Поиск id пользователя по email, а также корневого id проекта для открытия доступа.
     * @return bool если юзер теперь имеет доступ к проекту.
     */
    public function actionAssignUser()
    {
        $listId  = Yii::$app->request->post('listId');
        $email   = Yii::$app->request->post('email');
        $ownerId = Yii::$app->user->id;

        $userId = User::findByEmail($email)->getId();
        $rootId = TaskData::find()->rootId($ownerId, $listId);

        $node    = Task::findOne($rootId);
        $project = Project::findOne($listId);
        $data    = ['assignedTo' => $userId];

        if ($node->load($data) && $node->save()) {
            if ($project->load($data) && $project->save()) {
                return true;
            }
        }

        return null;
    }

    /**
     * Удаление пользователя из совместного проекта.
     * Поиск id пользователя по email, а также корневого id проекта для открытия доступа.
     * @return bool если юзер теперь не имеет доступа к проекту.
     */
    public function actionUnassignUser()
    {
        $listId = Yii::$app->request->post('listId');
        $userId = Yii::$app->request->post('userId');

        $rootId = TaskData::find()->rootId($userId, $listId);

        $node    = Task::findOne($rootId);
        $project = Project::findOne($listId);
        $data    = ['assignedTo' => null];

        if ($node->load($data) && $node->save()) {
            if ($project->load($data) && $project->save()) {
                return true;
            }
        }

        return null;
    }

    public function actionGetAssignedUsers()
    {
        if (Yii::$app->request->isAjax) {
            $result  = [];
            $listId  = Yii::$app->request->get('listId');
            $project = Project::findOne($listId);

            foreach (User::find()->where(['id' => [$project->ownerId, $project->assignedTo]])->each() as $user) {
                $result[] = [
                    'owner'   => $user->id == $project->ownerId ? 'Владелец' : '',
                    'name'    => $user->username,
                    'key'     => $user->id,
                    'userpic' => 'http://backend.madeasy.local/images/avatars/4.jpg',
                    'email'   => $user->email
                ];
            }

            return $result;
        }

        return null;
    }
}

