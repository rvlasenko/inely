<?php

$config = [
    'components' => [
        'urlManagerBackend' => [
            'class' => 'yii\web\urlManager',
            'showScriptName' => false,
            'baseUrl' => '//backend.madeasy.local',
        ],
        'urlManagerFrontend' => [
            'class' => 'yii\web\urlManager',
            'showScriptName' => false,
            'baseUrl' => '//madeasy.local',
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'linkAssets' => true,
            'appendTimestamp' => true,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css'
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js'
                    ]
                ]
            ]
        ],
        'session' => [
            'cookieParams' => [ 'domain' => '.madeasy.local' ]
        ]
    ],
    'as locale' => [
        'class' => 'common\components\behaviors\LocaleBehavior'
    ]
];

if (YII_DEBUG) {
    $config[ 'bootstrap' ][ ]       = 'debug';
    $config[ 'modules' ][ 'debug' ] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => [ '127.0.0.1', '::1', '192.168.56.*', ],
    ];
}

if (YII_ENV_DEV) {
    $config[ 'modules' ][ 'gii' ] = [
        'allowedIPs' => [ '127.0.0.1', '::1', '192.168.56.*', ],
    ];
}

return $config;
