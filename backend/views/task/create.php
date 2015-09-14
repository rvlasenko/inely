<?php

/**
 * This file is part of the Inely project.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author rootkit
 *
 * @var $this    yii\web\View
 * @var $content string
 */

use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

//$data = ArrayHelper::map(TaskCat::find()->where([ 'userId' => Yii::$app->user->id ])->all(), 'id', 'name');
?>

<div class="quick-compose-form">

    <?php Pjax::begin([ 'enablePushState' => false ]) ?>
    <?php ActiveForm::begin([
        'id'      => 'form-compose',
        'action'  => 'task/create',
        'options' => [ 'data-pjax' => true ]
    ]) ?>

    <textarea class="form-control" name="Task[name]" id="task-name" placeholder="What you want to do?" autofocus></textarea>
    <input type="text" class="form-control" name="Task[list]" placeholder="Tag for the task">
    <input type="text" class="form-control" name="Task[list]" placeholder="Group">

    <?php ActiveForm::end() ?>
    <?php Pjax::end() ?>

</div>
