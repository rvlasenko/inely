<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

class SiteController extends Controller
{

    /**
     * Enable page caching with duration 84600 seconds
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

    /**
     * Redirect all users to the login page if not logged in
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->getUser()->isGuest) {
            Yii::$app->getResponse()->redirect(Yii::$app->getUser()->loginUrl);
        } else {
            return $this->render('index');
        }
    }
}
