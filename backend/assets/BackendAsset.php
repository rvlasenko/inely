<?php

namespace backend\assets;

use yii\web\AssetBundle;

class BackendAsset extends AssetBundle
{
    public $basePath = '/';
    public $baseUrl = '@backendUrl';

    public $css = [
        'css/style.css'
    ];
    public $js = [
        'js/app.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'common\assets\AdminLte',
        'common\assets\Html5shiv'
    ];
}
