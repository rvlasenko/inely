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

    public $jsOptions  = ['position' => View::POS_HEAD];

    public $depends    = ['yii\web\JqueryAsset'];
}
