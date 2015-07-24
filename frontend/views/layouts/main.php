<?php
    use frontend\assets\FrontendAsset;
    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $form yii\widgets\ActiveForm */
    /* @var $model \frontend\models\ContactForm */

    FrontendAsset::register($this);
    $this->title = Yii::t('frontend', 'madeasy');
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <?= Html::csrfMetaTags() ?>
        <?php $this->registerAssetBundle('common\assets\BowerAsset') ?>

        <link rel="icon" href="images/favicon.ico">
    </head>
    <body class="with-preloader">

    <?php $this->beginBody() ?>

    <?= $content ?>

    <div class="modal zoomInDown animated" id="myModal" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="loader"></div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>