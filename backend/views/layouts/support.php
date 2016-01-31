<?php

/* @var $this yii\web\View */
/* @var $content string */

use yii\helpers\Html;

\backend\assets\DocAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php $this->registerLinkTag([
        'rel'  => 'shortcut icon',
        'type' => 'image/x-icon',
        'href' => 'favicon.ico',
    ]) ?>

    <?php $this->registerCss('
        li.browser-recommended:hover .browser-icon:after {
            content: "Рекомендуем"
        }

        li.browser-partial:hover .browser-icon:after {
            content: "Частичная поддержка"
        }

        .fragment-identifier:after {
            content: "скопировать ссылку"
        }

        #other-features p {
            font-size: 1.1em;
        }

        .faq-answer {
            font-weight: 300;
        }

        .text-warning {
            color: #f6bb42;
        }
    ') ?>

    <?php $this->head() ?>
</head>

<?php $this->beginBody() ?>
<body>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>