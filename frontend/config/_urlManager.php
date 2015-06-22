<?php
return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        // ОБазовые правила
        '' => '/site/index',
        'todo' => '/user/todo/index',

        // Регистрация
        'sign-up' => '/user/sign-in/signup',
        'reset' => '/user/sign-in/request-password-reset',
        'login' => '/user/sign-in/login',

        // Пользователь
        'account' => '/user/default/index',
        'profile' => '/user/default/profile',
        'logout' => '/user/sign-in/logout',
        '<_a:(confirm-email)>' => 'user/sign-in/<_a>',

        // Api
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/article', 'only' => ['index', 'view', 'options']],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/user', 'only' => ['index', 'view', 'options']]
    ]
];
