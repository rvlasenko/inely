<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace backend\modules\user\controllers;

use backend\modules\user\models\ConfirmEmailForm;
use backend\modules\user\models\LoginForm;
use backend\modules\user\models\PasswordResetRequestForm;
use backend\modules\user\models\ResetPasswordForm;
use backend\modules\user\models\SignupForm;
use backend\modules\user\models\WelcomeForm;
use common\commands\SendEmailCommand;
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
                'successCallback' => [$this, 'successOAuthCallback']
            ]
        ];
    }

    public function behaviors()
    {
        return [
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => ['logout' => ['post']]
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
                        'roles'   => ['?']
                    ],
                    [
                        'actions'      => ['signup', 'login', 'reset', 'reset-password', 'oauth'],
                        'allow'        => false,
                        'roles'        => ['@'],
                        'denyCallback' => function () {
                            return $this->redirect(['/']);
                        }
                    ],
                    [
                        'actions' => ['logout', 'confirm-email'],
                        'allow'   => true,
                        'roles'   => ['@']
                    ]
                ]
            ]
        ];
    }

    /**
     * Вход в систему, используя принятые данные.
     * Также выполняется проверка модели и возвращается массив сообщений об ошибке в JSON формате.
     * @return array|string|Response
     */
    public function actionLogin()
    {
        $this->layout = 'base';

        $model = new LoginForm();

        if (Yii::$app->request->isGet && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        } else {
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('login', ['model' => $model]);
            } else {
                return $this->render('login', ['model' => $model]);
            }
        }
    }

    /**
     * Регистрация пользователя.
     *
     * @return string|Response редирект на Dashboard либо вывод результата рендеринга.
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
            return $this->renderAjax('signUp', ['model' => $model]);
        } else {
            return $this->redirect(Yii::$app->getUser()->loginUrl);
        }
    }

    /**
     * Выход из системы и удаление аутентификационных данных.
     * @return Response редирект на Dashboard
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Подтверждение email и запись flash сообщения.
     *
     * @param string $token уникальный токен.
     *
     * @return Response редирект зависит от условия.
     * @throws BadRequestHttpException если произошла ошибка при создании формы 'ConfirmEmail'.
     */
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
            if ($model->confirmEmail()) {
                Yii::$app->session->setFlash('alert', [
                    'title' => Yii::t('backend', 'Email confirmation'),
                    'body'  => Yii::t('backend', 'Thanks! Account e-mail address confirmed successfully')
                ]);

                return $this->redirect('/welcome');
            }
        } else {
            Yii::$app->session->setFlash('alert', [
                'title' => Yii::t('backend', 'Email confirmation'),
                'body'  => Yii::t('backend', 'Sorry, an error occurred with confirmation')
            ]);
        }

        return $this->goHome();
    }

    /**
     * Передача сообщения о востановлении данных на email со ссылкой для сброса пароля.
     * @return string|Response редирект на страницу входа.
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('alert', [
                    'title' => Yii::t('backend', 'Password recover'),
                    'body'  => Yii::t('backend', 'Check your email for further instructions'),
                ]);
            } else {
                Yii::$app->session->setFlash('alert', [
                    'title' => Yii::t('backend', 'Password recover'),
                    'body'  => Yii::t('backend', 'Sorry, we are unable to reset password for email provided'),
                ]);
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('requestPasswordResetToken', ['model' => $model]);
        } else {
            return $this->redirect(Yii::$app->getUser()->loginUrl);
        }
    }

    /**
     * Сброс пароля и запись flash сообщения.
     *
     * @param $token уникальный токен.
     *
     * @return string|Response редирект на Dashboard.
     * @throws BadRequestHttpException если произошла ошибка при создании формы 'ResetPassword'.
     */
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

            return $this->redirect(Yii::$app->urlManagerBackend->createUrl(false));
        }

        return $this->render('resetPassword', ['model' => $model]);
    }

    /**
     * Запись набора пользовательской информации полученной от facebook.
     *
     * @param array  $attributes массив пользовательских данных.
     * @param object $user       объект пользователя.
     *
     * @return object измененный объект пользователя.
     */
    protected function setInfoFacebook($attributes, $user)
    {
        /**
         * Запись email и имени пользователя, если они указаны.
         * Email может отсутствовать, если пользователь зарегистрирован через телефон.
         */
        if (ArrayHelper::keyExists('email', $attributes)) {
            $user->email = ArrayHelper::getValue($attributes, 'email');
        }

        if (ArrayHelper::keyExists('username', $attributes)) {
            $user->username = ArrayHelper::getValue($attributes, 'username');
        }

        // Использование имени пользователя, как запасной вариант.
        if (!ArrayHelper::keyExists('first_name', $attributes)) {
            $user->username = ArrayHelper::getValue($attributes, 'name');
        } else {
            $user->username = str_replace(" ", "_", ArrayHelper::getValue($attributes, 'first_name'));
        }

        return $user;
    }

    /**
     * Запись набора пользовательской информации полученной от google.
     *
     * @param array  $attributes массив пользовательских данных.
     * @param object $user       объект пользователя.
     *
     * @return object измененный объект пользователя.
     */
    protected function setInfoGoogle($attributes, $user)
    {
        $user->email = $attributes['emails'][0]['value'];

        return $user;
    }

    /**
     * Запись набора пользовательской информации полученной от vk.com.
     *
     * @param array  $attributes массив пользовательских данных.
     * @param object $user       объект пользователя.
     *
     * @return object измененный объект пользователя.
     */
    protected function setInfoVk($attributes, $user)
    {
        foreach ($_SESSION as $k => $v) {
            if (is_object($v) && get_class($v) == 'yii\authclient\OAuthToken') {
                $user->email = $v->getParam('email');
            }
        }

        /**
         * Запись email и имени пользователя в адресной строке, если они указаны.
         * А также использование id пользователя, как запасной вариант.
         */
        if (ArrayHelper::keyExists('screen_name', $attributes)) {
            $user->username = ArrayHelper::getValue($attributes, 'screen_name');
        } else {
            $user->username = 'vk_' . ArrayHelper::getValue($attributes, 'id');
        }

        return $user;
    }

    /**
     * Callback метод успешной регистрации через OAuth.
     *
     * @param $client \yii\authclient\BaseClient
     *
     * @return Response редирект на Dashboard.
     * @throws Exception если при добавлении текущего пользователя произошла ошибка.
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
                    $this->setInfoVk($attributes, $user);
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
                    'lastname'  => ArrayHelper::getValue($attributes, 'last_name')
                ]);

                $sentSuccess = Yii::$app->commandBus->handle(new SendEmailCommand([
                    'view'    => 'oauthWelcome',
                    'params'  => ['user' => $user, 'password' => $password],
                    'subject' => Yii::t('mail', 'Inely | Your login information'),
                    'to'      => $user->email
                ]));
                if ($sentSuccess) {
                    Yii::$app->session->setFlash('alert', [
                        'title' => Yii::t('backend', 'Welcome to Inely.'),
                        'body'  => Yii::t('backend', 'Your login information was sent to <b>{email}</b>', [ 'email' => $user->email ]),
                    ]);
                }
            }
        }
        if (Yii::$app->user->login($user, 3600 * 24 * 30)) {
            return $this->goHome();
        } else {
            throw new Exception('OAuth error');
        }
    }
}
