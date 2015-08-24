<?php

/**
 * @author rootkit
 * @var $this    yii\web\View
 * @var $content string
 */

use frontend\assets\FrontendAsset;
use yii\helpers\Html;

FrontendAsset::register($this);

$this->title = '!!!';

$this->registerAssetBundle('yii\bootstrap\BootstrapPluginAsset', $this::POS_END);

$this->registerJsFile('js/functions.js', [ 'position' => $this::POS_END ]);
$this->registerJsFile('js/plugins.js', [ 'position' => $this::POS_END ]);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html dir="ltr" lang="<?= Yii::$app->language ?>">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--[if lt IE 9]>
    <script src="//css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->

    <!-- Document Title
    ============================================= -->
    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>
    <?= Html::csrfMetaTags() ?>

    <link rel="icon" href="/favicon.png">

</head>

<?php $this->beginBody() ?>

<body class="stretched">

<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix">

    <!-- Content
    ============================================= -->
    <section id="content">

        <?= $content ?>

    </section>
    <!-- #content end -->

</div>
<!-- #wrapper end -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>