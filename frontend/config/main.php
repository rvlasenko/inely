<?php

$config = [
    'homeUrl' => Yii::getAlias('@frontendUrl'),
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'site/index',

    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],

        'request' => [
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
            'cookieValidationKey' => getenv('FRONTEND_COOKIE_VALIDATION_KEY')
        ]
    ]
];

return $config;
