<?php

return [
    'class'           => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName'  => false,
    'rules'           => [

        /*
         * General rules
         */
        'contact'        => '/site/contact',
        'todo'           => '/task/index',
        'schedule'       => '/calendar/index',
        'welcome'        => '/char/index',
        /*
         * Auth rules
         */
        'signup'         => '/user/sign-in/signup',
        'reset'          => '/user/sign-in/request-password-reset',
        'reset-password' => '/user/sign-in/reset-password',
        'confirm-email'  => '/user/sign-in/confirm-email',
        'login'          => '/user/sign-in/login',
        'logout'         => '/user/sign-in/logout'
    ]
];
