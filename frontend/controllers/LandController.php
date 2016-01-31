<?php

namespace frontend\controllers;

use frontend\models\ContactForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class LandController extends Controller
{
    public function actions()
    {
        return [
            'set' => [
                'class'    => 'common\actions\SetLocaleAction',
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'allow'        => false,
                        'roles'        => ['@'],
                        'denyCallback' => function () {
                            return $this->redirect(Yii::$app->urlManagerBackend->createUrl(false));
                        }
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post(), '')) {
            if ($model->contact(getenv('ROBOT_EMAIL'))) {
                return true;
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

        return false;
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if ($action->id == 'error') {
                $this->layout = '_error';
            }

            return true;
        }

        return false;
    }
}
