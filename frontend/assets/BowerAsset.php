<?php

namespace frontend\assets;

use yii\bootstrap\BootstrapAsset;

class BowerAsset extends BootstrapAsset
{
    public $sourcePath = '@bower/bootstrap/dist';

    public $js = [
        'js/bootstrap.min.js'
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
