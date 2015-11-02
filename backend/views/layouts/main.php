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

$this->registerAssetBundle('yii\web\YiiAsset', $this::POS_END);
$this->title = Yii::t('backend', 'Inbox ~ Inely');
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="content-type" content="text/html" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <title><?= Html::encode($this->title) ?></title>

    <?= Html::csrfMetaTags() ?>
    <link rel="icon" href="favicon.png">

    <?php $this->head() ?>
</head>

<?php $this->beginBody() ?>

<body class="task-page boxed-layout sb-l-o sb-r-c">

<!-- Start: Main -->
<main role="main">
    <?= $this->render('//task/left-sidebar') ?>

    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">
        <!-- Begin: Content -->
        <section id="content" class="animated fadeIn table-layout">
            <?php if (Yii::$app->session->hasFlash('alert')): ?>

                <div class="alert alert-primary alert-dismissable mb30">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h3 class="mt5"><?= ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'title') ?></h3>

                    <p><?= ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body') ?></p>
                </div>

            <?php endif ?>
            <?= $content ?>
        </section>
        <!-- End: Content -->
    </section>
    <!-- End: Content-Wrapper -->

    <?= $this->render('//task/right-sidebar') ?>
</main>
<!-- End: Main -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>