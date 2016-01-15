<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';

    public $css = [
        'https://fonts.googleapis.com/css?family=PT+Sans|Open+Sans&subset=cyrillic',
        'fonts/simple-line-icons/simple-line-icons.css',
        'css/animate.min.css',
        'css/style.css',
        'css/style-responsive.css'
    ];

    public $js = [
        'js/plugins.min.js',
        'js/app.js'
    ];

    public $jsOptions = ['position' => View::POS_END];

    public $depends = [
        'yii\web\JqueryAsset',
        'common\assets\BootstrapAsset'
    ];
}
