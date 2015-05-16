<?php
use yii\helpers\Html;
use frontend\assets\FontAwesomeAsset;
use frontend\assets\LandingAsset;
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\ContactForm */

LandingAsset::register($this);
FontAwesomeAsset::register($this);
$this->title = Yii::t('frontend', 'uNote');
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <!-- METADATA -->
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>
    <?= Html::csrfMetaTags() ?>
    <?php $this->registerJsFile('js/landing/jquery-1.11.1.min.js',
        ['position' => yii\web\View::POS_HEAD]) ?>
    <?php $this->registerJsFile('js/landing/bootstrap.min.js',
        ['position' => yii\web\View::POS_HEAD]) ?>
    <?php $this->registerCssFile('css/landing/colors/blue.css', ['id' => 'color-css']) ?>

    <!-- FAVICON -->
    <link rel="icon" href="images/favicons/favicon.ico"/>
    <link rel="apple-touch-icon" href="images/favicons/apple-touch-icon.png"/>
    <link rel="apple-touch-icon" sizes="72x72" href="images/favicons/apple-touch-icon-72x72.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="images/favicons/apple-touch-icon-114x114.png"/>
</head>
<body class="with-preloader">

<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
