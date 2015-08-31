<?php

return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        'contact' => '/site/contact',
        'welcome' => '/char/index',

        'signup' => '/user/sign-in/signup',
        'reset' => '/user/sign-in/request-password-reset',
        'reset-password' => '/user/sign-in/reset-password',
        'confirm-email' => '/user/sign-in/confirm-email',
        'login' => '/user/sign-in/login',
        'logout' => '/user/sign-in/logout',

        'todo' => '/task/index',
    ]
];
