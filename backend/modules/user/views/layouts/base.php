<?php

    /**
     * Base layout
     *
     * @author rootkit
     * @var    $this yii\web\View
     * @var    $content string
     */

    use yii\helpers\Html;
    use yii\helpers\ArrayHelper;

    backend\assets\BackendAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>

    <meta charset="<?= Yii::$app->charset ?>">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

</head>

<?php $this->beginBody() ?>
<body>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>