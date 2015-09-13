<?php

/**
 * This file is part of the Inely project.
 *
 * (c) Inely <http://github.com/inely>
 *
 * @author rootkit
 *
 * @var $this    yii\web\View
 * @var $content string
 */

use yii\helpers\Html;

backend\assets\CharacterAsset::register($this);

$this->title = Yii::t('backend', 'Your dashboard');
$this->registerAssetBundle('yii\web\JqueryAsset', $this::POS_HEAD);
$this->registerJsFile('vendor/plugins/svg/snap.svg-min.js');
$this->registerJs('$("#fin").click(function () { myDropzone.processQueue() })');
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>

    <meta http-equiv="content-type" content="text/html" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

<body class="dashboard-page boxed-layout sb-l-c">

<?= $this->render('header') ?>

<!-- Start: Main -->
<div id="main">

    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">

        <!-- Begin: Content -->
        <section id="content" class="animated fadeIn">
            <?= $content ?>
        </section>
        <!-- End: Content -->

    </section>
    <!-- End: Content-Wrapper -->
</div>
<!-- End: Main -->

<!-- We;come Form Popup -->
<div id="modal-form" class="popup-basic admin-form mfp-with-anim mfp-hide"></div>
<!-- end: form -->

<?php $this->endBody() ?>

<!-- Page Javascript -->
<script type="text/javascript">
    $(document).ready(function () {
        "use strict";

        // Init Theme Core
        Core.init({ sbm: "sb-l-c" });

        $(".panel-tabs li:first-child").removeClass("active");

        // Upload page
        $("#own").click(function () {
            $(".char-f").fadeOut();
            $(".char-t").fadeIn(1000)
        });

        // Welcome page
        $("#start").click(function () {
            $(".char-t").fadeOut();
            $(".char-f").fadeIn(1000)
        });

        (function () {

            function init() {
                var speed = 250;
                var easing = mina.easeinout;

                [].slice.call(document.querySelectorAll('#grid > a')).forEach(function (el) {
                    var s = Snap(el.querySelector('svg')), path = s.select('path'), pathConfig = {
                            from: path.attr('d'),
                            to:   el.getAttribute('data-path-hover')
                        };

                    el.addEventListener('mouseenter', function () {
                        path.animate({ 'path': pathConfig.to }, speed, easing);
                    });

                    el.addEventListener('mouseleave', function () {
                        path.animate({ 'path': pathConfig.from }, speed, easing);
                    });
                });
            }

            init();

        })();
    });
</script>
</body>
</html>
<?php $this->endPage() ?>