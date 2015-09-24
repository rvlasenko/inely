<?php

/**
 * @link      http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

namespace common\assets;

use yii\web\AssetBundle;

class JuiAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-ui';
    public $js         = [ 'jquery-ui.js' ];

    public $depends = [ 'yii\web\JqueryAsset' ];
}