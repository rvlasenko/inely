<?php

namespace common\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\View;

class BowerAsset extends BootstrapAsset
{
    public $sourcePath = '@bower/bootstrap/dist';

    public $jsOptions = [
        'position' => View::POS_HEAD
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        //'yii\web\JqueryAsset',
    ];
}
