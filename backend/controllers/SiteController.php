<?php

namespace backend\controllers;

use backend\models\LoginForm;
use Yii;

/**
 * Site controller
 */
class SiteController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            /*[
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 60
            ],*/
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ]
        ];
    }

    public function actionIndex()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('../sign-in/login', [
                'model' => $model
            ]);
        }
    }

    public function beforeAction($action)
    {
        $this->layout = Yii::$app->user->isGuest ? 'base' : 'common';
        return parent::beforeAction($action);
    }
}
