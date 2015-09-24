<?php

/**
 * This file is part of the Inely project.
 *
 * (c) Inely <http://github.com/inely>
 *
 * @author rootkit
 */

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class TaskAsset extends AssetBundle
{
    public $basePath = '/';
    public $baseUrl  = '@backendUrl';

    public $css = [

        // Font CSS (Via CDN)
        'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,cyrillic',

        // Theme CSS
        'css/skin/theme.css',
        'css/animate.css'
    ];

    public $js = [

        // Theme Javascript
        'js/utility.js',
        'js/main.js',

        // jsTree
        'vendor/plugins/jstree/jstree.min.js'
    ];

    public $jsOptions = [ 'position' => View::POS_END ];

    public $depends = [
        'yii\web\JqueryAsset',
        'common\assets\FontAwesome',
        'backend\assets\BootstrapJsAsset'
    ];
}