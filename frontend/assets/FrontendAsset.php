<?php

/**
 * @copyright Copyright (c) 2015 Exotic
 * @license For the full copyright and license information, please view the LICENSE.md in root
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css', /* Stylesheets */
        'css/dark.css',
        'css/font-icons.css',
        'css/animate.css',
        'css/magnific-popup.css',
        'css/responsive.css',
        'include/rs-plugin/css/settings.css' /* SLIDER REVOLUTION 4.x CSS SETTINGS */
    ];

    public $js = [
        'js/plugins.js', /* External JavaScripts */
        'include/rs-plugin/js/jquery.themepunch.tools.min.js', /* SLIDER REVOLUTION 4.x SCRIPTS */
        'include/rs-plugin/js/jquery.themepunch.revolution.min.js'
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD
    ];

    public $depends = [
        'common\assets\BowerAsset',
        //'common\assets\FontAwesome'
    ];
}
