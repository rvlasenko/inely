<?php

return [
    'class'           => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName'  => false,
    'rules'           => [
        'task'    => '/task/index',
        'profile' => '/user/index',
        'logout'  => '/user/logout'
    ]
];
