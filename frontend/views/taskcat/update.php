<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\TaskCat */

$this->title = 'Update Task Cat: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Task Cats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-cat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
