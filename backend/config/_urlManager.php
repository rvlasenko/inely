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
        'sign-up' => '/sign-in/signup',
        'reset' => '/sign-in/request-password-reset',
        'login' => '/sign-in/login',

        // Пользователь
        'account' => '/default/index',
        'profile' => '/default/profile',
        'logout' => '/sign-in/logout',
        '<_a:(confirm-email)>' => 'user/sign-in/<_a>',

        // Задачи
        'todo' => '/task/index',
        'edit' => '/task/edit',
        'todo/edit' => '/task/edit',
        'todo/cat' => '/task/cat',
        'todo/sort' => '/task/sort',
        'todo/delete' => '/task/delete'
    ]
];
