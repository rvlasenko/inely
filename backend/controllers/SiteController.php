<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
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
        return $this->render('index');
    }

    public function beforeAction($action)
    {
        $this->layout = Yii::$app->user->isGuest ? 'base' : 'common';
        parent::beforeAction($action);

        if (Yii::$app->getUser()->isGuest && Yii::$app->getRequest()->url !== Url::to(\Yii::$app->getUser()->loginUrl))
            Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl);
    }
}
