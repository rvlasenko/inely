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

class AuthAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';

    public $css = [
        'https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&subset=cyrillic',
        'css/auth.css',
        'fonts/icomoon/icomoon.css'
    ];
}
