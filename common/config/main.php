<?php

$config = [
    'as locale'  => [
        'class'                   => 'common\behaviors\LocaleBehavior',
        'enablePreferredLanguage' => true
    ],
    'components' => [
        'assetManager'       => [
            'class'           => 'yii\web\AssetManager',
            'linkAssets'      => true,
            'appendTimestamp' => true,
            'bundles'         => [
                'yii\web\JqueryAsset'          => [
                    'js' => [YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js']
                ],
                'common\assets\BootstrapAsset' => [
                    'css' => [YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css']
                ],
                'common\assets\JuiAsset'       => [
                    'js' => [YII_ENV_DEV ? 'jquery-ui.js' : 'jquery-ui.min.js']
                ]
            ]
        ],
        'session'            => ['cookieParams' => ['domain' => '.madeasy.local']],
        'urlManagerBackend'  => [
            'class'          => 'yii\web\urlManager',
            'showScriptName' => false,
            'baseUrl'        => '//backend.madeasy.local'
        ],
        'urlManagerFrontend' => [
            'class'          => 'yii\web\urlManager',
            'showScriptName' => false,
            'baseUrl'        => '//madeasy.local'
        ]
    ]
];

if (YII_DEBUG) {
    $config['bootstrap'][]      = 'debug';
    $config['modules']['debug'] = [
        'class'      => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.56.*',],
    ];
}

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.56.*',],
    ];
}

return $config;
