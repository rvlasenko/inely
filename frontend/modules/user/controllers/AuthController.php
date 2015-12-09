<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link   http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace frontend\modules\user\controllers;

use common\commands\SendEmailCommand;
use common\models\User;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

class AuthController extends Controller
{
    public $layout = 'main';

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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true, 'roles' => ['?']
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
                        'actions' => ['confirm-email'],
                        'allow' => true, 'roles' => ['@']
                    ]
                ]
            ]
        ];
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
                ], [
                    'ownerId'   => $user->id,
                    'name'     => 'Root',
                    'isDone'   => null
                ]);

                $sentSuccess = Yii::$app->commandBus->handle(new SendEmailCommand([
                    'view'    => 'oauthWelcome',
                    'params'  => ['user' => $user, 'password' => $password],
                    'subject' => Yii::t('mail', 'Inely | Your login information'),
                    'to'      => $user->email
                ]));
                if ($sentSuccess) {
                    Yii::$app->session->setFlash('alert', [
                        'body' => Yii::t('backend', 'Ваши персональные данные были отправлены на <b>{email}</b>', ['email' => $user->email]),
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
