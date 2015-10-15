<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class ScheduleAsset extends AssetBundle
{
    public $basePath = '/';
    public $baseUrl  = '@backendUrl';

    public $css = [
        'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,cyrillic',

        'vendor/plugins/fullcalendar/fullcalendar.min.css',
        'vendor/plugins/magnific/magnific-popup.css',

        'css/skin/theme.css',
        'css/animate.css',

        'tools/forms/admin-forms.css'
    ];

    public $js = [
        'tools/forms/monthpicker.min.js',

        'vendor/plugins/magnific/jquery.magnific-popup.min.js',
        'vendor/plugins/fullcalendar/lib/moment.min.js',
        'vendor/plugins/fullcalendar/fullcalendar.min.js',

        'js/utility.js',
        'js/main.js'
    ];

    public $jsOptions = ['position' => View::POS_END];

    public $depends   = [
        'yii\web\JqueryAsset',
        'common\assets\JuiAsset',
        'common\assets\FontAwesome',
        'common\assets\BootstrapJsAsset'
    ];
}