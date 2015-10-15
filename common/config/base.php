<?php

$config = [
    'name'           => 'inely',
    'vendorPath'     => dirname(dirname(__DIR__)) . '/vendor',
    'extensions'     => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'sourceLanguage' => 'en-US',
    'language'       => 'ru-RU',
    'bootstrap'      => ['log'],
    'timeZone'       => 'Europe/Moscow',
    'components'     => [
        'authManager' => [
            'class'           => 'yii\rbac\DbManager',
            'cache'           => 'cache',
            'itemTable'       => '{{%rbac_auth_item}}',
            'itemChildTable'  => '{{%rbac_auth_item_child}}',
            'assignmentTable' => '{{%rbac_auth_assignment}}',
            'ruleTable'       => '{{%rbac_auth_rule}}'
        ],
        'commandBus'  => [
            'class'                => '\trntv\tactician\Tactician',
            'commandNameExtractor' => '\League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor',
            'methodNameInflector'  => '\League\Tactician\Handler\MethodNameInflector\HandleInflector',
            'commandToHandlerMap'  => [
                'common\commands\SendEmailCommand' => '\common\commands\SendEmailHandler'
            ]
        ],
        'cache'     => ['class' => 'yii\caching\DummyCache'],
        'mailer'    => [
            'class'         => 'yii\swiftmailer\Mailer',
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from'    => getenv('ADMIN_EMAIL')
            ],
            'transport'     => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.gmail.com',
                'port'       => '587',
                'username'   => getenv('ROBOT_EMAIL'),
                'password'   => getenv('PASSWORD'),
                'encryption' => 'tls'
            ]
        ],
        'db'                 => [
            'class'               => 'yii\db\Connection',
            'dsn'                 => getenv('DB_DSN'),
            'username'            => getenv('DB_USERNAME'),
            'password'            => getenv('DB_PASSWORD'),
            'tablePrefix'         => getenv('DB_TABLE_PREFIX'),
            'charset'             => 'utf8',
            'enableSchemaCache'   => true,
            // Duration of schema cache
            'schemaCacheDuration' => 8600,
            // Name of the cache component used to store schema information
            'schemaCache'         => 'cache'
        ],
        'i18n'               => [
            'translations' => [
                'app' => [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                '*'   => [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'fileMap'  => [
                        'backend'  => 'backend.php',
                        'frontend' => 'frontend.php',
                        'mail'     => 'mail.php'
                    ]
                ]
            ]
        ],
        'urlManagerBackend'  => \yii\helpers\ArrayHelper::merge(['hostInfo' => Yii::getAlias('@backendUrl')],
            require(Yii::getAlias('@backend/config/_urlManager.php'))),
        'urlManagerFrontend' => \yii\helpers\ArrayHelper::merge(['hostInfo' => Yii::getAlias('@frontendUrl')],
            require(Yii::getAlias('@frontend/config/_urlManager.php')))
    ],
    'params'         => [
        'adminEmail'       => getenv('ADMIN_EMAIL'),
        'robotEmail'       => getenv('ROBOT_EMAIL'),
        'availableLocales' => [
            'en-US' => 'English',
            'ru-RU' => 'Русский'
        ]
    ]
];

if (YII_ENV_PROD) {
    $config['components']['cache'] = [
        'class'     => 'yii\caching\FileCache',
        'cachePath' => '@common/runtime/cache',
        'fileMode'  => 777
    ];
}

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';

    $config['modules']['gii'] = ['class' => 'yii\gii\Module'];
}

return $config;