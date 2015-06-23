<?php
    use frontend\assets\LandingAsset;
    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $form yii\widgets\ActiveForm */
    /* @var $model \frontend\models\ContactForm */

    LandingAsset::register($this);
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
    <?php $this->registerJsFile('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js',
        ['position' => yii\web\View::POS_HEAD]) ?>

    <link rel="icon" href="images/favicon.ico">
</head>
<body class="with-preloader">

<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
