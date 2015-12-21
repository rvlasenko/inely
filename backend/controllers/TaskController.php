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
use backend\models\TaskLabels;
use common\components\formatter\FormatterComponent;
use common\models\User;
use common\models\UserProfile;
use Yii;
use yii\web\Controller;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class TaskController extends Controller
{
    public $userId;

    public function init()
    {
        $this->userId = Yii::$app->user->id;
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
     * Установка глабольных параметров, для приветствия пользователя и определения назначенных задач.
     *
     * Единственный экшн, чьи ответные данные будут рассматриваться без преобразования.
     * Т.е. заголовок "Content-Type" примет вид "text/html", а не "application/json".
     * @return string результат визуализации страницы
     */
    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;

        $userFirstName   = UserProfile::findOne($this->userId)->firstname;
        $projectProvider = new ActiveDataProvider([
            'query' => Project::find()
                              ->where  (['ownerId'    => $this->userId])
                              ->orWhere(['sharedWith' => $this->userId])
        ]);
        $labelProvider = new ActiveDataProvider([
            'query' => TaskLabels::find()
                              ->where(['ownerId' => $this->userId])
        ]);

        Yii::$app->view->params['firstName']    = $userFirstName ?: Yii::$app->user->identity->username;
        Yii::$app->view->params['assignedToMe'] = Task::findOne(['assignedTo' => $this->userId]);

        return $this->render('index', [
            'projectProvider' => $projectProvider,
            'labelProvider'   => $labelProvider
        ]);
    }

    /**
     * Формирование javascript объекта, содержащего в себе данные об узле, eg. имя, дата и т.д.
     * Первое обращение содержит параметр id со значением #, на этом этапе формируется корень.
     * При последующих обращениях выполняется поиск дочерних веток дерева у элемента с принятым id.
     * Является источником данных для [[$.jstree.core.data]].
     *
     * @param integer $id     Уникальный идентификатор задачи. Как и все - параметр GET запроса.
     * @param string  $sort   Сортировка по заданному условию. По умолчанию задачи сортируются по левому индексу.
     * @param integer $listId Уникальный идентификатор проекта (списка), по которому группируются требуемые задачи.
     * @param string  $group  Распределение задач по группам. Имеет три вида: входящие, сегодня, неделя.
     *
     * @return array данные преобразованные в JSON
     */
    public function actionNode($id, $sort = 'lft', $listId = null, $group = 'inbox')
    {
        if ($id === '#') {
            $node = TaskData::find()->roots($this->userId, $listId)->all();
        } else {
            $root = TaskData::findOne($id);
            $node = $root->children($this->userId, Task::ACTIVE_TASK, $sort, $listId, $group)->all();
        }

        return $this->buildTree($node);
    }

    /**
     * Валидация принятых атрибутов и добавление их значений в соответствующие поля базы данных.
     * В случае несоответствия формату, поле игнорируется и выбрасывается исключение.
     * @return bool если редактирование завершилось успешно.
     * @throws Exception если принятые атрибуты не прошли валидацию, либо не был получен id.
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
            throw new Exception('Переданы данные, несоответствующие формату');
        }

        return null;
    }

    /**
     * Создание новой задачи, исходя из полученного id родителя, и обновление её индексов.
     * Устанавливаем реляции в таблице "task_data".
     * Также принимаем метку, при наличии которой добавляем id задачи во внешнюю таблицу, иначе генерируем новую.
     * @return array json значение первичного ключа только что созданной ноды.
     * @throws Exception если принятые атрибуты не прошли валидацию.
     */
    public function actionCreate()
    {
        $taskPK     = null;
        $taskModel  = new Task();
        $newChild   = new TaskData();

        $request    = Yii::$app->request;
        $parentNode = TaskData::findOne(['dataId' => $request->post('id')]);

        if ($newChild->load($request->post())) {
            $newChild->prependTo($parentNode);
            $taskPK = $newChild->getPrimaryKey();

            $taskModel->taskId     = $taskPK;
            $taskModel->attributes = $request->post();

            if ($request->post('label')) {
                $this->setLabel($taskPK, $request->post('label'));
            }

            if (!$taskModel->save()) {
                throw new Exception('Невозможно сохранить данные');
            }
        } else {
            throw new Exception('Переданы данные, несоответствующие формату');
        }
    }

    /**
     * Перемещение узла с помощью Drag'n'Drop в определенную задачу.
     * Установка первичного ключа родителькой задачи и перемещенной.
     * @return bool если перемещение завершилось успешно.
     * @throws Exception при пустых значениях идентификаторов, указывающих на узел.
     */
    public function actionMove()
    {
        $parentId  = Yii::$app->request->post('parent');
        $draggedId = Yii::$app->request->post('id');

        if ($draggedId === null && $parentId === null) {
            throw new Exception('Невозможно переместить пустой узел');
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
     * Удаление существующей задачи и её дочерних задач со статусом завершенности от 1 до 2.
     * Также опциональный параметр - удаление всех завершенных задач в группе "Входящие", либо в проектах.
     * @return bool значение, если удаление записи всё-таки произошло.
     */
    public function actionDelete()
    {
        $request         = Yii::$app->request;
        $removeCompleted = $request->post('completed');
        $condition       = [
            'isDone'  => [Task::COMPLETED_TASK, Task::INCOMPLETE_TASK],
            'ownerId' => $this->userId,
            'listId'  => $request->post('listId')
        ];

        if ($removeCompleted) {
            foreach (TaskData::find()->joinWith(Task::tableName())->where($condition)->each() as $node) {
                $node->deleteWithChildren();
            }
        } else {
            $node = TaskData::findOne(['dataId' => $request->post('id')]);

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
            'inbox'  => ArrayHelper::getValue($quantity, '0.0.inbox'),
            'today'  => ArrayHelper::getValue($quantity, '1.0.today'),
            'next'   => ArrayHelper::getValue($quantity, '2.0.next'),
            'assign' => ArrayHelper::getValue($quantity, '3.0.assign')
        ];

        return $result;
    }

    /**
     * Формирование javascript объекта, содержащего в себе данные о завершенных задачах.
     * Первое обращение содержит параметр id со значением #, на этом этапе формируется корень.
     * При последующих обращениях выполняется поиск дочерних веток дерева у элемента с принятым id.
     *
     * @param integer $id     ID задачи. Как и все - параметр GET запроса.
     * @param integer $listId ID проекта (списка), по которому группируются требуемые задачи.
     *
     * @return array данные преобразованные в JSON
     */
    public function actionGetHistory($id, $listId = null)
    {
        if ($id === '#') {
            $node = TaskData::find()->roots($this->userId, $listId)->all();
        } else {
            $root = TaskData::findOne($id);
            $node = $root->children($this->userId, Task::COMPLETED_TASK, null, $listId)->all();
        }

        return $this->buildTree($node, true);
    }

    /**
     * Формирование комментариев задачи со свойствами в будущий объект и передача инициатору.
     * Инциатором запроса является callback $.magnificPopup.open в обработчике [[handleOpenSettings()]].
     *
     * @param integer $taskId ID задачи, для которой требуется сформировать комментарии.
     *
     * @return array|null json объект с комментариями пользователей.
     */
    public function actionGetComments($taskId)
    {
        if (Yii::$app->request->isAjax) {
            $result    = [];
            $formatter = new FormatterComponent();
            $task      = Task::findOne($taskId);

            foreach (TaskComments::find()->where(['taskId' => $task->taskId])->each() as $comment) {
                $result[] = [
                    'author'  => User::findOne($comment->userId)->username,
                    'time'    => $formatter->asRelativeDate($comment->timePosted),
                    'comment' => $comment->comment,
                    'picture' => '/images/avatars/4.jpg',
                ];
            }

            return $result;
        }

        return null;
    }

    /**
     * Запись комментария к необходимой задаче в базу данных, и передача инициатору запроса.
     * @return array объект с текущим комментарием.
     * @throws Exception если принятые атрибуты не прошли валидацию.
     */
    public function actionSetComment()
    {
        $request     = Yii::$app->request;
        $formatter   = new FormatterComponent();
        $taskComment = new TaskComments();

        if ($taskComment->load($request->post()) && $taskComment->save()) {
            return [
                'author'  => Yii::$app->user->identity->username,
                'time'    => $formatter->asRelativeDate($request->post('timePosted')),
                'comment' => $request->post('comment'),
                'picture' => '/images/avatars/4.jpg',
            ];
        } else {
            throw new Exception('Переданы данные, несоответствующие формату');
        }
    }

    /**
     * Установка к задаче контекстной метки во внешнюю таблицу, при наличии.
     *
     * @param integer $taskPK    Первичный ключ задачи, в которой может содержаться метка
     * @param string  $labelName Название метки, полученное от пользователя
     *
     * @return bool если сохранение завершилось успешно
     * @throws Exception при ошибке сохранения и валидации данных
     */
    protected function setLabel($taskPK, $labelName)
    {
        $labelModel = new TaskLabels();
        $taskLabel  = TaskLabels::findOne(['labelName' => $labelName]);

        if ($taskLabel) {
            $taskLabel->taskId = $taskPK;

            return $taskLabel->update();
        } else {
            $labelData = [
                'ownerId'    => $this->userId,
                'taskId'     => $taskPK,
                'labelName'  => $labelName,
                'badgeColor' => 'first'
            ];

            if ($labelModel->load($labelData) && !$labelModel->save()) {
                throw new Exception('Невозможно сохранить данные');
            }
        }
    }

    /**
     * Преоразование массива задач в объект вида:
     * [{
     *      "id":   "240",
     *      "text": "Child task",
     *      "a_attr": {
     *          "note":       "<p>Не забыть</p>",
     *          "degree":     "high",
     *          "incomplete": "true",
     *          "lname":      "новая метка",
     *          "assignedId": "26",
     *          "assigned":   "/images/avatars/some.jpg",
     *          "date":  "5 Янв",
     *          "rel":   "future",
     *          "hint":  "осталось 10 дней"
     *      },
     *      "icon":     "entypo-chat",
     *      "children": false
     * }]
     *
     * @param array $node        узел, сформированный в результате запроса
     * @param bool  $showHistory отображение завершенных задач
     *
     * @return array результат преобразования
     * @key int     id       уникальный идентификатор узла
     * @key string  text     строка определяющая имя задачи юзера
     * @key string  note     заметка к задаче как html, при наличии
     * @key string  degree   степень важности как css класс, от которого меняется цвет
     * @key bool    incomplete указывает на зависимость дочерней задачи, когда она выполнена, но всё ещё в списке
     * @key int     assignedId идентификатор юзера, на которого назначена задача
     * @key string  assigned   аватар юзера при делегированной ему задаче
     * @key string  date     дата (+ относительная), подсказки и подчеркивание
     * @key string  icon     при общении в комментариях к задаче стоит иконка
     * @key bool    children наличие дочерних узлов
     * @key bool    data     отображение активных (true) или завершенных (false) задач
     */
    protected function buildTree($node, $showHistory = false)
    {
        $result    = [];
        $formatter = new FormatterComponent();

        foreach ($node as $v) {
            $assignedId = $v[Task::tableName()]['assignedTo'];
            $taskLabel  = TaskLabels::findOne(['taskId' => $v['dataId']]);
            $taskComm   = TaskComments::findOne(['taskId' => $v['dataId']]);

            // Абсолютная дата выполнения например '6 окт.' или относительная 'через 3 дня'
            $dueDate = $formatter->asRelativeDate($v[Task::tableName()]['dueDate']);
            // Словесная дата степени просроченности, например 'today', 'future'
            $relativeDate = $formatter->timeInWords($v[Task::tableName()]['dueDate']);
            // Относительная дата для тултипа, кол-во оставшихся дней eg. '3 дня осталось'
            $futureDate = $formatter->dateLeft($v[Task::tableName()]['dueDate']);
            // Иконка при наличии комментария у задачи
            $hasComment = ArrayHelper::getValue($taskComm, function ($taskComm) {
                return $taskComm ? TaskComments::ICON_CLASS : null;
            });
            // Частичное завершение задачи (если она дочерняя)
            $incompletely = $v[Task::tableName()]['isDone'] == 2 ? true : false;
            // Наличие у пользователя делегированной задачи
            $isAssigned = $assignedId ? /*UserProfile::findOne(['user_id' => $assignedId])->avatar_path*/ '/images/avatars/4.jpg' : false;
            // Если для задачи установлена некая контекстная метка, отобразить её
            $labelName  = ArrayHelper::getValue($taskLabel, 'labelName', false);
            $labelColor = ArrayHelper::getValue($taskLabel, 'badgeColor', false);

            $result[] = [
                'id'       => $v['dataId'],
                'text'     => $v['name'],
                'a_attr' => [
                    'note'       => $v['note'],
                    'degree'     => $v[Task::tableName()]['taskPriority'],
                    'incomplete' => $incompletely,
                    'lname'      => $labelName,
                    'lcolor'     => $labelColor,
                    'assigned'   => $isAssigned,
                    'assignId'   => $assignedId,
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
