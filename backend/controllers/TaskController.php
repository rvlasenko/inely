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
                    'node' => ['post']
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
                'only'    => ['node', 'rename', 'create', 'move', 'delete'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ];
    }

    /**
     * Визуализация основного содержимого менеджера задач и применение шаблона (layout).
     * @return string результат визуализации страницы
     */
    public function actionIndex()
    {
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
        $id = Yii::$app->request->post('id');

        if ($id === '#') {
            $node = TaskData::find()->roots()->all();
        } else {
            $root = TaskData::findOne($id);
            $node = $root->children(Yii::$app->user->id)->all();
        }

        return $this->buildTree($node);
    }

    /**
     * Редактирование ветки дерева используя его полученный идентификатор и редактируемые параметры.
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
     * Создание новой ветки, исходя из полученного родительского идентификатора, и обновление левых/правых индексов.
     * Также установка реляции на основании вторичного ключа в первой модели, которые соответствуют первичному ключу во второй.
     * @return array с идентификатором только что созданной ветки, сконвертированный в JSON.
     * @throws HttpException если невозможно записать внесённые изменения.
     */
    public function actionCreate()
    {
        $taskModel = new Task();
        $newChild  = new TaskData();

        if ($taskModel->save()) {
            $parentNode = TaskData::findOne(['dataId' => Yii::$app->request->post('id')]);
            $newChild->load(Yii::$app->request->post(), '');
            $newChild->prependTo($parentNode);
            $taskModel->link('taskData', $newChild);
        } else {
            throw new HttpException(500, $taskModel->getErrors());
        }

        return $newChild->getPrimaryKey();
    }

    /**
     * Перемещение узла с помощью d'n'd в указанную позицию какой-либо родительской ветки.
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
     * @return bool значение, если удаление записи всё-таки произошло.
     * @throws NotFoundHttpException если пользователь захотел удалить несуществующий узел.
     */
    public function actionDelete()
    {
        $node   = $this->checkParam('id');
        $result = $this->remove($node);

        return $result;
    }

    /**
     * Изменение степени важности для полученной задачи.
     * @return bool при успешном обновлении поля "priority"
     * @throws HttpException если невозможно обновить задачу
     * @throws NotFoundHttpException если задачи с указанным идентификатором нет
     */
    public function actionSetPriority()
    {
        $node = $this->checkParam('id');
        $pr   = $this->checkParam('pr');

        if ($node && Task::findOne($node)) {
            $task           = Task::findOne($node);
            $task->priority = $pr;

            if ($task->save()) {
                return true;
            } else {
                throw new HttpException(500, 'Unable to save user data');
            }
        } else {
            throw new NotFoundHttpException('Could not set on non-existing node');
        }
    }

    public function actionDone()
    {
        // Находим конкретную запись для последующего обновления
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
     *          "class" : null,
     *          "format": false
     *      },
     *      "li_attr": {
     *          "rel":  "future",
     *          "date": null,
     *          "hint": null
     *      },
     *      "icon":     null,
     *      "children": false
     * }]
     *
     * @param array $temp узел, сформированный в результате запроса
     *
     * @key int    id       идентификатор узла
     * @key string text     наименование
     * @key string a_attr   степень важности
     * @key string li_attr  дата (+ относительная), подсказки, подчеркивание
     * @key string icon     наличие заметок
     * @key bool   children наличие дочерних узлов
     *
     * @return array результат преобразования
     */
    protected function buildTree($temp)
    {
        $result    = [];
        $formatter = new FormatterComponent();

        foreach ($temp as $v) {
            // Абсолютная дата eg. '6 окт.' или относительная 'через 3 дня'
            $dueDate = $formatter->asRelativeDate($v[Task::tableName()]['dueDate']);
            // Словесная дата для подчеркивания в дереве eg. 'today', 'future'
            $relativeDate = $formatter->timeInWords($v[Task::tableName()]['dueDate']);
            // Относительная дата для тултипа, сколько ещё дней осталось eg. '3 дня осталось'
            $futureDate = $formatter->dateLeft($v[Task::tableName()]['dueDate']);

            // Форматирование текста курсивом или полужирным шрифтом
            $format  = is_null($v['format']) ? false : $v['format'];
            $hasNote = is_null($v['note']) ? null : 'fa fa-commenting';

            switch ($v[Task::tableName()]['priority']) {
                case 3:
                    $priority = Task::PR_HIGH; break;
                case 2:
                    $priority = Task::PR_MEDIUM; break;
                case 1:
                    $priority = Task::PR_LOW; break;
                default:
                    $priority = null;
            }

            $result[] = [
                'id'       => $v['dataId'],
                'text'     => $v['name'],
                'a_attr'   => ['class' => $priority, 'format' => $format],
                'li_attr'  => ['date' => $dueDate, 'rel' => $relativeDate, 'hint' => $futureDate],
                'icon'     => $hasNote,
                'children' => ($v['rgt'] - $v['lft'] > 1)
            ];
        }

        return $result;
    }
}
