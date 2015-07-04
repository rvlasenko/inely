<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class LandingAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        // Carousel
        'css/landing/flexslider.css',

        // Animations
        'css/landing/animate.min.css',

        // Custom stylesheets
        'css/landing/styles.css',

        // Colors
        'css/landing/colors/blue.css',

        // Responsive fixes
        'css/landing/responsive.css',

        // Web font
        'css/icons/simple-line-icons/css/simple-line-icons.css',
        '//fonts.googleapis.com/css?family=Roboto:300,100,500&subset=latin,cyrillic-ext',
    ];

    public $js = [
        'js/landing/smoothscroll.js',
        'js/landing/jquery.plugins.js',
        'js/landing/owl.carousel.min.js',
        'js/landing/simple-expand.min.js',
        'js/landing/wow.min.js',
        'js/landing/retina.min.js',
        'js/landing/custom.js',
        'plugins/noty/jquery.noty.packaged.js',
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_END
    ];

    public $depends = [
        'frontend\assets\BowerAsset',
        'frontend\assets\FontAwesomeAsset'
    ];
}
