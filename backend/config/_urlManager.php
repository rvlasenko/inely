<?php
return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        // Базовые правила
        'contact' => '/site/contact',

        // Регистрация
        'sign-up' => '/user/sign-in/signup',
        'reset' => '/user/sign-in/request-password-reset',
        'login' => '/user/sign-in/login',
        'logout' => '/user/sign-in/logout',

        // Задачи
        'todo' => '/task/index',
        'edit' => '/task/edit',
        'todo/edit' => '/task/edit',
        'todo/cat' => '/task/cat',
        'todo/sort' => '/task/sort',
        'todo/delete' => '/task/delete'
    ]
];
