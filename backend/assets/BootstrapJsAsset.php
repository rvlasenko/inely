<?php

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
