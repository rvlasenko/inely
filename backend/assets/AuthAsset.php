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

class AuthAsset extends AssetBundle
{
    public $basePath = '/';
    public $baseUrl  = '@backendUrl';

    public $css = [

        // Font CSS (Via CDN)
        'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,cyrillic',

        // Theme CSS
        'css/skin/theme.css',
        'css/animate.css',

        // Admin Forms & Modals
        'tools/forms/admin-forms.css',
        'tools/modals/admin-modals.css',

        // Modal plugin
        'vendor/plugins/magnific/magnific-popup.css'
    ];

    public $js = [

        // Canvas BG
        'vendor/plugins/canvas/canvas.js',

        // Modal plugin
        'vendor/plugins/magnific/jquery.magnific-popup.min.js',

        // Theme Javascript
        'js/utility.js',
        'js/main.js'
    ];

    public $jsOptions = [ 'position' => View::POS_END ];

    public $depends = [ 'common\assets\FontAwesome' ];
}
