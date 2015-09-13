<?php

use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<section id="content">

    <div class="admin-form theme-info">

        <div class="panel panel-info mt10 br-n">

            <!-- end .form-header section -->
            <?php Pjax::begin([ 'enablePushState' => false ]) ?>
            <?php $form = ActiveForm::begin([ 'options' => [ 'data-pjax' => true ] ]) ?>
            <div class="panel-body bg-light p30">
                <div class="section row">
                    <div class="col-md-12 mb20">
                        <span><?= Yii::t('backend', 'Please enter a new password for your account') ?></span>
                    </div>
                    <div class="col-md-6">
                        <label for="firstname" class="field prepend-icon">

                            <?= $form->field($model, 'password', [ 'template' => '{input}e' ])->passwordInput([
                                'class'       => 'gui-input',
                                'placeholder' => Yii::t('backend', 'This will be your new password')
                            ])->label(false) ?>

                        </label>
                    </div>
                    <div class="col-md-6">
                        <label for="firstname" class="field prepend-icon">

                            <?= $form->field($model, 'passwordConfirm', [ 'template' => '{input}{error}' ])
                                     ->passwordInput([
                                         'class'       => 'gui-input',
                                         'placeholder' => Yii::t('backend', 'Retype your password')
                                     ])->label(false) ?>

                        </label>
                    </div>
                    <!-- end section -->
                </div>
            </div>
            <!-- end .form-body section -->
            <div class="panel-footer clearfix p10 ph15">
                <?= Html::submitButton(Yii::t('backend', 'Submit'), [ 'class' => 'button btn-primary mr10 pull-right' ]) ?>
            </div>
            <!-- end .form-footer section -->
            <?php ActiveForm::end() ?>
            <?php Pjax::end() ?>
        </div>
    </div>

</section>
