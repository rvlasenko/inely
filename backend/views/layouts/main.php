<?php

use yii\helpers\Html;

/**
 * @author rootkit
 * @var $this    yii\web\View
 * @var $content string
 */

backend\assets\BackendAsset::register($this);

$this->title = Yii::t('backend', 'Your dashboard');

$this->registerAssetBundle('yii\web\YiiAsset', $this::POS_END);
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

<!-- Start: Main -->
<div id="main">

    <?= $this->render('//common/header') ?>

    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">

        <?= $this->render('//common/topbar') ?>

        <!-- Begin: Content -->
        <?= $content ?>
        <!-- End: Content -->

        <?= $this->render('//common/footer') ?>
    </section>
    <!-- End: Content-Wrapper -->
</div>
<!-- End: Main -->

<?php $this->endBody() ?>

<!-- Page Javascript -->
<script type="text/javascript">
    jQuery(document).ready(function () {
        "use strict";

        // Init Theme Core
        Core.init({ sbm: "sb-l-c" });

        // Init Demo JS
        Demo.init();

        // Chart for user activity and perfomance
        $('.ct-chart').highcharts({
            title  : { text: null },
            credits: false,
            chart  : {
                marginTop      : 0,
                plotBorderWidth: 0
            },
            xAxis  : {
                categories: [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ]
            },
            yAxis  : {
                labels: { enabled: false },
                title : { text: null }
            },
            legend : { enabled: false },
            series : [
                {
                    name: 'All visits',
                    data: [ 29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4 ]
                },
                {
                    name: 'London',
                    data: [ 3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8 ]
                }
            ]
        });

        // Remove first line
        $('.highcharts-grid path:first-child').remove();

        // Configure Progress Loader
        NProgress.configure({
            minimum     : 0.15,
            trickleRate : .07,
            trickleSpeed: 360,
            showSpinner : false,
            barColor    : 'npr-info',
            barPos      : 'npr-top'
        });

        NProgress.start();
        setTimeout(function () {
            NProgress.done();
            $('.fade').removeClass('out');
        }, 1000);

        $("#tagcloud").tx3TagCloud({ multiplier: 2 });

        // Init Admin Panels on widgets inside the ".admin-panels" container
        $('.admin-panels').adminpanel({
            grid        : '.admin-grid',
            draggable   : true,
            preserveGrid: true,
            mobile      : false,
            onFinish    : function () {
                $('.admin-panels').addClass('animated fadeIn').removeClass('fade-onload');
            },
            onSave      : function () { $(window).trigger('resize'); }
        });

    });
</script>
</body>
</html>
<?php $this->endPage() ?>