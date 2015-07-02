<?php
$config = [
    //'layout' => 'main.php',
    'homeUrl' => Yii::getAlias('@frontendUrl'),
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'site/index',
    'modules' => [
        'user' => [
            'class' => 'frontend\modules\user\Module'
        ],
        'api' => [
            'class' => 'frontend\modules\api\Module',
            'modules' => [
                'v1' => 'frontend\modules\api\v1\Module'
            ]
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ]
    ],
    'components' => [
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        'jquery.min.js'
                    ]
                ],
                'frontend\assets\BowerAsset' => [
                    'css' => [
                        'css/bootstrap.min.css',
                    ],
                    'js' => [
                        'js/bootstrap.min.js',
                    ]
                ],
            ],
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => getenv('RC_SITEKEY'),
            'secret' => getenv('RC_SECRET'),
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\GoogleOAuth',
                    'clientId' => getenv('GOOGLE_CLIENT_ID'),
                    'clientSecret' => getenv('GOOGLE_CLIENT_SECRET'),
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => getenv('FB_CLIENT_ID'),
                    'clientSecret' => getenv('FB_CLIENT_SECRET'),
                ],
                'vkontakte' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => getenv('VK_CLIENT_ID'),
                    'clientSecret' => getenv('VK_CLIENT_SECRET'),
                    'scope' => 'email',
                ],
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'request' => [
            'cookieValidationKey' => getenv('FRONTEND_COOKIE_VALIDATION_KEY')
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\User',
            'loginUrl' => ['/user/sign-in/login'],
            'enableAutoLogin' => true,
            'as afterLogin' => 'common\components\behaviors\LoginTimestampBehavior'
        ]
    ]
];

if (YII_ENV_PROD) {
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'messageCategory' => 'frontend'
            ]
        ]
    ];
}

return $config;
