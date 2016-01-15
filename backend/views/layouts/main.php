<?php

/* @var $this yii\web\View */
/* @var $content string */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->registerJsFile('scripts/preload/modernizr.custom.min.js');

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html class="no-js" lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

    <?= Html::csrfMetaTags() ?>
    <?php $this->registerLinkTag([
        'rel'  => 'shortcut icon',
        'type' => 'image/x-icon',
        'href' => 'favicon.ico',
    ]) ?>

    <?php $this->head() ?>
</head>

<?php $this->beginBody() ?>

<body class="<?= Yii::$app->controller->id ?>">
<div id="ip-container">
    <header class="ip-header">
        <img src="images/tick.png" class="ip-logo" />
        <div class="ip-loader">
            <svg class="ip-inner" width="60px" height="60px" viewBox="0 0 80 80">
                <path class="ip-loader-circlebg" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"/>
                <path id="ip-loader-circle" class="ip-loader-circle" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"/>
            </svg>
        </div>
    </header>
    <div id="sb-site" class="ip-main">
        <?= $content ?>
    </div>
</div>

<?= $this->render('//task/right-side') ?>

<?php if (Yii::$app->session->hasFlash('alert')): ?>
    <div id="alert">
        <div class="body"><?= ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body') ?></div>
    </div>
<?php endif ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>