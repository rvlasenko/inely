<?php

/**
 * @author Copyright (c) 2015 rootkit
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // Stylesheets
        'css/style.css',
        'css/dark.css',
        'css/font-icons.css',
        'css/animate.css',
        'css/responsive.css'
    ];

    public $js = [
        // External JavaScript
        'js/infinitescroll.min.js'
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD
    ];

    public $depends = [
        'common\assets\BootstrapAsset',
        'frontend\assets\RevSliderAsset'
    ];
}
