<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

    <?php /*\yii\widgets\Pjax::begin(['enablePushState' => false]) ?>
    <?php $form = ActiveForm::begin([
        'action' => '/login',
        'options' => [
            'class' => 'subscription-form form-inline wow fadeInRight animated animated',
            'data-wow-offset' => '10',
            'data-wow-duration' => '2s',
            'role' => 'form',
            'data-pjax' => true
        ],
    ]); ?>
    <?= $form->field($model, 'identity', [
        'options' => [
            'class' => 'col-md-6',
        ],
    ])->textInput(['placeholder' => 'Имя или Email'])->label(false) ?>
    <?= $form->field($model, 'password', [
        'options' => [
            'class' => 'col-md-6',
        ],
    ])->passwordInput(['placeholder' => 'Пароль'])->label(false) ?>

    <div class="col-md-12">
        <?= Html::submitButton(Yii::t('frontend', 'Login'), [
            'class' => 'buton btn-1 btn-1b login',
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php \yii\widgets\Pjax::end() */?>


<!-- SUBSCRIPTION FORM WITH TITLE -->
<div class="subscription-form-container">

    <!-- =====================
         MAILCHIMP FORM STARTS
         ===================== -->

    <h4 class="wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s"></h4>

    <form class="subscription-form mailchimp form-inline wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s" role="form">
        <?php \yii\widgets\Pjax::begin(['enablePushState' => false]) ?>
        <?php $form = ActiveForm::begin() ?>

        <?= $form->field($model, 'identity')->textInput(['placeholder' => 'Имя или Email'])->label(false) ?>
        <input type="email" name="email" id="subscriber-email" placeholder="Your Email" class="form-control input-box">
        <input type="password" name="password" id="subscriber-email" placeholder="Your Password" class="form-control input-box">

        <div class="col-md-12">
            <?= Html::submitButton(Yii::t('frontend', 'Login'), [
                'class' => 'buton btn-1 btn-1b login',
            ]) ?>
        </div>

    </form>
    <?php ActiveForm::end(); ?>
    <?php \yii\widgets\Pjax::end() ?>

</div>
<!-- END OF SUBSCRIPTION FORM WITH TITLE -->

        <?php /*$form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($model, 'identity') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
            <div style="color:#999;margin:1em 0">
                <?php echo Yii::t('frontend', 'If you forgot your password you can reset it <a href="{link}">here</a>', [
                    'link' => yii\helpers\Url::to(['sign-in/request-password-reset'])
                ]) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('frontend', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <div class="form-group">
                <?php echo Html::a(Yii::t('frontend', 'Need an account? Sign up.'), ['signup']) ?>
            </div>
            <h2><?php echo Yii::t('frontend', 'Log in with') ?>:</h2>

            <div class="form-group">
                <?= yii\authclient\widgets\AuthChoice::widget([
                    'baseAuthUrl' => ['/user/sign-in/oauth']
                ]) ?>
            </div>
            <?php ActiveForm::e
nd(); */?>
