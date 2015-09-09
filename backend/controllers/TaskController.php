<?php

namespace backend\controllers;

use backend\models\Task;
use backend\models\TaskCat;
use DateTime;
use IntlDateFormatter;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
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
                        'actions' => [ 'index', 'list' ],
                        'allow' => false,
                        'roles' => [ '?' ],
                        'denyCallback' => function () {
                            return $this->redirect([ '/login' ]);
                        }
                    ]
                ]
            ],
//            [
//                'class' => 'yii\filters\HttpCache',
//                'only' => [ 'index', 'list' ],
//                'lastModified' => function () {
//                    $q = new Query();
//                    return $q->from('tasks')->max('updated_at');
//                },
//            ],
//            'pageCache' => [
//                'class' => 'yii\filters\PageCache',
//                'only' => [ 'index', 'list' ],
//                'duration' => 180,
//                'variations' => [ Yii::$app->language ],
//                'dependency' => [
//                    'class' => 'yii\caching\DbDependency',
//                    'sql' => 'SELECT MAX(updated_at) FROM tasks'
//                ]
//            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [ 'delete' => [ 'post' ] ]
            ]
        ];
    }

    /**
     * Get a task instance, with public attributes
     * @return mixed
     */
    public function actionIndex()
    {
        $model = TaskCat::find()
            ->where([ 'userId' => null ])
            ->orWhere([ 'userId' => Yii::$app->user->id ])
            ->asArray()->all();

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

        return $this->render('index', [ 'model' => $model ]);
    }

    public function actionSide()
    {
        $condition = Yii::$app->request->isPost
            // If user added the task, then data comes from POST, and we return AJAX html
            ? [ 'author' => Yii::$app->user->id ]
            // If user clicked on a category, then FK comes from GET
            : [ 'author' => Yii::$app->user->id, 'list' =>  Yii::$app->request->get('list') ];

        $tasks = Task::find()->where($condition)->joinWith('tasks_cat')->asArray()->all();

        $items = <<<SIDE
        <div class="list-group list-group-links">
            <div class="list-group-header">Home<span class="pull-right">(3 tasks)</span></div>
            <a href="#" class="list-group-item pt15 prn">Due today<span class="badge badge-info fs11">0</span></a>
            <a href="#" class="list-group-item prn">Due tommorrow<span class="badge badge-info fs11">0</span></a>

            <a href="#" class="list-group-item pt15 prn">Completed<span class="badge badge-success fs11">0</span></a>
        </div>
SIDE;
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionList()
    {
        $items = '';
        $condition = Yii::$app->request->isGet
            // If user added the task, then data comes from POST, and we return AJAX html
            ? [ 'author' => Yii::$app->user->id ]
            // If user clicked on a category, then FK comes from GET
            : [ 'author' => Yii::$app->user->id, 'list' =>  Yii::$app->request->post('list') ];

        $tasks = Task::find()->where($condition)->joinWith('tasks_cat')->asArray()->all();

        // If request is not ajax or get, user won't see this page
        if (count($tasks) && Yii::$app->request->isAjax || Yii::$app->request->isPost) {
            // Converting timestamp to language date format
            $formatter = new IntlDateFormatter(Yii::$app->language, IntlDateFormatter::FULL, IntlDateFormatter::FULL, 'UTC');
            $formatter->setPattern('dd MMMM');
            $format = new DateTime();

            foreach ($tasks as $task):
                $checkboxId = rand(1, 100);

                // Some useful variables
                $isDone   = $task[ 'isDone' ] ? 'done' : 'undone';
                $taskName = Html::tag('span', $task[ 'name' ]);
                $taskTag  = isset($task[ 'tagName' ])
                    ? Html::tag('span', '#' . $task[ 'tasks_cat' ][ 'tagName' ], [ 'class' => 'badge badge-info mr10 fs11' ])
                    : false;

                $dateTime = $task[ 'isDone' ]
                    ? false
                    : Yii::t('backend', 'until ') . $formatter->format($format->setTimestamp((int)$task[ 'due' ]));

                $items .= <<<TASK
                <tr class="message $isDone pr {$task['priority']}">
                    <td class="text-center w90">
                        <label class="option block mn">
                            <input type="checkbox" class="checkbox" id="checkbox$checkboxId" data-task-id="{$task['id']}" />
                            <label for="checkbox$checkboxId"></label>
                        </label>
                    </td>
                    <td class="fw600">
                        $taskTag $taskName
                    </td>
                    <td class="text-right">$dateTime</td>
                </tr>
TASK;
            endforeach;
        } else {
            if (Yii::$app->request->isGet) return $this->goHome();

            $youHaveNoTasks = Yii::t('backend', 'You have no incomplete tasks in this list. Woohoo!');

            $items = "<tr class='message'><td>$youHaveNoTasks</td></tr>";
        }

        return $items;
    }

    /**
     * Creates a new task.
     * @return bool|string
     * @throws HttpException
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->renderAjax('create');
        } else {
            // If request is not pjax, user won't see this page
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('create');
            } else {
                $this->goHome();
            }

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
