<?php

namespace backend\controllers;

use backend\models\Task;
use backend\models\TaskCat;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends TreeController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true, 'roles' => [ '@' ]
                    ],
                    [
                        'actions'      => [ 'index', 'project', 'inbox' ],
                        'allow'        => false,
                        'roles'        => [ '?' ],
                        'denyCallback' => function () {
                            return $this->redirect([ '/login' ]);
                        }
                    ]
                ]
            ],
            /*'pageCache' => [
                'class'      => 'yii\filters\PageCache',
                'only'       => [ 'index', 'project', 'inbox' ],
                'duration'   => 640,
                'variations' => [ Yii::$app->language ],
                'dependency' => [
                    'class' => 'yii\caching\DbDependency',
                    'sql'   => 'SELECT MAX(updated_at) FROM tasks'
                ]
            ],*/
            /*[
                'class'        => 'yii\filters\HttpCache',
                'only'         => [ 'index', 'project', 'inbox' ],
                'lastModified' => function () {
                    $q = new Query();

                    return $q->from('tasks')->max('updated_at');
                },
            ],*/
            [
                'class'   => 'yii\filters\ContentNegotiator',
                'only'    => [ 'node', 'rename', 'create', 'move', 'delete' ],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ];
    }

    /**
     * Executes query and returns the count of tasks.
     * This method doesn't create a tree structure.
     * @return view with the variable containing count of categories.
     */
    public function actionIndex()
    {
        $query = TaskCat::find()->where([ 'userId' => null ])->orWhere([ 'userId' => Yii::$app->user->id ]);

        return $this->render('index', [
            'dataProvider' => new ActiveDataProvider([ 'query' => $query ]),
            'countOf'      => Task::getCount()
        ]);
    }

    /**
     * Executes query by POST value "list" and returns a list of active tasks.
     * @return ActiveDataProvider
     */
    public function actionProject()
    {
        return $this->renderAjax('project', [
            'dataProviderProject' => Task::getProject(Yii::$app->request->post('list'))
        ]);
    }

    /**
     * Displays tasks in the category of "inbox".
     * @return ActiveDataProvider
     */
    public function actionInbox()
    {
        return $this->renderAjax('project', [ 'dataProviderProject' => Task::getInbox() ]);
    }

    /**
     * Receives a GET request(s) and find children by the given condition.
     * @return node containing the name of the node, PK, and children, if any.
     */
    public function actionNode()
    {
        $result = [ ];

        $node = $this->purifyGetRequest('id');
        $temp = $this->getChildren($node);
        foreach ($temp as $v) {
            $result[ ] = [
                'id'       => $v[ 'dataId' ],
                'text'     => $v[ 'name' ],
                //'priority' => TasksData::getPriority($node),
                'children' => ($v[ 'rgt' ] - $v[ 'lft' ] > 1)
            ];
        }

        return $result;
    }

    /**
     * Action receives a GET request which contains node ID, and his text.
     * By default, the "text" attribute is "Renamed node".
     * @return bool json
     * @throws \Exception
     */
    public function actionRename()
    {
        $node   = $this->purifyGetRequest('id');
        $result = $this->rename($node, [ 'name' => $this->purifyGetRequest('text') ]);

        return $result;
    }

    /**
     * Action receives a GET request which contains text node.
     * @return json
     */
    public function actionCreate()
    {
        $node   = $this->purifyGetRequest('id');
        $pos    = $this->purifyGetRequest('position');
        $temp   = $this->make($node, $pos, [ 'name' => $this->purifyGetRequest('text') ]);
        $result = [ 'id' => $temp ];

        return $result;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function actionMove()
    {
        $node   = $this->purifyGetRequest('id');
        $parent = $this->purifyGetRequest('parent');
        $result = $this->move($node, $parent, $this->purifyGetRequest('position'));

        return $result;
    }

    /**
     * Deletes an existing Task node.
     * If deletion is successful, the browser will be returned a value.
     * @return json|bool
     */
    public function actionDelete()
    {
        $node   = $this->purifyGetRequest('id');
        $result = $this->remove($node);

        return $result;
    }

    /**
     * Deletes the table row corresponding to this active record.
     *
     * @return bool
     * @throws \Exception
     */
    public function actionDeleteOne()
    {
        $node = $this->purifyGetRequest('id');
        Task::findOne([ $node ])->delete();

        return true;
    }
}
