<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace backend\controllers;

use backend\models\Task;
use backend\models\TaskData;
use common\components\formatter\FormatterComponent;
use Yii;
use yii\base\Controller;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
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
                        'allow' => true, 'roles' => ['@']
                    ],
                    [
                        'allow' => false, 'roles' => ['?']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post']
                ]
            ],
            /*[
                'class'        => 'yii\filters\HttpCache',
                'only'         => ['index'],
                'lastModified' => function () {
                    $q = new Query();
                    return $q->from('tasks')->max('updatedAt');
                },
            ],
            'pageCache' => [
                'class'      => 'yii\filters\PageCache',
                'only'       => ['index'],
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
     * Визуализация основного содержимого менеджера задач и применение шаблона (layout) main.
     * Единственный метод, чьи ответные данные будут рассматриваться без какого-либо преобразования.
     * Т.е. заголовок "Content-Type" примет вид "text/html".
     * @return string результат визуализации страницы
     */
    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;

        return $this->render('index');
    }

    /**
     * Формирование javascript хэша, содержащего в себе данные об узле, например, имя, дату и т.д.
     * Первое обращение содержит параметр id со значением #, здесь формируется корень.
     * При последующих обращениях выполняется поиск дочерних веток дерева у элемента с принятым id.
     * Является источником данных для [[$.jstree.core.data]].
     * @return array данные преобразованные в JSON
     * @see behaviours [ContentNegotiator]
     */
    public function actionNode()
    {
        $nodeId = Yii::$app->request->get('id');
        $sortBy = Yii::$app->request->get('sort');
        $userId = Yii::$app->user->id;

        if ($nodeId === '#') {
            $node = TaskData::find()->roots($userId)->all();
        } else {
            $root = TaskData::findOne($nodeId);
            $node = $root->children($userId, Task::ACTIVE_TASK, $sortBy)->all();
        }

        return $this->buildTree($node);
    }

    /**
     * Редактирование узла используя принятый идентификатор и редактируемые параметры.
     * @return bool результат сконвертированный в JSON.
     * @throws \Exception если переименовывание завершилось неудачей, либо не был получен id.
     */
    public function actionRename()
    {
        $node   = $this->checkParam('id');
        $result = $this->rename($node, [
            'name'     => $this->checkParam('text'),
            'format'   => $this->checkParam('fr'),
            'priority' => $this->checkParam('pr'),
            'dueDate'  => $this->checkParam('dt')
        ]);

        return $result;
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

        if ($taskModel->load($request->post(), '') && $taskModel->save()) {
            $newChild->load($request->post(), '');
            $newChild->prependTo($parentNode);
            $taskModel->link('taskData', $newChild);
        } else {
            throw new HttpException(500, $taskModel->getErrors());
        }

        return $newChild->getPrimaryKey();
    }

    /**
     * Перемещение узла с помощью Drag'n'Drop в указанную позицию какой-либо родительской ветки.
     * @return bool если перемещение завершилось успехом.
     * @throws \Exception если пользователь переместил родительскую ветку внутрь дочерней.
     */
    public function actionMove()
    {
        $node   = $this->checkParam('id');
        $parent = $this->checkParam('parent');
        $result = $this->move($node, $parent, $this->checkParam('position'));

        return $result;
    }

    /**
     * Удаление существующей ветки дерева и её дочерних элементов.
     * Также опциональный параметр - удаление уже завершенных задач.
     * @return bool значение, если удаление записи всё-таки произошло.
     * @throws NotFoundHttpException если пользователь захотел удалить несуществующий узел.
     */
    public function actionDelete()
    {
        $removeCompleted = Yii::$app->request->post('completed');
        $condition = ['isDone' => Task::COMPLETED_TASK, 'userId' => Yii::$app->user->id];

        if ($removeCompleted) {
            if (Task::deleteAll($condition)) {
                return true;
            }
        } else {
            $node = TaskData::findOne(['dataId' => Yii::$app->request->post('id')]);
            if ($node->deleteWithChildren()) {
                return true;
            }
        }

        return null;
    }

    /**
     * Поиск задачи по идентификатору и присвоение ей новой степени важности.
     * @return bool при успешном обновлении поля "priority"
     * @throws HttpException если невозможно обновить задачу
     * @throws NotFoundHttpException если задачи с указанным идентификатором нет
     */
    public function actionSetPriority()
    {
        $taskModel = Task::findOne(Yii::$app->request->post('id'));

        if ($taskModel !== null) {
            if ($taskModel->load(Yii::$app->request->post(), '') && $taskModel->update()) {
                return true;
            } else {
                throw new HttpException(500, 'Unable to save user data');
            }
        } else {
            throw new NotFoundHttpException('Could not set on non-existing node');
        }
    }
    /**
     * Получение количества задач в каждой группе методом [[getCountOfGroups()]].
     * А также нормализация данных и передача во внешнюю функцию jQuery.getJSON().
     * @return array данные преобразованные в JSON
     */
    public function actionGetTaskCount()
    {
        $quantity = Task::getCountOfGroups();
        $result   = [
            'inbox' => $quantity[0][0]['inbox'],
            'today' => $quantity[1][0]['today'],
            'next'  => $quantity[2][0]['next']
        ];

        return $result;
    }

    /**
     * Формирование javascript хэша, содержащего в себе данные о завершенных задачах.
     * Первое обращение содержит параметр id со значением #, здесь формируется корень.
     * При последующих обращениях выполняется поиск дочерних веток дерева у элемента с принятым id.
     * @return array данные преобразованные в JSON
     */
    public function actionGetHistory()
    {
        $taskId = Yii::$app->request->get('id');
        $userId = Yii::$app->user->id;

        if ($taskId === '#') {
            $node = TaskData::find()->roots($userId)->all();
        } else {
            $root = TaskData::findOne($taskId);
            $node = $root->children($userId, Task::COMPLETED_TASK)->all();
        }

        return $this->buildTree($node, true);
    }

    /**
     * Поиск задачипо идентификатору для последующего присовения выполненного статуса.
     * @return bool при успешном обновлении поля "isDone"
     * @throws HttpException если невозможно обновить задачу
     * @throws NotFoundHttpException если задачи с указанным идентификатором нет
     */
    public function actionDone()
    {
        $taskModel = Task::findOne(Yii::$app->request->post('id'));

        if ($taskModel !== null) {
            if ($taskModel->load(Yii::$app->request->post(), '') && $taskModel->update()) {
                return true;
            } else {
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
     * @param array $temp        узел, сформированный в результате запроса
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
    protected function buildTree($temp, $showHistory = false)
    {
        $result    = [];
        $formatter = new FormatterComponent();

        foreach ($temp as $v) {
            // Абсолютная дата например '6 окт.' или относительная 'через 3 дня'
            $dueDate = $formatter->asRelativeDate($v[Task::tableName()]['dueDate']);
            // Словесная дата для подчеркивания в дереве например 'today', 'future'
            $relativeDate = $formatter->timeInWords($v[Task::tableName()]['dueDate']);
            // Относительная дата для тултипа, сколько дней осталось eg. '3 дня осталось'
            $futureDate = $formatter->dateLeft($v[Task::tableName()]['dueDate']);

            // Форматирование текста пользовательскими начертаниями
            $format  = is_null($v['format']) ? false : $v['format'];
            // Наличие заметки или комментария у задачи
            $hasNote = is_null($v['note']) ? null : 'fa fa-commenting';

            switch ($v[Task::tableName()]['taskPriority']) {
                case 3:  $priority = Task::PR_HIGH;   break;
                case 2:  $priority = Task::PR_MEDIUM; break;
                case 1:  $priority = Task::PR_LOW;    break;
                default: $priority = null;
            }

            $result[] = [
                'id'       => $v['dataId'],
                'text'     => $v['name'],
                'a_attr'   => ['class' => $priority, 'format' => $format],
                'li_attr'  => ['date' => $dueDate, 'rel' => $relativeDate, 'hint' => $futureDate],
                'icon'     => $hasNote,
                'children' => ($v['rgt'] - $v['lft'] > 1),
                'data'     => $showHistory
            ];
        }

        return $result;
    }
}
