<?php

return [
    'id' => 'console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@common/migrations',
            'migrationTable' => '{{%system_migration}}'
        ],
        'message' => [ 'class' => 'console\controllers\ExtendedMessageController' ],
        'rbac' => [ 'class' => 'console\controllers\RbacController' ]
    ]
];
