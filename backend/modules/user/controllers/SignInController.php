<?php

/**
 * This file is part of the Inely project.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author rootkit
 */

namespace backend\modules\user\controllers;

use backend\modules\user\models\ConfirmEmailForm;
use backend\modules\user\models\LoginForm;
use backend\modules\user\models\PasswordResetRequestForm;
use backend\modules\user\models\ResetPasswordForm;
use backend\modules\user\models\SignupForm;
use backend\modules\user\models\WelcomeForm;
use common\models\User;
use Yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SignInController extends Controller
{

    public function actions()
    {
        return [
            'oauth' => [
                'class'           => 'yii\authclient\AuthAction',
                'successCallback' => [ $this, 'successOAuthCallback' ]
            ]
        ];
    }

    /**
     * Logout accept only post method
     *
     * Guests have access to signup, login, etc
     *
     * But are not authorized users not have access to this methods
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [ 'logout' => [ 'post' ] ]
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'signup',
                            'confirm-email',
                            'login',
                            'request-password-reset',
                            'reset-password',
                            'oauth'
                        ],
                        'allow'   => true,
                        'roles'   => [ '?' ]
                    ],
                    [
                        'actions'      => [ 'signup', 'login', 'reset', 'reset-password', 'oauth' ],
                        'allow'        => false,
                        'roles'        => [ '@' ],
                        'denyCallback' => function () {
                            return $this->redirect([ '/' ]);
                        }
                    ],
                    [
                        'actions' => [ 'logout', 'confirm-email' ],
                        'allow'   => true,
                        'roles'   => [ '@' ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Layout from /user/views/layouts
     *
     * @return array|string|Response
     */
    public function actionLogin()
    {
        $this->layout = 'base';

        $model = new LoginForm();

        if (Yii::$app->request->isGet && $model->load($_POST)) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        } else {
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

    /**
     * If not ajax request, then redirect to login page
     *
     * @return string|Response
     */

    public function actionSignup()
    {
        $this->layout = 'base';

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->redirect(Yii::$app->urlManagerBackend->createUrl(false));
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
        $status = Yii::$app->user->identity->status;

        try {
            $model = new ConfirmEmailForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($status != User::STATUS_UNCONFIRMED && $model->confirmEmail()) {
            Yii::$app->session->setFlash('alert', [
                'title' => Yii::t('backend', 'Email confirmation'),
                'body'  => Yii::t('backend', 'Thanks! Account e-mail address confirmed successfully')
            ]);
        } elseif ($status == User::STATUS_UNCONFIRMED) {
            $model->confirmEmail();
            return $this->redirect('/welcome');
        } else {
            Yii::$app->session->setFlash('alert', [
                'title' => Yii::t('backend', 'Email confirmation'),
                'body'  => Yii::t('backend', 'Sorry, an error occurred with confirmation')
            ]);
        }

        return $this->goHome();
    }

    /**
     * If not ajax request, then redirect to login page
     *
     * @return string|Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('alert', [
                    'title' => 'Восстановление пароля',
                    'body'  => Yii::t('backend', 'Check your email for further instructions'),
                ]);
            } else {
                Yii::$app->session->setFlash('alert', [
                    'title' => 'Восстановление пароля',
                    'body'  => Yii::t('backend', 'Sorry, we are unable to reset password for email provided'),
                ]);
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('requestPasswordResetToken', [ 'model' => $model ]);
        } else {
            return $this->redirect(Yii::$app->getUser()->loginUrl);
        }
    }

    public function actionResetPassword($token)
    {
        $this->layout = 'base';

        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('alert', [
                'title' => Yii::t('backend', 'Password recover'),
                'body'  => Yii::t('backend', 'New password was saved'),
            ]);

            return $this->redirect(Yii::$app->urlManagerBackend->createUrl(''));
        }

        return $this->render('resetPassword', [ 'model' => $model ]);
    }

    /**
     * Set info for facebook registration
     *
     * @param array  $attributes
     * @param object $user
     *
     * @return array [$user, $profile]
     */
    protected function setInfoFacebook($attributes, $user)
    {
        /**
         * Set email/username if they are set
         * Email may be missing if user signed up using a phone number
         */
        if (isset($attributes[ 'email' ])) {
            $user->email = $attributes[ 'email' ];
        }

        if (isset($attributes[ 'username' ])) {
            $user->username = $attributes[ 'username' ];
        }

        // use facebook name as username as fallback
        if (!isset($attributes[ 'first_name' ])) {
            $user->username = $attributes[ 'name' ];
        } else {
            $user->username = str_replace(" ", "_", $attributes[ 'first_name' ]);
        }

        return $user;
    }

    /**
     * Set info for google registration
     *
     * @param $attributes
     * @param $user
     *
     * @return mixed
     */
    protected function setInfoGoogle($attributes, $user)
    {
        $user->email = $attributes[ 'emails' ][ 0 ][ 'value' ];

        return $user;
    }

    /**
     * Set info for vk registration
     *
     * @param $attributes
     * @param $user
     *
     * @return mixed
     */
    protected function setInfoVkontakte($attributes, $user)
    {
        foreach ($_SESSION as $k => $v) {
            if (is_object($v) && get_class($v) == 'yii\authclient\OAuthToken') {
                $user->email = $v->getParam('email');
            }
        }

        /**
         * Set email/username if they are set
         * Use vk_id name as username as fallback
         */

        if (isset($attributes[ 'screen_name' ])) {
            $user->username = $attributes[ 'screen_name' ];
        } else {
            $user->username = 'vk_' . $attributes[ 'id' ];
        }

        return $user;
    }

    /**
     * @param $client \yii\authclient\BaseClient
     *
     * First we need combine some attributes and get the email
     * And now just send them to DB, send the letter, and redirect to home
     *
     * @return bool
     * @throws Exception
     */
    public function successOAuthCallback($client)
    {
        $attributes = $client->getUserAttributes();

        $user = User::find()->where([
            'oauth_client'         => $client->getName(),
            'oauth_client_user_id' => ArrayHelper::getValue($attributes, 'id')
        ])->one();
        if (!$user) {
            $user           = new User();
            $user->scenario = 'oauth_create';

            switch ($client->getName()) {
                case 'vkontakte':
                    $this->setInfoVkontakte($attributes, $user);
                    break;
                case 'facebook':
                    $this->setInfoFacebook($attributes, $user);
                    break;
                case 'google':
                    $this->setInfoGoogle($attributes, $user);
                    break;
            }

            $user->oauth_client         = $client->getName();
            $user->oauth_client_user_id = ArrayHelper::getValue($attributes, 'id');
            $password                   = Yii::$app->security->generateRandomString(8);
            $user->setPassword($password);

            if ($user->save()) {
                $user->afterSignup([
                    'firstname' => ArrayHelper::getValue($attributes, 'first_name'),
                    'lastname'  => ArrayHelper::getValue($attributes, 'last_name'),
                    'id'        => $user->id
                ]);
            }
        }
        if (Yii::$app->user->login($user, 3600 * 24 * 30)) {
            return $this->goHome();
        } else {
            throw new Exception('OAuth error');
        }
    }
}
