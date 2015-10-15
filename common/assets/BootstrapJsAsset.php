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

class BootstrapJsAsset extends AssetBundle

{
    public $sourcePath = '@bower/bootstrap/dist';
    public $js         = ['js/bootstrap.js'];
}
