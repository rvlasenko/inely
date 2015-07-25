<?php

namespace backend\controllers;

use Yii;
use backend\models\LoginForm;
use backend\models\AccountForm;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SignInController extends Controller
{

    public $defaultAction = 'login';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get']
                ]
            ]
        ];
    }

    public function actionLogin()
    {
        $this->layout = 'base';
        if (!Yii::$app->user->isGuest)
            return $this->goHome();

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login())
            return $this->goBack();
        else
            return $this->render('login', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(Yii::$app->urlManagerFrontend->createUrl(''));
    }

    public function actionProfile()
    {
        $model = Yii::$app->user->identity->userProfile;
        if ($model->load($_POST) && $model->save()) {
            Yii::$app->session->setFlash('alert', [
                'options' => [ 'class' => 'alert-success' ],
                'body' => Yii::t('backend', 'Your account has been successfully saved', [], $model->locale)
            ]);
            return $this->refresh();
        }
        return $this->render('profile', ['model' => $model]);
    }

    public function actionAccount()
    {
        $user = Yii::$app->user->identity;
        $model = new AccountForm();
        $model->username = $user->username;
        if ($model->load($_POST) && $model->validate()) {
            $user->username = $model->username;
            $user->setPassword($model->password);
            $user->save();
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => Yii::t('backend', 'Your profile has been successfully saved')
            ]);
            return $this->refresh();
        }
        return $this->render('account', ['model' => $model]);
    }
}
