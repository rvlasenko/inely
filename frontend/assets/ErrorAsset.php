<?php

/**
 * Этот файл - часть проекта Inely.
 *
 * @link   http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class ErrorAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';

    public $css = ['css/error.css'];

    public $js = ['js/404.js'];

    public $jsOptions = ['position' => View::POS_HEAD];

    public $depends = ['yii\web\JqueryAsset'];
}
