<?php

namespace backend\assets;

use Yii;
use yii\web\AssetBundle;

class DocAsset extends AssetBundle
{
    public $basePath = '/';
    public $baseUrl  = '@backendUrl';

    public $css = [
        'http://themes.vsart.me/vsdocs/css/style.min.css'
    ];

    public $js = [
        'http://themes.vsart.me/vsdocs/js/all.js'
    ];

    public $depends = [
        'common\assets\FontAwesome'
    ];
}
