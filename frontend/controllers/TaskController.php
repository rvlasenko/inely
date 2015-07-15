<?php

namespace frontend\controllers;

use frontend\models\Task;
use frontend\models\TaskCat;
use frontend\models\search\TaskSearch;
use Yii;
use yii\db\Query;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Json;
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
                    'delete' => ['post'],
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
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Check editable bootstrap ajax request
        if (Yii::$app->request->post('hasEditable')) {
            $taskId = Yii::$app->request->post('editableKey');
            $model = Task::findOne($taskId);

            $post = [];
            $posted = current($_POST['Task']);
            $post['Task'] = $posted;

            if ($model->load($post))
                $model->save();

            return true;
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @return string
     */
    public function actionSort()
    {
        $searchModel = new TaskSearch();

        if (Yii::$app->request->get())
            $dataProvider = $searchModel->search(
                Yii::$app->request->queryParams,
                $_GET['TaskSearch'] ? $_GET['TaskSearch']['category'] : false
            );

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
            'query' => TaskCat::find()
                ->where(['userId' => Yii::$app->user->id]),
            'sort' => false
        ]);

        return $this->renderAjax('cat/index', [
            'dataProvider' => $dataProvider,
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
            $this->redirect(Url::toRoute(['/todo']));
        } else {
            return $this->renderAjax('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
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
