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

        // Задачи
        'todo' => '/task/index',
        'edit' => '/task/edit',
        'todo/edit' => '/task/edit',
        'todo/cat' => '/task/cat',
        'todo/sort' => '/task/sort',
        'todo/delete' => '/task/delete'
    ]
];
