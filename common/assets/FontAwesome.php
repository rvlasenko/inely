<?php

namespace common\assets;

use yii\web\AssetBundle;

class FontAwesome extends AssetBundle
{
    public $sourcePath = '@vendor/fortawesome/font-awesome';

    public $css        = ['css/font-awesome.min.css'];
}