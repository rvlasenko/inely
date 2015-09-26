<?php

return [
    'class'           => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName'  => false,
    'rules'           => [

        /*
         * Основные правила
         */
        'contact'        => '/site/contact',
        'todo'           => '/task/index',
        'schedule'       => '/calendar/index',
        'welcome'        => '/char/index',

        /*
         * Правила авторизации
         */
        'signup'         => '/user/sign-in/signup',
        'reset'          => '/user/sign-in/request-password-reset',
        'reset-password' => '/user/sign-in/reset-password',
        'confirm-email'  => '/user/sign-in/confirm-email',
        'login'          => '/user/sign-in/login',
        'logout'         => '/user/sign-in/logout'
    ]
];
