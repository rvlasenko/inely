<?php

/**
 * @author Copyright (c) 2015 rootkit
 * @license for slider - extended
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class RevSliderAsset extends AssetBundle
{
    public $sourcePath = '@vendor/rev-slider/rev-slider';

    public $css = [
        // SLIDER REVOLUTION 4.x CSS SETTINGS
        'css/settings.css'
    ];

    public $js = [
        // SLIDER REVOLUTION 4.x SCRIPTS
        'js/jquery.themepunch.tools.min.js',
        'js/jquery.themepunch.revolution.min.js'
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD
    ];
}
