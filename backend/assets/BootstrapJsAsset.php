<?php

/**
 * This file is part of the Inely project.
 *
 * (c) Inely <http://github.com/inely>
 *
 * @author rootkit
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Twitter bootstrap javascript files.
 *
 * @author rootkit
 */
class BootstrapJsAsset extends AssetBundle

{
    public $sourcePath = '@bower/bootstrap/dist';
    public $js         = [ 'js/bootstrap.js' ];
}
