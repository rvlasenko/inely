<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 * @var $this    yii\web\View
 * @var $content string
 */

use frontend\assets\ErrorAsset;
use yii\helpers\Html;

ErrorAsset::register($this);

$this->title = 'Lost Cloud - Error page';

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="squirrellabs" />
    <meta name="keywords" content="squirrellabs" />
    <meta name="description" content="Lost Cloud" />

    <?php $this->head() ?>
    <?= Html::csrfMetaTags() ?>

    <link rel="icon" href="/favicon.png">

</head>

<?php $this->beginBody() ?>

<body id="errorpage" class="error404">

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>