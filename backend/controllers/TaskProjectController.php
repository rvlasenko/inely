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
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class TaskProjectController extends TreeController
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
     * Формирование javascript объекта, содержащего в себе имя узла, его атрибуты, и так далее.
     * Метод принимает GET запрос и выполняет поиск дочерних узлов у элемента с принятым id.
     * Является источником данных для [[$.jstree.core.data]].
     * @return array данные сконвертированные в JSON формат.
     * @see behaviours [ContentNegotiator]
     */
    public function actionNode()
    {
        $node = $this->checkParam('id');

        $temp = $this->getProjectChildren($node);
        $json = $this->buildProjectTree($temp);

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
            'name' => $this->checkParam('text')
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
            'name' => $this->checkParam('text')
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
}

