<?php

return [
    'class'           => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName'  => false,
    'rules'           => [
        'task'    => '/task/index',
        'profile' => '/user/profile',
        'logout'  => '/user/logout'
    ]
];
