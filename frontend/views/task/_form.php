<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model frontend\models\Task */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
        'enableClientValidation' => false
    ]) ?>

    <?= $form->field($model, 'name', [
        'options' => [
            'class' => 'col-md-6',
        ]
    ])->textInput(['maxlength' => true, 'placeholder' => 'Представьтесь, пожалуйста']) ?>

    <?= $form->field($model, 'category', [
        'options' => [
            'class' => 'col-md-6',
        ]
    ])->textInput(['placeholder' => 'Представьтесь, пожалуйста']) ?>

    <?= $form->field($model, 'author')->textInput() ?>

    <?= $form->field($model, 'priority')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Записать!', [
            'class' => 'btn btn-success btn-square'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
