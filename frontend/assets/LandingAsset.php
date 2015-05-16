<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

class LandingAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/landing/animate.min.css',
        'css/landing/owl.carousel.min.css',
        'css/landing/nivo-lightbox.min.css',
        'css/landing/nivo-lightbox/default.min.css',
        'css/landing/land.css',
        '//fonts.googleapis.com/css?family=Open+Sans:300&subset=latin,cyrillic-ext',
    ];

    public $js = [
        'js/landing/retina.min.js',
        'js/landing/smoothscroll.min.js',
        'js/landing/wow.min.js',
        'js/landing/jquery.nav.min.js',
        'js/landing/jquery.stellar.min.js',
        'js/landing/nivo-lightbox.min.js',
        'js/landing/owl.carousel.min.js',
        'js/landing/script.js',
    ];

    public $jsOptions = ['position' => \yii\web\View::POS_END];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}
