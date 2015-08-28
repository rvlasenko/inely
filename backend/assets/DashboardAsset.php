<?php

/**
 * @author Copyright (c) 2015 rootkit
 */

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class DashboardAsset extends AssetBundle
{
    public $basePath = '/';
    public $baseUrl  = '@backendUrl';

    public $css = [

        // Font CSS (Via CDN)
        'http://fonts.googleapis.com/css?family=Open+Sans:400,600,700&subset=latin,cyrillic',
        'fonts/glyphicons-pro/glyphicons-pro.css',

        // Full Calendar Plugin CSS
        'vendor/plugins/fullcalendar/fullcalendar.min.css',

        // Summernote
        'vendor/plugins/summernote/summernote.css',

        // Theme CSS
        'css/skin/theme.css',
        'css/animate.css',

        // Admin Panels CSS
        'tools/panels/adminpanels.css'
    ];

    public $js = [

        // Chart Plugins
        'vendor/plugins/highcharts/highcharts.js',
        'vendor/plugins/highcharts/themes/sand-signika.js',

        // FullCalendar Plugin + moment Dependency
        'vendor/plugins/fullcalendar/lib/moment.min.js',
        'vendor/plugins/fullcalendar/fullcalendar.min.js',

        // Notification
        'vendor/plugins/noty/packaged/jquery.noty.packaged.min.js',

        // Admin Panels
        'tools/panels/adminpanels.js',

        // Summernote
        'vendor/plugins/summernote/summernote.min.js',

        // Theme Javascript
        'js/utility.js',
        'js/main.js',
        'js/demo.js'
    ];

    public $jsOptions = [ 'position' => View::POS_END ];

    public $depends = [
        'yii\web\JqueryAsset',
        'common\assets\JuiAsset',
        'common\assets\FontAwesome',
        'backend\assets\BootstrapJsAsset'
    ];
}
