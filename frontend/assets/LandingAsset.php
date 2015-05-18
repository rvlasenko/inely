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
        // FONT ICONS
        'icons/elegant-icons/style.css',
        'icons/app-icons/styles.css',

        // CAROUSEL AND LIGHTBOX
        'css/landing/owl.theme.css',
        'css/landing/owl.carousel.css',
        'css/landing/nivo-lightbox.css',
        'css/landing/nivo_themes/default/default.css',

        // ANIMATIONS
        'css/landing/animate.min.css',

        // CUSTOM STYLESHEETS
        'css/landing/styles.css',

        // COLORS
        'css/landing/colors/blue.css',

        // RESPONSIVE FIXES
        'css/landing/responsive.css',

        // WEB FONT
        '//fonts.googleapis.com/css?family=Roboto:300,100&subset=latin,cyrillic-ext',
    ];

    public $js = [
        'js/landing/smoothscroll.js',
        'js/landing/jquery.scrollTo.min.js',
        'js/landing/jquery.localScroll.min.js',
        'js/landing/owl.carousel.min.js',
        'js/landing/nivo-lightbox.min.js',
        'js/landing/simple-expand.min.js',
        'js/landing/wow.min.js',
        'js/landing/jquery.stellar.min.js',
        'js/landing/retina.min.js',
        'js/landing/matchMedia.js',
        'js/landing/jquery.backgroundvideo.min.js',
        'js/landing/jquery.nav.js',
        'js/landing/jquery.ajaxchimp.min.js',
        'js/landing/jquery.fitvids.js',
        'js/landing/custom.js',
    ];

    public $jsOptions = ['position' => \yii\web\View::POS_END];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}
