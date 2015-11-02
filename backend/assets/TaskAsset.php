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

class TaskAsset extends AssetBundle
{
    public $basePath = '/';
    public $baseUrl  = '@backendUrl';

    public $css = [
        // Шрифт Open Sans
        'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,cyrillic',

        // Общие CSS файлы
        'css/theme.css',
        'css/animate.css'
    ];

    public $js = [
        'js/utility.js',
        'js/main.js',

        // jsTree
        'vendor/plugins/jstree/jstree.min.js',

        // Перевод DatePicker
        'tools/forms/datepicker-ru.js'
    ];

    public $jsOptions = ['position' => View::POS_END];

    public $depends   = [
        'yii\web\JqueryAsset',
        'common\assets\BootstrapAsset',
        'common\assets\JuiAsset',
        'common\assets\FontAwesome',
    ];
}