<?php

$config = [
    'homeUrl'             => Yii::getAlias('@frontendUrl'),
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute'        => 'site/index',
    'modules'             => ['user' => ['class' => 'backend\modules\user\Module']],
    'components'          => [
        'errorHandler' => ['errorAction' => 'site/error'],
        'request'      => [
            'enableCookieValidation' => true,
            'enableCsrfValidation'   => true,
            'cookieValidationKey'    => getenv('FRONTEND_COOKIE_VALIDATION_KEY')
        ],
        'user'         => [
            'class'         => 'yii\web\User',
            'identityClass' => 'common\models\User'
        ]
    ]
];

return $config;
