<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

    <?php \yii\widgets\Pjax::begin(['enablePushState' => false]) ?>
    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'contact-form',
            'data-pjax' => true
        ],
    ]) ?>
    <?= $form->field($model, 'username', [
        'options' => [
            'class' => 'col-md-12',
        ],
    ])->textInput(['placeholder' => 'Ваше имя'])->label(false) ?>
    <?= $form->field($model, 'email', [
        'options' => [
            'class' => 'col-md-6',
        ],
    ])->textInput(['placeholder' => 'Email'])->label(false) ?>
    <?= $form->field($model, 'password', [
        'options' => [
            'class' => 'col-md-6',
        ],
    ])->passwordInput(['placeholder' => 'Пароль'])->label(false) ?>

    <div class="col-md-12">
        <?= Html::submitButton(Yii::t('frontend', 'Signup'), [
            'class' => 'btn btn-primary standard-button2 ladda-button',
        ])
        ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php \yii\widgets\Pjax::end() ?>
