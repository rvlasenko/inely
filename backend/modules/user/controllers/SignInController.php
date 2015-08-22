<?php

namespace backend\modules\user\controllers;

use common\models\User;
use backend\modules\user\models\ConfirmEmailForm;
use backend\modules\user\models\LoginForm;
use backend\modules\user\models\PasswordResetRequestForm;
use backend\modules\user\models\ResetPasswordForm;
use backend\modules\user\models\SignupForm;
use Yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\Controller;
use yii\widgets\ActiveForm;

class SignInController extends Controller
{

    public function actions()
    {
        return [
            'oauth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [ $this, 'successOAuthCallback' ]
            ]
        ];
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [ 'logout' => [ 'post' ] ]
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [ 'signup', 'confirm-email', 'login', 'request-password-reset', 'reset-password', 'oauth' ],
                        'allow' => true,
                        'roles' => [ '?' ]
                    ],
                    [
                        'actions' => [ 'signup', 'login', 'reset', 'reset-password', 'oauth' ],
                        'allow' => false,
                        'roles' => [ '@' ],
                        'denyCallback' => function() {
                            return Yii::$app->controller->redirect([ '/' ]);
                        }
                    ],
                    [
                        'actions' => [ 'logout' ],
                        'allow' => true,
                        'roles' => [ '@' ]
                    ]
                ]
            ]
        ];
    }

    public function actionLogin()
    {
        $this->layout = 'base';

        $model = new LoginForm();

        if (Yii::$app->request->isGet && $model->load($_POST)) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Yii::$app->urlManagerBackend->createUrl(''));
        }
        else {
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('login', [ 'model' => $model ]);
            } else {
                return $this->render('login', [ 'model' => $model ]);
            }
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $this->layout = 'base';

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->redirect(Yii::$app->urlManagerBackend->createUrl(''));
                }
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('signUp', [ 'model' => $model ]);
        } else {
            return $this->redirect(Yii::$app->getUser()->loginUrl);
        }
    }

    public function actionConfirmEmail($token)
    {
        try {
            $model = new ConfirmEmailForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->confirmEmail()) {
            Yii::$app->session->setFlash('alert', [
                'options' => [
                    'title' => 'Подтверждение',
                    'img' => 'images/flat/mail.png',
                    'link' => '',
                    'linkDesc' => ''
                ],
                'body' => 'Спасибо! Ваш Email успешно подтверждён.'
            ]);
        } else {
            Yii::$app->session->setFlash('alert', [
                'options' => [
                    'title' => 'Подтверждение',
                    'img' => 'images/flat/flame.png',
                    'link' => '',
                    'linkDesc' => ''
                ],
                'body' => 'Ошибка подтверждения Email.'
            ]);
        }

        return $this->goHome();
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('alert', [
                    'options' => [
                        'title' => 'Восстановление пароля',
                        'img' => 'images/flat/mail.png',
                        'link' => '',
                        'linkDesc' => ''
                    ],
                    'body' => Yii::t('frontend', 'Check your email for further instructions.'),
                ]);
            } else {
                Yii::$app->session->setFlash('alert', [
                    'options' => [
                        'title' => 'Восстановление пароля',
                        'img' => 'images/flat/mail.png',
                        'link' => '',
                        'linkDesc' => ''
                    ],
                    'body' => Yii::t('frontend', 'Sorry, we are unable to reset password for email provided.'),
                ]);
            }
        }

        /*if (Yii::$app->request->isAjax) {
            return $this->renderAjax('requestPasswordResetToken', [ 'model' => $model ]);
        } else {
            return $this->redirect(Yii::$app->getUser()->loginUrl);
        }*/
        return $this->renderAjax('requestPasswordResetToken', [ 'model' => $model ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('alert', [
                'options' => [
                    'title' => 'Восстановление пароля',
                    'img' => 'images/flat/key.png',
                    'link' => '',
                    'linkDesc' => ''
                ],
                'body' => Yii::t('frontend', 'New password was saved.'),
            ]);

            return $this->goHome();
        }

        return $this->render('resetPassword', [ 'model' => $model ]);
    }

    /**
     * @param $client \yii\authclient\BaseClient
     *
     * @return bool
     * @throws Exception
     */
    public function successOAuthCallback($client)
    {
        $attributes = $client->getUserAttributes();

        $user = User::find()->where([
            'oauth_client' => $client->getName(),
            'oauth_client_user_id' => ArrayHelper::getValue($attributes, 'id')
        ])->one();
        if (!$user) {
            $user           = new User();
            $user->scenario = 'oauth_create';

            switch ($client->getName()) {
                case 'vkontakte':
                    $obj                      = $client->getAccessToken();
                    $attributes[ 'email' ]    = $obj->getParam('email');
                    $attributes[ 'username' ] = $attributes[ 'first_name' ];
                    break;
                case 'facebook':
                    $attributes[ 'username' ] = $attributes[ 'first_name' ];
                    break;
                case 'google':
                    $attributes[ 'username' ]   = $attributes[ 'displayName' ];
                    $attributes[ 'first_name' ] = $attributes[ 'name' ][ 'givenName' ];
                    $attributes[ 'last_name' ]  = $attributes[ 'name' ][ 'familyName' ];
                    $attributes[ 'email' ]      = $attributes[ 'emails' ][ 0 ][ 'value' ];
                    break;
            }

            $user->username = $attributes[ 'username' ];
            $user->email    = $attributes[ 'email' ];

            $user->oauth_client         = $client->getName();
            $user->oauth_client_user_id = ArrayHelper::getValue($attributes, 'id');
            $password                   = Yii::$app->security->generateRandomString(8);
            $user->setPassword($password);
            if ($user->save()) {
                Yii::$app->mailer->compose('confirmEmail', [ 'user' => $user, 'password' => $password ])
                                 ->setTo($user->email)
                                 ->setSubject('Подтверждение аккаунта для ' . Yii::$app->name)
                                 ->send();

                $user->afterSignup([
                    'firstname' => $attributes[ 'first_name' ],
                    'lastname' => $attributes[ 'last_name' ]
                ]);
                Yii::$app->session->setFlash('alert', [
                    'options' => [
                        'title' => 'Регистрация',
                        'img' => 'images/flat/heart.png',
                        'link' => 'http://google.com',
                        'linkDesc' => 'Пройти тур'
                    ],
                    'body' => 'Вы успешно прошли регистрацию! Рекомендуем вам пройти знакомство с нашим планировщиком.'
                ]);
            }
        }
        if (Yii::$app->user->login($user, 3600 * 24 * 30)) {
            return $this->redirect('index');
        } else {
            throw new Exception('OAuth error');
        }
    }
}
