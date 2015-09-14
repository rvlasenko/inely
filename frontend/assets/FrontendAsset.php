<?php

/**
 * This file is part of the Inely project.
 *
 * (c) Inely <http://github.com/inely>
 *
 * @author rootkit
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';

    // Stylesheets
    public $css = [
        'css/font-icons.css',
        'css/style.css',
        'css/animate.css',
        'css/responsive.css'
    ];

    // External JavaScript
    public $js = [ 'js/infinitescroll.min.js' ];

    public $jsOptions = [ 'position' => View::POS_HEAD ];

    public $depends = [ 'common\assets\BootstrapAsset' ];
}
