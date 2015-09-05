<?php

// Composer
require(__DIR__ . '/../../vendor/autoload.php');

// Environment
require(__DIR__ . '/../../common/env.php');

// Yii
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');

// Bootstrap application
require(__DIR__ . '/../../common/config/bootstrap.php');

$config = \yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/base.php'),
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../config/base.php'),
    require(__DIR__ . '/../config/main.php')
);

(new yii\web\Application($config))->run();
