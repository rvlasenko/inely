<?php
return [
    'class'           => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName'  => false,
    'rules'           => [
        // Регистрация
        'signup'        => '/user/sign-up/signup',
        'confirm-email' => '/user/sign-up/confirm-email',
        // Восстановление пароля
        'forgotpass'    => '/user/reset-pass/request-password-reset',
        'resetpass'     => '/user/reset-pass/reset-password',
        // Авторизация
        'login'         => '/user/sign-in/login',
        // Общее
        'oauth'         => '/user/auth/oauth',
        'logout'        => '/user/auth/logout'
    ]
];
