<?php

    /**
     * Layout for errors
     * @author rootkit
     * @var $this yii\web\View
     * @var $content string
     */

    use yii\helpers\Html;

    frontend\assets\FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?= Html::csrfMetaTags() ?>

    <?php $this->registerCssFile('//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=cyrillic,latin',
        ['position' => \yii\web\View::POS_HEAD]) ?>
</head>
<body class="theme-sdtl color-default error-page">

<?php $this->beginBody() ?>

    <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
