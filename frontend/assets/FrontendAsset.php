<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

        // Carousel
        'css/flexslider.css',

        // Animations
        'plugins/animation-css/animate.min.css',

        // Custom stylesheets
        'css/styles.css',

        // Colors
        'css/colors/blue.css',

        // Responsive fixes
        'css/responsive.css',

        // Web font
        '//fonts.googleapis.com/css?family=Roboto:300,100,500&subset=latin,cyrillic-ext',
    ];

    public $js = [
        'js/smoothscroll.js',
        'js/jquery.plugins.js',
        'js/owl.carousel.min.js',
        'js/simple-expand.min.js',
        'js/wow.min.js',
        'js/retina.min.js',
        'js/custom.js',
        'plugins/noty/jquery.noty.packaged.js',
    ];

    public $jsOptions = [
        'position' => View::POS_END
    ];

    public $depends = [
        'common\assets\BowerAsset',
        'common\assets\FontAwesome'
    ];
}
