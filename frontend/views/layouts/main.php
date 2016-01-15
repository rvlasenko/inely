<?php

use frontend\assets\FrontendAsset;
use yii\helpers\Html;

FrontendAsset::register($this);

$this->title = Yii::t('frontend', 'Inely - Service for achieving goals');

$this->registerJsFile('js/modernizr.min.js', ['position' => $this::POS_HEAD]);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title><?= Html::encode($this->title) ?></title>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?= Html::csrfMetaTags() ?>
    <link rel="shortcut icon" href="favicon.ico">

    <?php $this->head() ?>
</head>

<?php $this->beginBody() ?>
<body>

<?= $this->render('header') ?>
<?= $content ?>
<?= $this->render('footer') ?>

<a id="to-top"><span class="icon-arrow-up"></span></a>

<div id="success-notification" class="notif-box">
    <span class="icon-bell notif-icon"></span>
    <p>Ваше сообщение было отправлено. Вы получите ответ совсем скоро!</p>
    <a class="notification-close">Закрыть</a>
</div>

<?= $this->render('//land/contact') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>