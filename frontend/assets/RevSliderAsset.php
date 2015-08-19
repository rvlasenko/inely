<?php

/**
 * @author  Copyright (c) 2015 rootkit
 * @license for slider - extended
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class RevSliderAsset extends AssetBundle
{
    public $sourcePath = '@vendor/rev-slider/rev-slider';

    // SLIDER REVOLUTION 4.x CSS SETTINGS
    public $css = [ 'css/settings.css' ];

    // SLIDER REVOLUTION 4.x SCRIPTS
    public $js = [ 'js/jquery.themepunch.tools.min.js', 'js/jquery.themepunch.revolution.min.js' ];

    public $jsOptions = [ 'position' => View::POS_HEAD ];
}
