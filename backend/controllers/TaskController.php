<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author hirootkit
 */

namespace backend\controllers;

use backend\models\Task;
use backend\models\TaskCat;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Response;

class TaskController extends TreeController
{
    public function behaviors()
    {
        return [
            'access'    => [
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
                'only'       => ['index', 'project', 'inbox'],
                'duration'   => 640,
                'variations' => [Yii::$app->language],
                'dependency' => [
                    'class' => 'yii\caching\DbDependency',
                    'sql'   => 'SELECT MAX(updated_at) FROM tasks'
                ]
            ],
            [
                'class'        => 'yii\filters\HttpCache',
                'only'         => ['index', 'project', 'inbox'],
                'lastModified' => function () {
                    $q = new Query();

                    return $q->from('tasks')->max('updated_at');
                },
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
            'countOf'      => Task::getCount()
        ]);
    }

    /**
     * Формирование javascript объекта, которое содержит в себе свойства имени узла, его атрибутов, и так далее.
     * Метод также принимает GET запрос и выполняет поиск дочерних узлов у элемента с принятым id.
     * Метод является источником данных для [[$.jstree.core.data]].
     * @return array данные сконвертированные в JSON формат (см. behaviours -> ContentNegotiator)
     */
    public function actionNode()
    {
        $result = [];

        $node = parent::purifyGetRequest('id');
        $temp = $this->getChildren($node);
        foreach ($temp as $v) {
            $result[] = [
                'id'       => $v['dataId'],
                'text'     => $v['name'],
                'a_attr'   => ['class' => $v['tasks']['priority']],
                'children' => ($v['rgt'] - $v['lft'] > 1)
            ];
        }

        return $result;
    }

    /**
     * Переименовывание узла по его первичному ключу.
     * Метод принимает GET запрос, обрабатывает его, и обращается к родительскому методу.
     * @return bool результат сконвертированный в JSON.
     * @throws \Exception если переименовывание завершилось неудачей, либо не был получен id.
     */
    public function actionRename()
    {
        $node   = parent::purifyGetRequest('id');
        $result = $this->rename($node, ['name' => parent::purifyGetRequest('text')]);

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
        $node   = parent::purifyGetRequest('id');
        $pos    = parent::purifyGetRequest('position');
        $temp   = $this->make($node, $pos, ['name' => parent::purifyGetRequest('text')]);
        $result = ['id' => $temp];

        return $result;
    }

    /**
     * Перемещение узла с помощью dnd в указанную позицию некоего родительского узла.
     * Данный метод по аналогии с остальными тоже принимает GET параметры.
     * @return bool true если перемещение завершилось успехом.
     * @throws \Exception если пользователь чудом переместил родительский узел внутрь дочернего.
     */
    public function actionMove()
    {
        $node   = parent::purifyGetRequest('id');
        $parent = parent::purifyGetRequest('parent');
        $result = $this->move($node, $parent, parent::purifyGetRequest('position'));

        return $result;
    }

    /**
     * Удаление существующего узла дерева и всех его дочерних элементов.
     * @return bool значение, если удаление в таблицах всё-таки произошло.
     * @throws \yii\web\NotFoundHttpException если пользователь захотел удалить несуществующий узел.
     */
    public function actionDelete()
    {
        $node   = parent::purifyGetRequest('id');
        $result = $this->remove($node);

        return $result;
    }

    /**
     * Удаление существующего узла деревав единственном экземпляре.
     * Метод используется исключительно для отмены события создания узла, происходящее по нажатию ESC.
     * @return bool если удаление произошло.
     * @throws \Exception если удаление не так, как задумывалось.
     */
    public function actionDeleteOne()
    {
        $node = parent::purifyGetRequest('id');
        Task::findOne([$node])->delete();

        return true;
    }
}
