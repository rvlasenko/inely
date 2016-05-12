<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';

    public $css = [
        'https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic,800,800italic,300italic,300',
        'css/bootstrap.min.css',
        'css/font-awesome.min.css',
        'css/magnific-popup.css',
        'css/owl.carousel.css',
        'css/main.css'
    ];

    public $js = [
        'js/jquery-2.2.1.min.js',
        'js/bootstrap.min.js',
        'js/jquery.magnific-popup.min.js',
        'js/owl.carousel.min.js',
        'js/jquery.waypoints.min.js',
        'js/jquery.animateNumber.min.js',
        'js/jquery.ajaxchimp.min.js',
        'js/tweetie.min.js',
        'js/main.js',
        'http://platform.twitter.com/widgets.js',
        'https://maps.googleapis.com/maps/api/js?v=3.exp',
        'js/gmap.js',
        'js/retina.min.js',
    ];

    public $jsOptions = ['position' => View::POS_END];

    public $depends = [];
}
