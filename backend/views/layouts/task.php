<?php

/* @var $this yii\web\View */
/* @var $content string */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->registerJsFile('scripts/preload/modernizr.custom.min.js');
\backend\assets\TaskAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html class="no-js" lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

    <?= Html::csrfMetaTags() ?>
    <?php $this->registerLinkTag([
        'rel'  => 'shortcut icon',
        'type' => 'image/x-icon',
        'href' => 'favicon.ico',
    ]) ?>

    <?php $this->head() ?>
</head>

<?php $this->beginBody() ?>
<body class="<?= Yii::$app->controller->id ?>">

<?= $content ?>

<?= $this->render('//task/right-side') ?>

<?php if (Yii::$app->session->hasFlash('alert')): ?>
    <div id="alert">
        <div class="body"><?= ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body') ?></div>
    </div>
<?php endif ?>

<template id="tick-temp">
    <svg class="svgBox" viewBox="0 0 32 32">
        <polygon points="30,5.077 26,2 11.5,22.5 4.5,15.5 1,19 12,30"></polygon>
    </svg>
</template>

<template id="comment-temp">
    <li class="section-item">
        <div class="section-icon picture">
            <div class="avatar medium">
                <img class="comment-picture" src="" />
            </div>
        </div>
        <div class="section-content">
            <span class="comment-author mr5"></span>
            <span class="comment-time"></span>

            <div class="comment-text"></div>
        </div>
    </li>
</template>

<template id="form-edit-temp">
    <div id="formEdit">
        <div class="bs-component ml30">
            <div class="form-group form-material col-md-12 pln prn">
                <span class="input-group-addon">
                    <i class="fa fa-question-circle fs18" title="Интеллектуальный ввод"></i>
                </span>
                <input type="text" class="form-control input-lg input-add" id="editInput" placeholder="Write here something cool" spellcheck="false">
            </div>
        </div>
    </div>
</template>

<template id="form-add-temp">
    <div id="formAdd">
        <div class="bs-component">
            <div class="form-group form-material col-md-12 mt5 mb5 pln prn">
                <span class="input-group-addon">
                    <i class="fa fa-question-circle fs18" title="Интеллектуальный ввод"></i>
                </span>
                <input type="text" class="form-control input-lg input-add" id="taskInput" placeholder="Write here something cool" spellcheck="false">
            </div>
        </div>
    </div>
</template>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
