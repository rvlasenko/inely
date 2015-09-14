<?php

namespace backend\controllers;

use backend\models\Task;
use backend\models\TaskCat;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TaskController implements the CRUD actions for Task model.
 */
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
                        'roles' => [ '@' ]
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
//            [
//                'class' => 'yii\filters\HttpCache',
//                'only' => [ 'index', 'project', 'inbox' ],
//                'lastModified' => function () {
//                    $q = new Query();
//                    return $q->from('tasks')->max('updated_at');
//                },
//            ],
//            'pageCache' => [
//                'class' => 'yii\filters\PageCache',
//                'only' => [ 'index', 'project', 'inbox' ],
//                'duration' => 180,
//                'variations' => [ Yii::$app->language ],
//                'dependency' => [
//                    'class' => 'yii\caching\DbDependency',
//                    'sql' => 'SELECT MAX(updated_at) FROM tasks'
//                ]
//            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete'  => [ 'post' ],
                    'create'  => [ 'post' ],
                    'update'  => [ 'post' ],
                    'project' => [ 'post' ],
                    'inbox'   => [ 'get'  ]
                ]
            ]
        ];
    }

    /**
     * Get a task instance, with public attributes
     * @return mixed
     */
    public function actionIndex()
    {
        //                if (Yii::$app->request->post('hasEditable')) {
        //            $post   = [ ];
        //            $taskId = Yii::$app->request->post('editableKey');
        //            $model  = Task::findOne($taskId);
        //
        //            $post[ 'Task' ] = current($_POST[ 'Task' ]);
        //
        //            if ($model->load($post)) $model->save();
        //
        //            return true;
        //        }

        $query = TaskCat::find()->where([ 'userId' => null ])->orWhere([ 'userId' => Yii::$app->user->id ]);

        return $this->render('index', [
            'dataProvider'        => new ActiveDataProvider([ 'query' => $query ]),
            'dataProviderProject' => Task::getInbox(),
            'countOf'             => Task::getCount()
        ]);
    }

    public function actionSide()
    {

    }

    /**
     * Returns a list of active tasks, receive foreign key "list"
     * @return ActiveDataProvider
     */
    public function actionProject()
    {
        return $this->renderAjax('project', [
            'dataProviderProject' => Task::getProject(Yii::$app->request->post('list'))
        ]);
    }

    /**
     * Displays inbox tasks. Receive PJAX request and return a tasks
     * User don't have access to this action, he will be go home
     * @return ActiveDataProvider
     */
    public function actionInbox()
    {
        return $this->renderAjax('project', [ 'dataProviderProject' => Task::getInbox() ]);
    }

    /**
     * Creates a new task. If user request this page with HEAD header, he won't see it
     * @return bool|string
     * @throws HttpException
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->renderAjax('create');
        } else {
            throw new HttpException(500, 'Unable to save user data');
        }
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return true;
        } else {
            return $this->goHome();
        }
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->actionIndex();
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
