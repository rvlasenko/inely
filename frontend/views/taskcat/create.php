<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\TaskCat */

$this->title = 'Create Task Cat';
$this->params['breadcrumbs'][] = ['label' => 'Task Cats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-cat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
