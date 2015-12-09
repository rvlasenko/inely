<?php

$config = [
    'id'                  => 'frontend',
    'basePath'            => dirname(__DIR__),
    'homeUrl'             => Yii::getAlias('@frontendUrl'),
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute'        => 'land/index',
    'modules'             => [
        'user' => ['class' => 'frontend\modules\user\Module']
    ],
    'components'          => [
        'urlManager'           => require(__DIR__ . '/_urlManager.php'),
        'errorHandler'         => ['errorAction' => 'land/error'],
        'authClientCollection' => [
            'class'   => 'yii\authclient\Collection',
            'clients' => [
                'google'    => [
                    'class'        => 'yii\authclient\clients\GoogleOAuth',
                    'clientId'     => getenv('GOOGLE_CLIENT_ID'),
                    'clientSecret' => getenv('GOOGLE_CLIENT_SECRET')
                ],
                'facebook'  => [
                    'class'        => 'yii\authclient\clients\Facebook',
                    'clientId'     => getenv('FB_CLIENT_ID'),
                    'clientSecret' => getenv('FB_CLIENT_SECRET')
                ],
                'vkontakte' => [
                    'class'        => 'yii\authclient\clients\VKontakte',
                    'clientId'     => getenv('VK_CLIENT_ID'),
                    'clientSecret' => getenv('VK_CLIENT_SECRET'),
                    'scope'        => 'email'
                ]
            ]
        ],
        'request'              => [
            'enableCookieValidation' => true,
            'enableCsrfValidation'   => true,
            'cookieValidationKey'    => getenv('FRONTEND_COOKIE_VALIDATION_KEY')
        ],
        'user'                 => [
            'class'         => 'yii\web\User',
            'identityClass' => 'common\models\User',
            'loginUrl'      => ['login']
        ]
    ]
];

return $config;
