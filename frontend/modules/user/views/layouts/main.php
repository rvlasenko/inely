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

use yii\helpers\Html;
use frontend\assets\AuthAsset;

AuthAsset::register($this);
$this->registerJs('
    $("#submit").click(function () {
        if ($("input[name$=\'username\']").val() ||
            $("input[name$=\'email\']").val() &&
            $("input[name$=\'password\']").val()) {
            $("#loader-wrapper").fadeIn()
            setTimeout(function () {
                if ($.trim($(".message").html()))
                    $("#loader-wrapper").fadeOut()
            }, 2000)
        }
    })
    ');

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title><?= Html::encode($this->title) ?></title>

    <?= Html::csrfMetaTags() ?>
    <link rel="shortcut icon" href="images/favicon/favicon.ico">

    <link rel="icon" type="image/png" href="images/favicon/favicon-32.png">

    <?php $this->head() ?>
</head>

<?php $this->beginBody() ?>

<body>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>