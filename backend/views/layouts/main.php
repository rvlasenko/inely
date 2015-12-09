<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 *
 * @var $this    yii\web\View
 * @var $content string
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('backend', 'Inbox ~ Inely');

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
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

<body>
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>

<?= $content ?>

<?php if (Yii::$app->session->hasFlash('alert')): ?>
    <div id="alert">
        <div class="body"><?= ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body') ?></div>
    </div>
<?php endif ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>