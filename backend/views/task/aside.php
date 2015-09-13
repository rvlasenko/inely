<?php

use yii\widgets\ListView;

?>

<!-- Quick Compose Button -->
<button id="quick-compose" type="button"
        class="btn btn-danger light btn-block fw600 hint--bottom hint--bounce"
        data-hint="<?= Yii::t('backend', 'Also (q)') ?>"><?= Yii::t('backend', 'Add Task') ?></button>

<!-- Menu -->
<div class="list-group list-group-links mt20" id="sideInfo">
    <a href="#" id="inbox" class="list-group-item pt15"><?= Yii::t('backend', 'Inbox') ?>
        <i class="fa fa-inbox fs20 pull-left"></i>
        <span class="badge badge-info fs11"><?= $countOf[ 0 ][ 0 ][ 'inbox' ] ?></span>
    </a>
    <a href="#" id="today" class="list-group-item"><?= Yii::t('backend', 'Today') ?>
        <i class="fa fa-calendar-o fs20 pull-left"></i>
        <span class="badge badge-info fs11"><?= $countOf[ 1 ][ 0 ][ 'today' ] ?></span>
    </a>
    <a href="#" id="next" class="list-group-item"><?= Yii::t('backend', 'Next 7 days') ?>
        <i class="fa fa-calendar fs20 pull-left"></i>
        <span class="badge badge-info fs11"><?= $countOf[ 2 ][ 0 ][ 'next' ] ?></span>
    </a>
    <a href="#" id="done" class="list-group-item">Completed
        <i class="fa fa-calendar-check-o fs20 pull-left"></i>
        <span class="badge badge-success fs11">0</span>
    </a>
</div>

<div class="list-group list-group-links">
    <div class="list-group-header"><?= Yii::t('backend', 'Projects') ?></div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'summary'      => false,
        'itemView'     => function ($model) {
            return $this->render('_asideForm', [ 'model' => $model ]);
        }
    ]) ?>
</div>