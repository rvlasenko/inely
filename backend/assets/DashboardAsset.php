<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author hirootkit
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
        'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,cyrillic',

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
        //'vendor/plugins/noty/packaged/jquery.noty.packaged.min.js',

        // Admin Panels & Dock
        'tools/panels/adminpanels.js',
        'tools/dock/dockmodal.js',

        // Summernote
        'vendor/plugins/summernote/summernote.min.js',

        // Theme Javascript
        'js/utility.js',
        'js/main.js'
    ];

    public $jsOptions = ['position' => View::POS_END];

    public $depends = [
        'yii\web\JqueryAsset',
        'common\assets\JuiAsset',
        'common\assets\FontAwesome',
        'backend\assets\BootstrapJsAsset'
    ];
}