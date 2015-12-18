<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace backend\assets;

use Yii;
use yii\web\AssetBundle;
use yii\web\View;

class TaskAsset extends AssetBundle
{
    public $basePath = '/';
    public $baseUrl  = '@backendUrl';

    public $css = [
        'http://fonts.googleapis.com/css?family=Open+Sans:400,600&subset=latin,cyrillic',

        'css/style.css',
        'fonts/entypo-icon/entypo-icon.css',

        'vendor/skin-select/skin-select.css',
        'vendor/tip/tooltipster.css',
        'vendor/slidebars/slidebars.css',
        'vendor/magnific/magnific-popup.css',
        'vendor/summernote/summernote.css',
        'vendor/select2/css/select2.css'
    ];

    public $js = [
        'scripts/plugins.js',
        'scripts/app.js',

        'vendor/summernote/summernote.min.js',
        'vendor/magnific/jquery.magnific-popup.min.js',
        'vendor/noty/packaged/jquery.noty.packaged.min.js',
        'vendor/select2/js/select2.min.js'
    ];

    public $jsOptions = ['position' => View::POS_END];

    public $depends = [
        'yii\web\YiiAsset',
        'common\assets\BootstrapAsset',
        'common\assets\FontAwesome'
    ];
}