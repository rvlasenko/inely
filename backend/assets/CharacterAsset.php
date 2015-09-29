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

class CharacterAsset extends AssetBundle
{
    public $basePath = '/';
    public $baseUrl  = '@backendUrl';

    public $css = [

        // Font CSS (Via CDN)
        'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600&subset=latin,cyrillic',

        // Snap SVG
        'vendor/plugins/svg/component.css',

        // Theme CSS
        'css/skin/theme.css',
        'css/animate.css'

    ];

    public $js = [
        'js/utility.js',
        'js/main.js'
    ];

    public $jsOptions = ['position' => View::POS_END];

    public $depends   = [
        'common\assets\FontAwesome',
        'backend\assets\BootstrapJsAsset'
    ];
}