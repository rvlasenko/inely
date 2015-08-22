<?php use yii\widgets\Pjax; use yii\widgets\ActiveForm; use yii\helpers\Html; ?>

<div class="panel">
    <div class="panel-heading">
        <span class="panel-title"><i class="fa fa-rocket"></i><?= Yii::t('backend', 'Password recovery') ?></span>
    </div>
    <!-- end .panel-heading section -->

    <?php Pjax::begin([ 'enablePushState' => false ]) ?>
    <?php $form = ActiveForm::begin([ 'options' => [ 'data-pjax' => true ] ]) ?>
        <div class="panel-body p25">
            <div class="section row">
                <div class="col-md-12 mb20">
                    <span><?= Yii::t('backend', 'Please enter your e-mail. It will receive a letter with instructions to reset your password.') ?></span>
                </div>
                <div class="col-md-12">
                    <label for="firstname" class="field prepend-icon">
                        <?= $form->field($model, 'email', [ 'template' => '{input}{error}' ])->textInput([
                            'class' => 'gui-input', 'placeholder' => 'Email'
                        ])->label(false) ?>
                    </label>
                </div>
                <!-- end section -->
            </div>
            <!-- end section row section -->
        </div>
        <!-- end .form-body section -->

        <div class="panel-footer">
            <?= Html::submitButton(Yii::t('backend', 'Send'), [ 'class' => 'button btn-primary' ]) ?>
        </div>
        <!-- end .form-footer section -->
    <?php ActiveForm::end() ?>
    <?php Pjax::end() ?>
</div>
<!-- end: .panel -->