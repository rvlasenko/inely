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

        // Carousel and lightbox
        'css/landing/owl.theme.css',
        'css/landing/flexslider.css',
        'css/landing/owl.carousel.css',
        'css/landing/nivo-lightbox.css',
        'css/landing/nivo_themes/default/default.css',

        // Animations
        'css/landing/animate.min.css',

        // Custom stylesheets
        'css/landing/styles.css',

        // Colors
        'css/landing/colors/blue.css',

        // Responsive fixes
        'css/landing/responsive.css',

        // Web font
        '//fonts.googleapis.com/css?family=Roboto:300,100&subset=latin,cyrillic-ext',
    ];

    public $js = [
        'js/landing/smoothscroll.js',
        'js/landing/jquery.plugins.js',
        'js/landing/owl.carousel.min.js',
        'js/landing/nivo-lightbox.min.js',
        'js/landing/simple-expand.min.js',
        'js/landing/wow.min.js',
        'js/landing/retina.min.js',
        'js/landing/custom.js',
        'js/landing/bootstrap.min.js',
    ];

    public $jsOptions = ['position' => \yii\web\View::POS_END];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}
