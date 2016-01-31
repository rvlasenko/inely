<?php

/* @var $this yii\web\View */
/* @var $content string */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->registerJsFile('scripts/preload/modernizr.custom.min.js');
\backend\assets\TaskAsset::register($this);

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

<?= $content ?>

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