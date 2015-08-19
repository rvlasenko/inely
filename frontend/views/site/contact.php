<?php use yii\widgets\ActiveForm; use \yii\helpers\Html; use yii\widgets\Pjax; ?>

<?php $this->registerJs('$(document).on("pjax:success", function() { $(":input", "#quick-contact-form").not(":submit").val(""); $(".quick-contact-widget").css("opacity", "1") })') ?>

<div class="widget quick-contact-widget clearfix">

    <h4><?= Yii::t('frontend', 'Send Message') ?></h4>

    <?php Pjax::begin([ 'enablePushState' => false ]) ?>
    <?php $form = ActiveForm::begin([
        'id' => 'quick-contact-form',
        'options' => [ 'class' => 'quick-contact-form nobottommargin', 'data-pjax' => true ],
        'enableClientValidation' => true
    ]) ?>

        <div class="form-process"></div>

        <div class="input-group divcenter">
            <span class="input-group-addon"><i class="icon-user"></i></span>

            <?= $form->field($model, 'name', [ 'template' => '{input}' ])->textInput([
                'class' => 'required form-control input-block-level',
                'placeholder' => Yii::t('frontend', 'Full Name')
            ])->label(false) ?>

        </div>
        <div class="input-group divcenter">
            <span class="input-group-addon"><i class="icon-email2"></i></span>

            <?= $form->field($model, 'email', [ 'template' => '{input}' ])->textInput([
                'class' => 'required form-control email input-block-level',
                'placeholder' => Yii::t('frontend', 'Email Address')
            ])->label(false) ?>

        </div>

        <?= $form->field($model, 'body', [ 'template' => '{input}' ])->textArea([
            'class' => 'required form-control input-block-level short-textarea',
            'placeholder' => Yii::t('frontend', 'Message'),
            'rows' => 4,
            'cols' => 30
        ])->label(false) ?>

        <?= Html::submitButton(Yii::t('frontend', 'Send Letter'), [ 'class' => 'btn btn-danger nomargin' ]) ?>

    <?php ActiveForm::end() ?>
    <?php Pjax::end() ?>

</div>