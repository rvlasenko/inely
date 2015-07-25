<?php
$config = [
    'homeUrl' => Yii::getAlias('@frontendUrl'),
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'site/index',
    /*'modules' => [
        'user' => [
            'class' => 'frontend\modules\user\Module'
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ]
    ],*/

    'components' => [

        'errorHandler' => [
            'errorAction' => 'site/error'
        ],

        'request' => [
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
            'cookieValidationKey' => getenv('FRONTEND_COOKIE_VALIDATION_KEY')
        ],

        /*'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\User',
            'loginUrl' => '\user\sign-in\login',
            'enableAutoLogin' => true,
            'as afterLogin' => 'common\components\behaviors\LoginTimestampBehavior'
        ]*/
    ]
];

if (YII_ENV_DEV) {
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
