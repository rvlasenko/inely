<?php

/**
 * Этот контроллер является частью проекта Inely.
 *
 * @link    http://github.com/hirootkit/inely
 * @licence http://github.com/hirootkit/inely/blob/master/LICENSE.md GPL
 * @author  hirootkit <admiralexo@gmail.com>
 */

namespace backend\controllers;

use backend\models\GamifyLevels;
use backend\models\GamifyUserStats;
use backend\models\Project;
use backend\models\Task;
use backend\models\TaskData;
use backend\models\TaskLabels;
use Yii;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class TaskController
 * @package backend\controllers
 */
class TaskController extends Controller
{
    public $userId;
    public $layout = 'task';

    public function init()
    {
        $this->userId = Yii::$app->user->id;
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ]
        ];
    }

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
                    'get-history' => ['get'],
                    'node'        => ['get'],
                    'create'      => ['post'],
                    'delete'      => ['post'],
                    'edit'        => ['post'],
                ]
            ],
            /*'pageCache' => [
                'class'      => 'yii\filters\PageCache',
                'duration'   => 1024,
                'dependency' => [
                    'class' => 'yii\caching\DbDependency',
                    'sql'   => 'SELECT MAX(updatedAt) FROM tasks'
                ]
            ],*/
            [
                'class'   => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ];
    }

    /**
     * Визуализация контента менеджера задач и передача списка проектов пользователя в layout блок.
     * Установка глабольных параметров, для приветствия пользователя и определения назначенных задач.
     *
     * Единственный экшн, чьи ответные данные будут рассматриваться без преобразования.
     * Т.е. заголовок "Content-Type" примет вид "text/html", а не "application/json".
     * @return string результат визуализации страницы
     */
    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;

        // Получить как личные так и общие проекты
        $projectProvider = new ActiveDataProvider([
            'query' => Project::find()
                ->where(['ownerId' => $this->userId])
                ->orWhere(['sharedWith' => $this->userId])
        ]);

        // Получить все метки
        $labelProvider = new ActiveDataProvider([
            'query' => TaskLabels::find(['ownerId' => $this->userId])
        ]);

        return $this->render('index', [
            'projectProvider' => $projectProvider,
            'labelProvider'   => $labelProvider
        ]);
    }

    /**
     * Формирование объекта, содержащего в себе данные об узле, eg. имя, дата и т.д.
     * Первое обращение содержит параметр id со значением #, на этом этапе формируется корень.
     * При последующих обращениях выполняется поиск дочерних веток дерева у элемента с принятым id.
     * Является источником данных для [[$.jstree.core.data]].
     * @method ActiveQuery roots(array $data) Получает корневой узел.
     *
     * @param integer $id     Уникальный идентификатор задачи.
     * @param string  $sort   Сортировка по условию. По умолчанию происходит по левому индексу.
     * @param integer $listId Уникальный идентификатор проекта (списка), по которому группируются задачи.
     * @param string  $group  Распределение задач по группам: входящие, сегодня, неделя.
     *
     * @return array данные преобразованные в JSON
     */
    public function actionNode($id, $sort = 'lft', $listId = null, $group = 'inbox')
    {
        $model = new Task();

        if ($id == '#') {
            $node = TaskData::find()->roots([
                'author' => $this->userId,
                'listID' => $listId
            ])->all();
        } else {
            $root = TaskData::findOne($id);
            $node = $root->children([
                'ownerID' => $this->userId,
                'history' => Task::ACTIVE_TASK,
                'sort'    => $sort,
                'listID'  => $listId,
                'group'   => $group
            ])->all();
        }

        return $model->buildTree($node);
    }

    /**
     * Валидация принятых атрибутов и массовое их присваивание.
     * В случае несоответствия формату, поле игнорируется и выбрасывается исключение.
     * @return bool если редактирование завершилось успешно.
     * @throws Exception если принятые атрибуты не прошли валидацию, либо не был получен id.
     */
    public function actionEdit()
    {
        $request  = Yii::$app->request;
        $task     = Task::findOne($request->post('id'));
        $taskData = TaskData::findOne(['dataId' => $request->post('id')]);

        if ($task->load($request->post()) && $taskData->load($request->post())) {
            if ($task->update() && $taskData->update()) {
                return true;
            }
        }
    }

    /**
     * Поиск задачи по идентификатору для присовения выполненного статуса.
     * @return bool при успешном обновлении поля "isDone"
     * @throws Exception если невозможно обновить задачу
     * @throws NotFoundHttpException если задачи с указанным идентификатором нет
     */
    public function actionDone()
    {
        $request   = Yii::$app->request;
        $userName  = Yii::$app->user->identity->username;
        $taskModel = Task::findOne($request->post('id'));

        if ($taskModel->load($request->post()) && $taskModel->update()) {
            (new GamifyUserStats())->updateCounter([
                'isDone'   => $request->post('isDone'),
                'userName' => $userName
            ]);

            return (new GamifyLevels())->addExperience($userName, 20);
        } else {
            throw new Exception('Невозможно выполнить задачу');
        }
    }

    /**
     * Создание новой вложенной задачи в иную родительскую задачу, либо в корень.
     * Устанавливаем реляции в таблице "task_data", обновляем индексы.
     * Также принимаем параметры Smarty Add, если обнаружена метка, добавляем её во внешнюю таблицу.
     * @method boolean prependTo(ActiveRecord $node) Добавляет задачу внутрь другой задачи.
     * @return array json значение первичного ключа только что созданной задачи.
     * @throws Exception если принятые атрибуты не прошли валидацию.
     */
    public function actionCreate()
    {
        $request    = Yii::$app->request;
        $parentTask = TaskData::findOne(['dataId' => $request->post('id')]);
        $taskModel  = new Task();
        $taskLabel  = new TaskLabels();
        $childTaskData = new TaskData();

        if ($childTaskData->load($request->post()) && $childTaskData->prependTo($parentTask)) {
            $taskModel->ownerId    = Yii::$app->user->id;
            $taskModel->attributes = $request->post();
            $taskModel->link('taskData', $childTaskData);

            return (new GamifyLevels())->addExperience(Yii::$app->user->identity->username, 10);
        }

        if (ArrayHelper::keyExists('label', $request->post())) {
            $taskLabel->setLabel([
                'taskPK'    => $childTaskData->getPrimaryKey(),
                'labelName' => $request->post('label')
            ]);
        }
    }

    /**
     * Перемещение задачи с помощью Drag'n'Drop.
     * Ищем существующие задачи в базе и присваиваем новые индексы.
     * @return bool если перемещение завершилось успешно.
     * @throws Exception при пустых ids, указывающих на задачу.
     */
    public function actionMove()
    {
        $parentId  = Yii::$app->request->post('parent');
        $draggedId = Yii::$app->request->post('id');

        $draggedNode = TaskData::findOne(['dataId' => $draggedId]);
        $parentNode  = TaskData::findOne(['dataId' => $parentId]);

        if (!$draggedNode->prependTo($parentNode)) {
            throw new Exception('Невозможно переместить пустой узел');
        }

        return $draggedNode->getPrimaryKey();
    }

    /**
     * Удаление существующей задачи и всех её дочерних со статусом завершенности от 1 до 2.
     * Опциональный параметр - удаление всех завершенных задач в группах, либо в проектах.
     * @return mixed|null если удаление записи всё-таки произошло.
     * @throws Exception при внезапной ошибке удаления задачи и всех в неё вложенных.
     */
    public function actionDelete()
    {
        $model       = new Task();
        $request     = Yii::$app->request;
        $rmCompleted = $request->post('completed');
        $condition   = [
            'isDone'  => [Task::COMPLETED_TASK, Task::INCOMPLETE_TASK],
            'ownerId' => $this->userId,
            'listId'  => $request->post('listId')
        ];

        if ($rmCompleted) {
            $model->removeCompleted($condition);
        } else {
            $task = TaskData::findOne(['dataId' => $request->post('id')]);
            $task->deleteWithChildren();

            return $task->getPrimaryKey();
        }

        return null;
    }

    /**
     * Получение количества задач в каждой группе [[getCountOfGroups()]].
     * Нормализация данных и отправка в jQuery.getJSON().
     * @return array данные преобразованные в JSON
     */
    public function actionGetTaskCount()
    {
        return Task::getCountOfGroups();
    }

    /**
     * Формирование объекта, содержащего в себе данные о завершенных задачах.
     * Первое обращение содержит параметр id со значением #, на этом этапе формируется корень.
     * При последующих обращениях выполняется поиск дочерних веток дерева у элемента с принятым id.
     * @method ActiveQuery roots(array $data) Получает корневой узел.
     *
     * @param integer $id     ID задачи.
     * @param integer $listId ID проекта (списка), по которому группируются требуемые задачи.
     *
     * @return array данные преобразованные в JSON
     */
    public function actionGetHistory($id, $listId = null)
    {
        $model = new Task();

        if ($id == '#') {
            $node = TaskData::find()->roots([
                'author' => $this->userId,
                'listID' => $listId
            ])->all();
        } else {
            $root = TaskData::findOne($id);

            $node = $root->children([
                'ownerID' => $this->userId,
                'history' => Task::COMPLETED_TASK,
                'sort'    => null,
                'listID'  => $listId,
                'group'   => 'inbox'
            ])->all();
        }

        return $model->buildTree($node);
    }

    /**
     * @param \yii\base\Action $action
     *
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if ($action->id == 'error') {
                Yii::$app->response->format = Response::FORMAT_HTML;
            }

            return true;
        }

        return false;
    }
}
