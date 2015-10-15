<?php

$config = [
    'homeUrl'             => Yii::getAlias('@backendUrl'),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute'        => 'site/index',
    'modules'             => [
        'user' => ['class' => 'backend\modules\user\Module'],
        'i18n' => [
            'class'        => 'backend\modules\i18n\Module',
            'defaultRoute' => 'i18n-message/index'
        ]
    ],
    'components'          => [
        'formatter' => [
            'class'       => 'yii\i18n\Formatter',
            'nullDisplay' => ''
        ],
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
        'errorHandler'         => ['errorAction' => 'site/error'],
        'request'              => ['cookieValidationKey' => getenv('BACKEND_COOKIE_VALIDATION_KEY')],
        'user'                 => [
            'class'           => 'yii\web\User',
            'identityClass'   => 'common\models\User',
            'loginUrl'        => ['login'],
            'enableAutoLogin' => true,
            'as afterLogin'   => 'common\components\behaviors\LoginTimestampBehavior'
        ]
    ]
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = ['class' => 'yii\gii\Module'];
}

return $config;
