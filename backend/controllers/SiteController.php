<?php

/**
 * This file is part of the Inely project.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author rootkit
 */

namespace backend\controllers;

use common\models\User;
use common\models\UserProfile;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [ 'class' => 'yii\web\ErrorAction' ],
            'set'   => [
                'class'    => 'common\components\action\SetLocaleAction',
                'locales'  => array_keys(Yii::$app->params[ 'availableLocales' ]),
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
                'only'  => [ 'index' ]
            ],
            'pageCache' => [
                'class'      => 'yii\filters\PageCache',
                'only'       => [ 'index' ],
                'duration'   => 6800,
                'variations' => [ Yii::$app->language ]
            ]
        ];
    }

    /**
     * If a user is detected as a guest, he will be redirected to the login page
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionIndex()
    {
        if (Yii::$app->getUser()->isGuest) {
            Yii::$app->getResponse()->redirect(Yii::$app->getUser()->loginUrl);
        } else {
            if (Yii::$app->user->identity->status == User::STATUS_UNCONFIRMED) {
                $this->redirect('/welcome');
            } else {
                // Define user character and set like a global var
                Yii::$app->params[ 'userChar' ] = (new UserProfile)->getChar();

                return $this->render('index');
            }
        }
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserProfile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
