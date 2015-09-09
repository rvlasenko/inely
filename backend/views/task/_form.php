<?php

use backend\models\TaskCat;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model frontend\models\Task */
/* @var $form yii\widgets\ActiveForm */

$data = ArrayHelper::map(TaskCat::find()->where([ 'userId' => Yii::$app->user->id ])->all(), 'id', 'name');
?>


    <?php Pjax::begin([ 'enablePushState' => false ]) ?>
    <?php $form = ActiveForm::begin([
        'action' => '/task/create',
        'options' => [ 'data-pjax' => true, 'class' => 'quick-compose-form' ]
    ]) ?>

    <?= $form->field($model, 'name', [ 'options' => [ 'class' => 'col-md-6' ] ])->textInput([
        'maxlength' => true,
        'placeholder' => 'Что вы хотите выполнить?'
    ]) ?>

<!--    --><?//= $form->field($model, 'list', [ 'options' => [ 'class' => 'col-md-6' ] ])->widget(Select2::classname(), [
//        'data' => $data,
//        'options' => [ 'placeholder' => 'Ваша категория' ],
//        'pluginOptions' => [ 'allowClear' => true ]
//    ]) ?>

    <div class="col-md-12">
        <?= Html::submitButton('Записать!', [ 'class' => 'btn btn-success btn-square' ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end() ?>
