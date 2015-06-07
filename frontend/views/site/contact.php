<?php
    use yii\widgets\ActiveForm;
?>

<div class="row">
    <h2 class="dark-text">Оставьте своё мнение</h2>

    <div class="col-md-8 col-md-offset-2">

        <?php $form = ActiveForm::begin([
            'id' => 'contact-form',
            'options' => [
                'class' => 'contact-form form-inline fadeInRight animated',
            ],
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
        ]); ?>

        <?= $form->field($model, 'name', [
            'options' => [
                'class' => 'col-md-6',
            ],
        ])->textInput(['placeholder' => 'Представьтесь, пожалуйста'])->label(false) ?>

        <?= $form->field($model, 'email', [
            'options' => [
                'class' => 'col-md-6',
            ],
        ])->textInput(['placeholder' => 'Ваш e-mail'])->label(false) ?>

        <?= $form->field($model, 'subject', [
            'options' => [
                'class' => 'col-md-12',
            ],
        ])->textInput(['placeholder' => 'Тема Вашего обращения'])->label(false) ?>

        <?= $form->field($model, 'body', [
            'options' => [
                'class' => 'col-md-12',
            ],
        ])->textArea(['rows' => 6, 'placeholder' => 'Изложите свои мысли'])->label(false) ?>

        <div class="form-group">
            <button class="bttn btn-2 btn-2a">
                <?= Yii::t('frontend', 'Submit') ?>
            </button>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>