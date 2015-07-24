<?php
return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        // Базовые правила
        '' => '/site/index',
        'contact' => '/site/contact',

        // Регистрация
        'sign-up' => '/user/sign-in/signup',
        'reset' => '/user/sign-in/request-password-reset',
        'login' => '/user/sign-in/login',

        // Пользователь
        'logout' => '/user/sign-in/logout',
        '<_a:(confirm-email)>' => 'user/sign-in/<_a>'
    ]
];
