<?php

return [
    'class'           => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName'  => false,
    'rules'           => [
        // Основные правила
        'task'    => '/task/index',
        'welcome' => '/task/welcome',
        // Авторизация
        'logout' => '/user/logout'
    ]
];
