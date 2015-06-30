<?php

namespace frontend\modules\user\controllers;

use Yii;
use frontend\modules\user\models\Tasks;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TodoController
 */
class TodoController extends DefaultController
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
        ];
    }

    /**
     * Создание модели
     * Получение записей из таблицы с помощью метода модели
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Tasks();
        $tasks = $model->getTasks();

        return $this->render('@app/views/templates/todo', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * @param integer $cat
     * @param bool $isDone
     * @return bool
     * Создание основной модели
     */
    public function actionInsert($name, $time, $cat, $isDone, $priority)
    {
        $tasks = new Tasks();

        if ($tasks->load(Yii::$app->request->post()) &&
            $tasks->setTasks($name, $time, $cat, $isDone, $priority)) {
            return true;
        } else {
            return $this->renderAjax('@app/views/templates/todo', [
                'tasks' => $tasks,
            ]);
        }
    }

    public function actionDone($val)
    {
        $tasks = new Tasks();

        if ($val && $tasks->load(Yii::$app->request->post())) {
            $tasks->done($val)

            return true;
        }
    }

    /**
     * Обновление существующей Tasks модели
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return true;
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tasks model.
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
     * Finds the Tasks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tasks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tasks::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
