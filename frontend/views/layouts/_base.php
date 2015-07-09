<?php
    use yii\helpers\Html;

    /* @var $this \yii\web\View */
    /* @var $content string */

    frontend\assets\FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="shortcut icon" href="/images/favicon.png" type="image/png">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?= Html::csrfMetaTags() ?>

    <?php $this->registerCssFile('//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=cyrillic,latin',
        ['position' => \yii\web\View::POS_HEAD]) ?>
    <?php $this->registerCssFile('//fonts.googleapis.com/css?family=Roboto:400,300,500&subset=latin,cyrillic',
        ['position' => \yii\web\View::POS_HEAD]) ?>
</head>
<body class="theme-sdtl color-default fixed-sidebar fixed-topbar sidebar-collapsed">

<?php $this->beginBody() ?>

    <!--[if lt IE 7]>
    <p class="browsehappy">
        You are using an <strong>outdated</strong> browser.
        Please <a href="http://browsehappy.com/">upgrade your browser</a>
        to improve your experience.
    </p>
    <![endif]-->
    <section>
    <?php $this->beginContent('@app/views/layouts/templates/sidebar.php'); $this->endContent(); ?>

    <?= $content ?>

    <?php $this->beginContent('@app/views/layouts/templates/builder.php'); $this->endContent(); ?>
    </section>
    <?php $this->beginContent('@app/views/layouts/templates/quickSidebar.php'); $this->endContent(); ?>

    <div class="loader-overlay">
        <div class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
    </div>

    <a href="#" class="scrollup"><i class="fa fa-angle-up"></i></a>

    <div class="modal fade modal-slideleft" id="modal-slideleft" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="c-primary m-b-30">Are you sure you want to proceed?</h2>
                            <button type="button" class="btn btn-primary btn-embossed btn-block" data-dismiss="modal">Yes, I'm sure</button>
                            <button type="button" data-dismiss="modal" class="btn btn-white btn-block">Oops, I prefer not!</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
