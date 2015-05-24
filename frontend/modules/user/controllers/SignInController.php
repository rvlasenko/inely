<?php

namespace frontend\modules\user\controllers;

use common\models\User;
use frontend\modules\user\models\ConfirmEmailForm;
use frontend\modules\user\models\LoginForm;
use frontend\modules\user\models\PasswordResetRequestForm;
use frontend\modules\user\models\ResetPasswordForm;
use frontend\modules\user\models\SignupForm;
use Yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SignInController extends \yii\web\Controller
{

    public function actions()
    {
        return [
            'oauth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successOAuthCallback']
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
                        'actions' => ['signup', 'confirm-email', 'login', 'request-password-reset', 'reset-password', 'oauth'],
                        'allow' => true,

                    ],
                    [
                        'actions' => ['signup', 'login', 'request-password-reset', 'reset-password', 'oauth'],
                        'allow' => false,
                        'roles' => ['@'],
                        'denyCallback' => function () {
                            return Yii::$app->controller->redirect(['/user/default/profile']);
                        }
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post']
                ]
            ]
        ];
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if (Yii::$app->request->isGet && $model->load($_POST)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //sleep(1); // well... submit button is so cute
            return $this->goBack();
        } else {
            return $this->renderAjax('login', [
                'model' => $model
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    //$this->renderAjax('login');
                    Yii::$app->getSession()->setFlash(
                        'success',
                        'Вы успешно зарегистрировались! Чтобы стать полноправным участником, осталось подтвердить электронный адрес!'
                    );
                    return $this->goHome();
                }
            }
        }

        return $this->renderAjax('signup', [
            'model' => $model
        ]);
    }

    public function actionConfirmEmail($token)
    {
        try {
            $model = new ConfirmEmailForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->confirmEmail()) {
            Yii::$app->getSession()->setFlash('success', 'Спасибо! Ваш Email успешно подтверждён.');
        } else {
            Yii::$app->getSession()->setFlash('error', 'Ошибка подтверждения Email.');
        }

        return $this->goHome();
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => Yii::t('frontend', 'Check your email for further instructions.'),
                    'options' => ['class' => 'alert-success']
                ]);

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => Yii::t('frontend', 'Sorry, we are unable to reset password for email provided.'),
                    'options' => ['class' => 'alert-danger']
                ]);
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('alert', [
                'body' => Yii::t('frontend', 'New password was saved.'),
                'options' => ['class' => 'alert-success']
            ]);
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * @param $client \yii\authclient\BaseClient
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
            $user = new User();
            $user->scenario = 'oauth_create';

            switch ($client->getName()) {
                case 'vkontakte':
                    $obj = $client->getAccessToken();
                    $attributes['email'] = $obj->getParam('email');
                    $attributes['username'] = implode(' ', [
                        $attributes['first_name'],
                        $attributes['last_name']
                    ]);
                    break;
                case 'facebook':
                    $attributes['username'] = implode(' ', [
                        $attributes['first_name'],
                        $attributes['last_name']
                    ]);
                    break;
                case 'google':
                    $attributes['username'] = $attributes['displayName'];
                    $attributes['first_name'] = $attributes['name']['givenName'];
                    $attributes['last_name'] = $attributes['name']['familyName'];
                    $attributes['email'] = $attributes['emails'][0]['value'];
                    break;
            }

            //$avatar = ArrayHelper::getValue($attributes, 'photo');
            $user->username = $attributes['username'];
            $user->email = $attributes['email'];

            $user->oauth_client = $client->getName();
            $user->oauth_client_user_id = ArrayHelper::getValue($attributes, 'id');
            $password = Yii::$app->security->generateRandomString(8);
            $user->setPassword($password);
            if ($user->save()) {
                $user->afterSignup([
                    'firstname' => $attributes['first_name'],
                    'lastname' => $attributes['last_name']
                ]);
                //Yii::$app->getSession()->setFlash('alert', 'Email with your login information was sent to your email.');
            }
        }
        if (Yii::$app->user->login($user, 3600 * 24 * 30)) {
            return true;
        } else {
            throw new Exception('OAuth error');
        }
    }
}
