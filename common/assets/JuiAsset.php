<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace common\assets;

use yii\web\AssetBundle;

class JuiAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-ui';
    public $js         = ['jquery-ui.js'];
}