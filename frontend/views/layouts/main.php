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

$this->registerAssetBundle('common\assets\JuiAsset', $this::POS_END);
$this->registerAssetBundle('yii\bootstrap\BootstrapPluginAsset', $this::POS_END);

$this->registerJsFile('js/functions.js', [ 'position' => $this::POS_END ]);
$this->registerJsFile('js/plugins.js',   [ 'position' => $this::POS_END ]);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html dir="ltr" lang="<?= Yii::$app->language ?>">
<head>

    <meta http-equiv="content-type" content="text/html" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!--[if lt IE 9]>
    <script src="//css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->

    <title><?= Html::encode($this->title) ?></title>

    <?= Html::csrfMetaTags() ?>
    <link rel="icon" href="favicon.png">

    <?php $this->head() ?>
</head>

<?php $this->beginBody() ?>

<body class="stretched">

<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">

    <!-- Header
    ============================================= -->
    <?= $this->render('//common/header.php') ?>

    <?= $this->render('//common/heroSection.php') ?>

    <!-- Content
    ============================================= -->
    <main id="content" role="main">

        <?= $content ?>

    </main>
    <!-- #content end -->

    <!-- Footer
    ============================================= -->
    <?= $this->render('//common/footer.php') ?>

</div>
<!-- #wrapper end -->

<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>