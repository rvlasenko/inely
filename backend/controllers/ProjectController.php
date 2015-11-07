<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace backend\controllers;

use backend\models\Project;
use Yii;
use yii\base\Controller;
use yii\filters\AccessControl;
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
                        'allow' => true, 'roles' => ['@']
                    ],
                    [
                        'allow' => false, 'roles' => ['?']
                    ]
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
        $userId = Yii::$app->user->id;

        if ($nodeId === '#') {
            $node = Project::find()->roots($userId)->all();
        } else {
            $root = Project::findOne($nodeId);
            $node = $root->children($userId, null)->all();
        }

        return $this->buildTree($node);
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
     * Создание нового проекта, исходя из полученного родительского идентификатора, и обновление индексов.
     * @return array идентификатор только что созданной ветки, сконвертированный в JSON.
     */
    public function actionCreate()
    {
        $newChild   = new Project();
        $parentNode = Project::findOne(Yii::$app->request->post('id'));

        $newChild->load(Yii::$app->request->post(), '');
        if ($newChild->prependTo($parentNode)) {
            return $newChild->getPrimaryKey();
        } else {
            return null;
        }
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
     * Удаление существующей ветки дерева и её дочерних элементов.
     * Также опциональный параметр - удаление уже завершенных задач.
     * @return bool значение, если удаление записи всё-таки произошло.
     * @throws NotFoundHttpException если пользователь захотел удалить несуществующий узел.
     */
    public function actionDelete()
    {
        $node = Project::findOne(Yii::$app->request->post('id'));
        if ($node->deleteWithChildren()) {
            return true;
        }

        return null;
    }

    /**
     * Преоразование полученного массива веток в JSON строку подобного вида:
     * [{
     *      "id":   "240",
     *      "text": "Child",
     *      "children": true
     * }]
     *
     * @param array $temp узел, сформированный в результате запроса
     *
     * @return array результат преобразования
     * @key int    id       идентификатор узла
     * @key string text     наименование
     * @key bool   children наличие дочерних узлов
     */
    protected function buildTree($temp)
    {
        $result = [];

        foreach ($temp as $v) {
            $result[] = [
                'id'       => $v['id'],
                'text'     => $v['listName'],
                'a_attr'   => ['badge' => $v['badgeColor']],
                'children' => ($v['rgt'] - $v['lft'] > 1)
            ];
        }

        return $result;
    }
}

