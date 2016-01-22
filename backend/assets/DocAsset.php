<?php

namespace backend\assets;

use Yii;
use yii\web\AssetBundle;

class DocAsset extends AssetBundle
{
    public $basePath = '/';
    public $baseUrl  = '@backendUrl';

    public $css = [
        'https://fonts.googleapis.com/css?family=Open+Sans:400,300,700&subset=latin,cyrillic',
        'css/doc.css'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
}