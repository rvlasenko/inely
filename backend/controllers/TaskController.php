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
use common\components\formatter\FormatterComponent;
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
                    'node'         => ['get'],
                    'create'       => ['post'],
                    'delete'       => ['post'],
                    'edit'         => ['post'],
                    'set-priority' => ['post'],
                    'done'         => ['post']
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
                'variations' => [Yii::$app->language],
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
     * Визуализация контента менеджера задач и передача списков пользователя в сооответствующий блок.
     * Единственный экшн, чьи ответные данные будут рассматриваться без преобразования.
     * Т.е. заголовок "Content-Type" примет вид "text/html", а не "application/json".
     * @return string результат визуализации страницы
     */
    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;

        $query        = Project::find()
                               ->where(['ownerId' => Yii::$app->user->id])
                               ->orWhere(['assignedTo' => Yii::$app->user->id]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * Формирование javascript хэша, содержащего в себе данные об узле, например, имя, дату и т.д.
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
        $ownerId = Yii::$app->user->id;

        if ($nodeId === '#') {
            $node = TaskData::find()->roots($ownerId, $listId)->all();
        } else {
            $root = TaskData::findOne($nodeId);
            $node = $root->children($ownerId, Task::ACTIVE_TASK, $sortBy, $listId)->all();
        }

        return $this->buildTree($node);
    }

    /**
     * Редактирование узла через принятый идентификатор и применение новых параметров.
     * @return bool если редактирование завершилось успешно.
     * @throws \Exception если переименовывание завершилось неудачей, либо не был получен id.
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
            throw new HttpException(500, $taskModel->getErrors());
        }

        return null;
    }

    /**
     * Создание нового узла, исходя из полученного родительского идентификатора, и обновление левых и правых индексов.
     * Также установка реляции на основании вторичного ключа в первой модели, который соответствует первичному ключу во второй.
     * @return array идентификатор только что созданной ветки, сконвертированный в JSON.
     * @throws HttpException если невозможно записать внесённые изменения.
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
            throw new HttpException(500, $taskModel->getErrors());
        }

        return null;
    }

    /**
     * Перемещение узла с помощью Drag'n'Drop в родительскую ветку и обратно.
     * @return bool если перемещение завершилось успешно.
     * @throws Exception при пустых значениях идентификаторов, определяющие узел.
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
     * Также опциональный параметр - удаление уже завершенных задач в списке ("Входящие", либо пользовательские).
     * @return bool значение, если удаление записи всё-таки произошло.
     * @throws NotFoundHttpException если пользователь захотел удалить несуществующий узел.
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
     * Поиск задачи по идентификатору и присвоение иной степени важности.
     * @return bool при успешном обновлении поля "taskPriority"
     * @throws HttpException если невозможно обновить задачу
     * @throws NotFoundHttpException если задачи с указанным идентификатором нет
     */
    public function actionSetPriority()
    {
        $request   = Yii::$app->request;
        $taskModel = Task::findOne($request->post('id'));

        if ($taskModel !== null) {
            if ($taskModel->load($request->post()) && $taskModel->update()) {
                return $taskModel->getPrimaryKey();
            } else {
                throw new HttpException(500, 'Unable to save user data');
            }
        } else {
            throw new NotFoundHttpException('Could not set on non-existing node');
        }
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
     * @return array данные преобразованные в JSON
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
     * Поиск задачи по идентификатору для присовения выполненного статуса.
     * @return bool при успешном обновлении поля "isDone"
     * @throws HttpException если невозможно обновить задачу
     * @throws NotFoundHttpException если задачи с указанным идентификатором нет
     */
    public function actionDone()
    {
        $request   = Yii::$app->request;
        $taskModel = Task::findOne($request->post('id'));

        if ($taskModel !== null) {
            if ($taskModel->load($request->post()) && !$taskModel->update()) {
                throw new HttpException(500, 'Unable to get thing done');
            }
        } else {
            throw new NotFoundHttpException('Could not set on non-existing node');
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

            // Форматирование текста пользовательскими начертаниями
            $format = empty($v['format']) ? false : $v['format'];
            // Наличие заметки или комментария у задачи
            $hasNote = empty($v['note']) ? null : 'fa fa-commenting';
            // Частичное завершение задачи (является дочерней)
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
                    'format'     => $format,
                    'incomplete' => $incompletely,
                    'date'       => $dueDate,
                    'rel'        => $relativeDate,
                    'hint'       => $futureDate
                ],
                'icon'     => $hasNote,
                'children' => ($v['rgt'] - $v['lft'] > 1),
                'data'     => $showHistory
            ];
        }

        return $result;
    }
}
