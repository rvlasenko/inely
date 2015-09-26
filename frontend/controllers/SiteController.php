<?php

namespace frontend\controllers;

use frontend\models\ContactForm;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'set' => [
                'class'    => 'common\components\action\SetLocaleAction',
                'locales'  => array_keys(Yii::$app->params['availableLocales']),
                'callback' => function () {
                    Yii::$app->response->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
                }
            ]
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\HttpCache',
                'only'  => ['index']
            ],
            'pageCache' => [
                'class'      => 'yii\filters\PageCache',
                'only'       => ['index'],
                'duration'   => 6800,
                'variations' => [Yii::$app->language]
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->contact(getenv('ROBOT_EMAIL'))) {
                return $this->renderAjax('contact', ['model' => $model]);
            }
        }

        return $this->renderAjax('contact', ['model' => $model]);
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;

        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if ($action->id == 'error') {
                $this->layout = '_error';
            }

            return true;
        }

        return null;
    }
}
