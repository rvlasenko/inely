<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author hirootkit
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
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
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
                'only'  => ['index']
            ],
            'pageCache' => [
                'class'      => 'yii\filters\PageCache',
                'only'       => ['index'],
                'duration'   => 6800,
                'variations' => [Yii::$app->language]
            ]
        ];
    }

    /**
     * Проверка статуса пользователя и определение его дальнейшей судьбы.
     * Если пользователь является гостем, он окажется на странице входа.
     * @return homeUrl перенаправление на домашнюю (приветственную) страницу.
     *
     * Возвращается null, если невозможно определить статус...
     */
    public function actionIndex()
    {
        if (Yii::$app->getUser()->isGuest) {
            Yii::$app->getResponse()->redirect(Yii::$app->getUser()->loginUrl);
        } else {
            if (Yii::$app->user->identity->status == User::STATUS_UNCONFIRMED) {
                $this->redirect('/welcome');
            } else {
                // Определение пользовательского персонажа. Довольно удобно.
                Yii::$app->params['userChar'] = (new UserProfile)->getChar();

                return $this->render('index');
            }
        }

        return null;
    }
}
