<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace common\assets;

use yii\web\View;

class BootstrapAsset extends \yii\bootstrap\BootstrapAsset
{
    public $sourcePath = '@bower/bootstrap/dist';
    public $js         = ['js/bootstrap.min.js'];
    public $jsOptions  = ['position' => View::POS_END];
    public $depends    = ['yii\web\JqueryAsset'];
}
