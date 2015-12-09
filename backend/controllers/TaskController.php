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
use backend\models\TaskComments;
use backend\models\TaskData;
use common\components\formatter\FormatterComponent;
use common\models\User;
use common\models\UserProfile;
use Yii;
use yii\base\Controller;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class TaskController extends Controller
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
                    'get-history'  => ['get'],
                    'get-comments' => ['get'],
                    'node'         => ['get'],
                    'create'       => ['post'],
                    'delete'       => ['post'],
                    'edit'         => ['post'],
                    'set-comment'  => ['post']
                ]
            ],
            /*[
                'class'        => 'yii\filters\HttpCache',
                'lastModified' => function () {
                    $q = new Query();

                    return $q->from('tasks')->max('updatedAt');
                },
            ],
            'pageCache' => [
                'class'      => 'yii\filters\PageCache',
                'duration'   => 640,
                'dependency' => [
                    'class' => 'yii\caching\DbDependency',
                    'sql'   => 'SELECT MAX(updatedAt) FROM tasks'
                ]
            ],*/
            [
                'class'   => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ];
    }

    /**
     * Визуализация контента менеджера задач и передача списка проектов пользователя в layout блок.
     * Установка глабольного параметра, для приветствия пользователя.
     * Единственный экшн, чьи ответные данные будут рассматриваться без преобразования.
     * Т.е. заголовок "Content-Type" примет вид "text/html", а не "application/json".
     * @return string результат визуализации страницы
     */
    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;

        $userFirstName                        = UserProfile::findOne(Yii::$app->user->id)->firstname;
        Yii::$app->view->params['first-name'] = $userFirstName ?: Yii::$app->user->identity->username;

        $dataProvider = new ActiveDataProvider([
            'query' => Project::find()
                              ->where(['ownerId' => Yii::$app->user->id])
                              ->orWhere(['assignedTo' => Yii::$app->user->id])
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * Формирование javascript хэша, содержащего в себе данные об узле, eg. имя, дата и т.д.
     * Первое обращение содержит параметр id со значением #, на этом этапе формируется корень.
     * При последующих обращениях выполняется поиск дочерних веток дерева у элемента с принятым id.
     * Является источником данных для [[$.jstree.core.data]].
     * @return array данные преобразованные в JSON
     */
    public function actionNode()
    {
        $nodeId  = Yii::$app->request->get('id');
        $listId  = Yii::$app->request->get('listId');
        $sortBy  = Yii::$app->request->get('sort');
        $group   = Yii::$app->request->get('group');
        $ownerId = Yii::$app->user->id;

        if ($nodeId === '#') {
            $node = TaskData::find()->roots($ownerId, $listId)->all();
        } else {
            $root = TaskData::findOne($nodeId);
            $node = $root->children($ownerId, Task::ACTIVE_TASK, $sortBy, $listId, $group)->all();
        }

        return $this->buildTree($node);
    }

    /**
     * Валидация принятых атрибутов и добавление их значений в соответствующие поля базы данных.
     * В случае несоответствия формату, поле игнорируется и выбрасывается исключение.
     * @return bool если редактирование завершилось успешно.
     * @throws HttpException если принятые атрибуты не прошли валидацию, либо не был получен id.
     */
    public function actionEdit()
    {
        $request   = Yii::$app->request;
        $taskModel = Task::findOne($request->post('id'));
        $taskData  = TaskData::findOne(['dataId' => $request->post('id')]);

        if ($taskModel->load($request->post()) && $taskModel->save()) {
            if ($taskData->load($request->post()) && $taskData->save()) {
                return true;
            }
        } else {
            throw new HttpException(500, 'Wrong data passed');
        }

        return null;
    }

    /**
     * Создание нового узла, исходя из полученного родительского идентификатора, и обновление индексов ноды.
     * Установка реляции на основании вторичного ключа в первой модели.
     * @return array json значение первичного ключа только что созданной ноды.
     * @throws HttpException если принятые атрибуты не прошли валидацию.
     */
    public function actionCreate()
    {
        $taskModel  = new Task();
        $newChild   = new TaskData();
        $request    = Yii::$app->request;
        $parentNode = TaskData::findOne(['dataId' => $request->post('id')]);

        if ($newChild->load($request->post())) {
            $newChild->prependTo($parentNode);

            $taskModel->taskId     = $newChild->getPrimaryKey();
            $taskModel->attributes = $request->post();

            if ($taskModel->save()) {
                return true;
            }
        } else {
            throw new HttpException(500, 'Wrong data passed');
        }

        return null;
    }

    /**
     * Перемещение узла с помощью Drag'n'Drop в определенную ветвь.
     * Установка первичного ключа родителькой ноды перемещенной ноде.
     * @return bool если перемещение завершилось успешно.
     * @throws Exception при пустых значениях идентификаторов, указывающих на узел.
     */
    public function actionMove()
    {
        $parentId  = Yii::$app->request->post('parent');
        $draggedId = Yii::$app->request->post('id');

        if ($draggedId === null && $parentId === null) {
            throw new Exception('Cannot move null node');
        } else {
            $draggedNode = TaskData::findOne(['dataId' => $draggedId]);
            $parentNode  = TaskData::findOne(['dataId' => $parentId]);

            if ($draggedNode->prependTo($parentNode)) {
                return $draggedNode->getPrimaryKey();
            }
        }

        return null;
    }

    /**
     * Удаление существующей ветки дерева и её дочерних элементов в диапазоне от 1 до 2.
     * Также опциональный параметр - удаление уже завершенных задач в группе "Входящие", либо в проектах.
     * @return bool значение, если удаление записи всё-таки произошло.
     */
    public function actionDelete()
    {
        $removeCompleted = Yii::$app->request->post('completed');
        $condition       = [
            'isDone'  => Task::COMPLETED_TASK,
            'ownerId' => Yii::$app->user->id,
            'listId'  => ArrayHelper::getValue(Yii::$app->request->post(), 'listId', null)
        ];

        if ($removeCompleted) {
            foreach (TaskData::find()->joinWith(Task::tableName())->where($condition)->each() as $node) {
                $node->deleteWithChildren();
            }
        } else {
            $node = TaskData::findOne(['dataId' => Yii::$app->request->post('id')]);

            if ($node->deleteWithChildren()) {
                return $node->getPrimaryKey();
            }
        }

        return null;
    }

    /**
     * Получение количества задач в каждой группе [[getCountOfGroups()]].
     * А также нормализация данных и передача во внешнюю функцию jQuery.getJSON().
     * @return array данные преобразованные в JSON
     */
    public function actionGetTaskCount()
    {
        $quantity = Task::getCountOfGroups();
        $result   = [
            'inbox' => ArrayHelper::getValue($quantity, '0.0.inbox'),
            'today' => ArrayHelper::getValue($quantity, '1.0.today'),
            'next'  => ArrayHelper::getValue($quantity, '2.0.next')
        ];

        return $result;
    }

    /**
     * Формирование javascript хэша, содержащего в себе данные о завершенных задачах.
     * Первое обращение содержит параметр id со значением #, на этом этапе формируется корень.
     * При последующих обращениях выполняется поиск дочерних веток дерева у элемента с принятым id.
     * @return array json данные
     */
    public function actionGetHistory()
    {
        $taskId  = Yii::$app->request->get('id');
        $listId  = Yii::$app->request->get('listId');
        $ownerId = Yii::$app->user->id;

        if ($taskId === '#') {
            $node = TaskData::find()->roots($ownerId, $listId)->all();
        } else {
            $root = TaskData::findOne($taskId);
            $node = $root->children($ownerId, Task::COMPLETED_TASK, null, $listId)->all();
        }

        return $this->buildTree($node, true);
    }

    /**
     * Поиск комментариев необходимой задачи и их формирование со свойствами в объект.
     * @return array|null json объект с комментариями пользователей.
     */
    public function actionGetComments()
    {
        if (Yii::$app->request->isAjax) {
            $result = [];
            $task   = Task::findOne(Yii::$app->request->get('taskId'));

            foreach (TaskComments::find()->where(['taskId' => $task->taskId])->each() as $comment) {
                $result[] = [
                    'author'  => User::findOne($comment->userId)->username,
                    'time'    => (new FormatterComponent())->asRelativeDate($comment->timePosted),
                    'comment' => $comment->comment,
                    'userpic' => 'http://backend.madeasy.local/images/avatars/4.jpg',
                ];
            }

            return $result;
        }

        return null;
    }

    /**
     * Установка комментария к необходимой задаче, его формирование и передача инициатору запроса.
     * @return array json объект с текущим комментарием.
     * @throws HttpException если принятые атрибуты не прошли валидацию.
     */
    public function actionSetComment()
    {
        $request     = Yii::$app->request;
        $taskComment = new TaskComments();

        if ($taskComment->load($request->post()) && $taskComment->save()) {
            return [
                'author'  => Yii::$app->user->identity->username,
                'time'    => (new FormatterComponent())->asRelativeDate($request->post('timePosted')),
                'comment' => $request->post('comment'),
                'userpic' => 'http://backend.madeasy.local/images/avatars/4.jpg',
            ];
        } else {
            throw new HttpException(500, 'Wrong data passed');
        }
    }

    /**
     * Преоразование полученного массива веток в JSON строку подобного вида:
     * [{
     *      "id":   "240",
     *      "text": "Child",
     *      "a_attr": {
     *          "class" : "high",
     *          "format": false
     *      },
     *      "li_attr": {
     *          "rel":  "future",
     *          "date": "через 3 дня",
     *          "hint": "осталось 5 дней"
     *      },
     *      "icon":     "fa fa-commenting",
     *      "children": true
     * }]
     *
     * @param array $node        узел, сформированный в результате запроса
     * @param bool  $showHistory отображение завершенных задач
     *
     * @return array результат преобразования
     * @key int    id       идентификатор узла
     * @key string text     наименование
     * @key string a_attr   степень важности
     * @key string li_attr  дата (+ относительная), подсказки, подчеркивание
     * @key string icon     наличие заметок
     * @key bool   children наличие дочерних узлов
     * @key bool   data     показ завершенных задач
     */
    protected function buildTree($node, $showHistory = false)
    {
        $result    = [];
        $formatter = new FormatterComponent();

        foreach ($node as $v) {
            // Абсолютная дата выполнения например '6 окт.' или относительная 'через 3 дня'
            $dueDate = $formatter->asRelativeDate($v[Task::tableName()]['dueDate']);
            // Словесная дата степени просроченности, например 'today', 'future'
            $relativeDate = $formatter->timeInWords($v[Task::tableName()]['dueDate']);
            // Относительная дата для тултипа, кол-во оставшихся дней eg. '3 дня осталось'
            $futureDate = $formatter->dateLeft($v[Task::tableName()]['dueDate']);

            // Иконка при наличии комментария у задачи
            $hasComment = empty(TaskComments::findOne(['taskId' => $v['dataId']])) ? null : 'entypo-chat';
            // Частичное завершение задачи (если она дочерняя)
            $incompletely = $v[Task::tableName()]['isDone'] == 2 ? true : false;

            switch ($v[Task::tableName()]['taskPriority']) {
                case 3:
                    $priority = Task::PR_HIGH;
                    break;
                case 2:
                    $priority = Task::PR_MEDIUM;
                    break;
                case 1:
                    $priority = Task::PR_LOW;
                    break;
                default:
                    $priority = null;
            }

            $result[] = [
                'id'       => $v['dataId'],
                'text'     => $v['name'],
                'a_attr'   => [
                    'note'       => $v['note'],
                    'class'      => $priority,
                    'incomplete' => $incompletely,
                    'date'       => $dueDate,
                    'rel'        => $relativeDate,
                    'hint'       => $futureDate
                ],
                'icon'     => $hasComment,
                'children' => ($v['rgt'] - $v['lft'] > 1),
                'data'     => $showHistory
            ];
        }

        return $result;
    }
}
