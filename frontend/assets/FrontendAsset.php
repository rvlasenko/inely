<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link   http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';

    public $css = [
        'http://fonts.googleapis.com/css?family=Droid+Serif:400,400italic|Montserrat:700,400|Varela+Round',
        'fonts/icomoon/icomoon.css',
        'css/animate.min.css',
        'css/style.css',
        'css/style-responsive.css'
    ];

    public $js = [
        'js/plugins.min.js',
        'js/app.js'
    ];

    public $jsOptions = ['position' => View::POS_END];

    public $depends = ['common\assets\BootstrapAsset'];
}
