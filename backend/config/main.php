<?php

$config = [
    'id'                  => 'backend',
    'basePath'            => dirname(__DIR__),
    'homeUrl'             => Yii::getAlias('@backendUrl'),
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute'        => 'task/index',
    'bootstrap'           => ['backend\config\bsInterface'],
    'components'          => [
        'formatter'    => ['class' => 'yii\i18n\Formatter'],
        'urlManager'   => require(__DIR__ . '/_urlManager.php'),
        'errorHandler' => ['errorAction' => 'task/error'],
        'request'      => ['cookieValidationKey' => getenv('BACKEND_COOKIE_VALIDATION_KEY')],
        'user'         => [
            'identityClass' => 'common\models\User',
            'loginUrl'      => '//madeasy.local/login'
        ]
    ]
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = ['class' => 'yii\gii\Module'];
}

return $config;
