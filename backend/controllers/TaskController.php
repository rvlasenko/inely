<?php

namespace backend\controllers;

use backend\models\Task;
use backend\models\TaskCat;
use backend\models\search\TaskSearch;
use Yii;
use yii\db\Query;
use yii\web\Response;
use yii\helpers\Url;
use yii\web\Controller;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => [ 'post' ],
                ],
            ],
            /*[
                'class' => 'yii\filters\HttpCache',
                'only' => [
                    'index', 'view'
                ],
                'lastModified' => function() {
                    $q = new Query();
                    return $q->from('tasks')->max('time');
                },
            ],*/
        ];
    }

    /**
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Check editable bootstrap ajax request
        if (Yii::$app->request->post('hasEditable')) {
            $post   = [ ];
            $taskId = Yii::$app->request->post('editableKey');
            $model  = Task::findOne($taskId);

            $post[ 'Task' ] = current($_POST[ 'Task' ]);

            if ($model->load($post)) {
                $model->save();
            }

            return true;
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * @return bool
     */
    public function actionEdit()
    {
        if ($taskId = Yii::$app->request->post('id')) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $model = Task::findOne($taskId);

            $dateTime = empty($_POST[ 'time' ]) ? false : $_POST[ 'time' ];
            $rating   = empty($_POST[ 'rate' ]) ? false : $_POST[ 'rate' ];

            !$dateTime ? null : $model->time = $dateTime;
            !$rating ? null : $model->priority = $rating;

            if ($model->save()) {
                return [
                    'title' => 'Великолепно!',
                    'desc' => 'Ваши данные успешно обновлены.',
                    'icon' => '/images/flat/compose.png'
                ];
            }
        }
    }

    /**
     * @return string
     */
    public function actionSort()
    {
        $searchModel = new TaskSearch();

        if (Yii::$app->request->get()) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $_GET[ 'TaskSearch' ] ? $_GET[ 'TaskSearch' ][ 'category' ] : false);
        }

        if (Yii::$app->request->post('hasEditable')) {
            $post   = [ ];
            $taskId = Yii::$app->request->post('editableKey');
            $model  = Task::findOne($taskId);

            $post[ 'Task' ] = current($_POST[ 'Task' ]);

            if ($model->load($post)) {
                $model->save();
            }

            return true;
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single TaskCat model.
     * @return mixed
     */
    public function actionCat()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TaskCat::find()->where([ 'userId' => Yii::$app->user->id ]),
            'sort' => false
        ]);

        return $this->renderAjax('cat/index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();

        if (Yii::$app->request->isGet && $model->load($_POST)) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->setTask()) {
            Yii::$app->session->setFlash('alert', [
                'options' => [
                    'title' => 'Вы великолепны!',
                    'img' => 'images/flat/compose.png',
                    'link' => '',
                    'linkDesc' => ''
                ],
                'body' => 'Задача была успешно добавлена в категорию <strong>&laquo;' . $model->tasks_cat->name . '&raquo;'
            ]);
            $this->redirect(Url::toRoute([ '/todo' ]));
        }
        else {
            return $this->renderAjax('create', [
                'model' => $model
            ]);
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
            return $this->redirect([ 'view', 'id' => $model->id ]);
        }
        else {
            return $this->render('update', [
                'model' => $model,
            ]);
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
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
