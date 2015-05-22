<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="row">

    <div class="download-container">
        <h3 class="wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">Войти как
            пользователь</h3>

        <div class="buttons wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
            <a href="" onclick="popupwindow('user/sign-in/oauth?authclient=vkontakte',
                    'Facebook', 600, 400); return false" class="icon-button vk">
                <i class="fa fa-vk"></i><span></span></a>
            <a href="" onclick="popupwindow('user/sign-in/oauth?authclient=facebook',
                    'Facebook', 660, 385); return false" class="icon-button facebook">
                <i class="fa fa-facebook"></i><span></span></a>
            <a href="" onclick="popupwindow('user/sign-in/oauth?authclient=google',
                    'Facebook', 400, 500); return false" class="icon-button google-plus">
                <i class="fa fa-google-plus"></i><span></span></a>
        </div>
    </div>

    <h3 class="wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">Войти
        по учетной записи</h3>

    <div class="form-group">
        <?php echo Html::a(Yii::t('frontend', 'Need an account? Sign up.'), ['signup']) ?>
        </div>
    <div class="col-lg-5" style="width: 100%">

        <?php \yii\widgets\Pjax::begin(['enablePushState' => false]) ?>
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
            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div style="color:#999;margin:1em 0">
                <?php echo Yii::t('frontend', 'If you forgot your password you can reset it <a href="{link}">here</a>', [
                    'link' => yii\helpers\Url::to(['sign-in/request-password-reset'])
                ]) ?>
            </div>

        <div class="col-md-12">
            <?= Html::submitButton(Yii::t('frontend', 'Login'), [
                'class' => 'buton btn-1 btn-1b login',
                ]) ?>
            </div>

        <?php ActiveForm::end(); ?>
        <?php \yii\widgets\Pjax::end() ?>
    </div>
</div>

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
    <?php ActiveForm::end(); */
?>
