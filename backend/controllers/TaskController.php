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
use backend\models\TaskCat;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class TaskController extends TreeController
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
                        'actions'      => ['index', 'project', 'inbox'],
                        'allow'        => false,
                        'roles'        => ['?'],
                        'denyCallback' => function () {
                            return $this->redirect(['/login']);
                        }
                    ]
                ]
            ],
            /*'pageCache' => [
                'class'      => 'yii\filters\PageCache',
                'only'       => ['index', 'node'],
                'duration'   => 640,
                'variations' => [Yii::$app->language],
                'dependency' => [
                    'class' => 'yii\caching\DbDependency',
                    'sql'   => 'SELECT updatedAt FROM tasks ORDER BY updatedAt DESC'
                ]
            ],*/
            [
                'class'   => 'yii\filters\ContentNegotiator',
                'only'    => ['node', 'rename', 'create', 'move', 'delete'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ];
    }

    /**
     * Создание экземпляра ActiveRecord таблицы tasks_cat по заданному условию.
     * Идентификатор пользователя может отсутствовать, так как существуют и общедоступные категории.
     * Это действие не отвечает за формирование структуры дерева, как может показаться по логике.
     * @return string результат рендеринга.
     */
    public function actionIndex()
    {
        $query = TaskCat::find()->where(['userId' => null])->orWhere(['userId' => Yii::$app->user->id]);

        return $this->render('index', [
            'dataProvider' => new ActiveDataProvider(['query' => $query]),
            'countOfGroup' => Task::getCountOfGroups(),
            'countOfLists' => Task::getCountOfLists()
        ]);
    }

    /**
     * Формирование javascript объекта, содержащего в себе имя узла, его атрибуты, и так далее.
     * Метод принимает GET запрос и выполняет поиск дочерних узлов у элемента с принятым id.
     * Является источником данных для [[$.jstree.core.data]].
     * @return array данные сконвертированные в JSON формат.
     * @see behaviours [ContentNegotiator]
     */
    public function actionNode()
    {
        $node = $this->checkParam('id');
        $list = $this->checkParam('list') ?: null;
        $sort = $this->checkParam('sort') ?: 'pos';

        $temp = $this->getChildren($node, false, $list, $sort);
        $json = $this->buildTree($temp);

        return $json;
    }

    /**
     * Переименовывание узла по его первичному ключу.
     * Метод принимает GET запрос, обрабатывает его, и обращается к родительскому методу.
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
     * Создание нового узла с его идентификатором, полученной позицией и именем, если таковое имеется.
     * После фильтрации данных, идет обращение к родительскому методу.
     * @return array с идентификатором только что созданного узла, сконвертированный в JSON.
     * @throws \Exception если невозможно переименовать узел, после записи в базу.
     * @throws \yii\web\HttpException если невозможно записать внесённые изменения.
     */
    public function actionCreate()
    {
        $node   = $this->checkParam('id');
        $pos    = $this->checkParam('ps');
        $temp   = $this->make($node, $pos, [
            'name'     => $this->checkParam('text'),
            'list'     => $this->checkParam('ls'),
            'format'   => $this->checkParam('fr'),
            'priority' => $this->checkParam('pr'),
            'dueDate'  => $this->checkParam('dt')
        ]);
        $result = ['id' => $temp];

        return $result;
    }

    /**
     * Перемещение узла с помощью dnd в указанную позицию некоего родительского узла.
     * Данный метод по аналогии с остальными тоже принимает GET параметры.
     * @return bool если перемещение завершилось успехом.
     * @throws \Exception если пользователь чудом переместил родительский узел внутрь дочернего.
     */
    public function actionMove()
    {
        $node   = $this->checkParam('id');
        $parent = $this->checkParam('parent');
        $result = $this->move($node, $parent, $this->checkParam('position'));

        return $result;
    }

    /**
     * Удаление существующего узла дерева и всех его дочерних элементов.
     * @return bool значение, если удаление записи всё-таки произошло.
     * @throws \yii\web\NotFoundHttpException если пользователь захотел удалить несуществующий узел.
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
}
