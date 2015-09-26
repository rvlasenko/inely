<?php

use yii\helpers\Html;

/**
 * @author hirootkit
 * @var $this    yii\web\View
 * @var $content string
 */

backend\assets\AuthAsset::register($this);

$this->title = Yii::t('backend', 'Join Inely');

$this->registerAssetBundle('common\assets\JuiAsset', $this::POS_HEAD);
$this->registerAssetBundle('yii\web\JqueryAsset', $this::POS_END);
$this->registerAssetBundle('backend\assets\BootstrapJsAsset', $this::POS_END);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>

    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="content-type" content="text/html" />
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

<body class="external-page sb-l-c sb-r-c">

<div id="main" class="animated fadeIn">

    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper" class="auth_wrapper">

        <!-- begin canvas animation bg -->
        <div id="canvas-wrapper">
            <canvas id="demo-canvas"></canvas>
        </div>

        <!-- Begin: Content -->
        <?= $content ?>
        <!-- End: Content -->

        <!-- Admin Form Popup -->
        <div id="modal-form" class="popup-basic admin-form mfp-with-anim mfp-hide"></div>
        <!-- end: .admin-form -->

    </section>
    <!-- End: Content-Wrapper -->

</div>

<?php $this->endBody() ?>
<script>
    jQuery(document).ready(function () {
        "use strict";

        // Init Theme Core
        Core.init();

        // Init CanvasBG and pass target starting location
        CanvasBG.init({
            Loc: {
                x: window.innerWidth / 2, y: window.innerHeight / 3.3
            }
        });

        $('.forgot').magnificPopup({
            removalDelay: 600, items: {
                src: '#modal-form'
            }, callbacks: {
                beforeOpen: function (e) {
                    // Set Magnific Animation
                    var Animation = "mfp-flipInY";
                    this.st.mainClass = Animation;

                    // Inform content container there is an animation
                    this.contentContainer.addClass('mfp-with-anim');
                }
            }
        });
    });
</script>
</body>
</html>
<?php $this->endPage() ?>