<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

use frontend\assets\FrontendAsset;
use yii\helpers\Html;

FrontendAsset::register($this);

$this->title = Yii::t('frontend', 'Inely - Service for achieving goals');

$this->registerJsFile('js/modernizr.js', ['position' => $this::POS_HEAD]);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title><?= Html::encode($this->title) ?></title>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?= Html::csrfMetaTags() ?>
    <link rel="shortcut icon" href="images/favicon/favicon.ico">

    <link rel="icon" type="image/png" href="images/favicon/favicon-32.png">

    <?php $this->head() ?>
</head>

<?php $this->beginBody() ?>
<body>

<?= $this->render('header') ?>
<?= $content ?>
<?= $this->render('footer') ?>

<a id="to-top"><span class="icon-chevron-thin-up"></span></a>

<?= $this->render('//land/contact') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>