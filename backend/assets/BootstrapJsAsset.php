<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace backend\assets;

use yii\web\AssetBundle;

class BootstrapJsAsset extends AssetBundle

{
    public $sourcePath = '@bower/bootstrap/dist';
    public $js         = ['js/bootstrap.js'];
}
