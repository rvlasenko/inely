<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

/**
 * Deny request from guests
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
            [
                'class' => 'yii\filters\PageCache',
                'only' => [ 'index' ],
                'duration' => 84600
            ],
            'error' => [ 'class' => 'yii\web\ErrorAction' ],
            'set' => [
                'class' => 'common\components\action\SetLocaleAction',
                'locales' => array_keys(Yii::$app->params[ 'availableLocales' ]),
                'callback' => function() {
                    Yii::$app->response->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
                }
            ]
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->getUser()->isGuest && Yii::$app->getRequest()->url !== Url::to(Yii::$app->getUser()->loginUrl)) {
            Yii::$app->getResponse()->redirect(Yii::$app->getUser()->loginUrl);
        } else {
            return $this->render('index');
        }
    }
}
