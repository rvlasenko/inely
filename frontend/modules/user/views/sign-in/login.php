<?php
    use yii\widgets\ActiveForm;

    $this->registerJsFile('@web/js/landing/uiProgressButton.js', [
        'position' => yii\web\View::POS_BEGIN]);
    $this->registerCssFile('@web/css/icons/font-awesome/css/font-awesome.min.css');
?>

<div class="row">

    <div class="download-container">
        <h3 class="fadeInLeft animated"><?= Yii::t('frontend', 'Login as user') ?></h3>

        <div class="buttons fadeInRight animated">
            <a href="" onclick="popUpWindow('user/sign-in/oauth?authclient=vkontakte',
                    'Vkontakte', 600, 400); return false" class="icon-button vk">
                <i class="fa fa-vk"></i><span></span>
            </a>
            <a href="" onclick="popUpWindow('user/sign-in/oauth?authclient=facebook',
                    'Facebook', 660, 385); return false" class="icon-button facebook">
                <i class="fa fa-facebook"></i><span></span>
            </a>
            <a href="" onclick="popUpWindow('user/sign-in/oauth?authclient=google',
                    'Google Plus', 440, 500); return false" class="icon-button google-plus">
                <i class="fa fa-google-plus"></i><span></span>
            </a>
        </div>
    </div>

    <h3 class="fadeInLeft animated"><?= Yii::t('frontend', 'Login with account') ?></h3>

    <div class="form-group fadeInLeft animated">
        <a class="sign-a" href="#">
            <?= Yii::t('frontend', 'Need an account? Sign up.') ?></a>
    </div>

    <div class="col-lg-5" style="width: 100%">

        <?php \yii\widgets\Pjax::begin(['enablePushState' => false]) ?>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'action' => 'login',
            'options' => [
                'class' => 'subscription-form form-inline fadeInRight animated',
                'data-pjax' => true
            ],
        ]); ?>
        <?= $form->field($model, 'identity', [
            'options' => [
                'class' => 'col-md-6',
            ],
        ])->textInput(['placeholder' => 'Логин или e-mail'])->label(false) ?>

        <?= $form->field($model, 'password', [
            'options' => [
                'class' => 'col-md-6',
            ],
        ])->passwordInput(['placeholder' => 'Пароль'])->label(false) ?>

        <div class="col-md-12" style="margin: 1em 0">
            <?= Yii::t('frontend', 'If you forgot your password you can reset it <a class="reset-a" href="#">here</a>') ?>
        </div>
        <?php ActiveForm::end(); ?>
        <?php \yii\widgets\Pjax::end() ?>

        <div class="col-md-12">
            <div id="progress-button" class="progress-button">
                <button form="login-form" class="fadeInRight animated">
                    <span><?= Yii::t('frontend', 'Login') ?></span>
                </button>

                <svg class="progress-circle" width="70" height="70">
                    <path d="m35,2.5c17.955803,0 32.5,14.544199 32.5,32.5c0,17.955803 -14.544197,32.5 -32.5,32.5c-17.955803,0 -32.5,-14.544197 -32.5,-32.5c0,-17.955801 14.544197,-32.5 32.5,-32.5z"/>
                </svg>

                <svg class="checkmark" width="70" height="70">
                    <path d="m31.5,46.5l15.3,-23.2"/>
                    <path d="m31.5,46.5l-8.5,-7.1"/>
                </svg>

                <svg class="cross" width="70" height="70">
                    <path d="m35,35l-9.3,-9.3"/>
                    <path d="m35,35l9.3,9.3"/>
                    <path d="m35,35l-9.3,9.3"/>
                    <path d="m35,35l9.3,-9.3"/>
                </svg>

            </div>
        </div>
    </div>
</div>

<script>
    [].slice.call(document.querySelectorAll('.progress-button')).forEach(function(bttn, pos) {
        new UIProgressButton( bttn, {
            callback : function(instance) {
                var progress = 0,
                    success = 1;
                    error = -1;
                    value = $.trim($("#loginform-identity").val());

                if (value.length > 0)
                    var interval = setInterval(function() {
                        icon(pos, instance, progress, success, error, interval);
                    }, 1500);
                else
                    icon(pos, instance, progress, success, error);
            }
        } );
    } );

    jQuery(function($) {
        $('.sign-a').click(function(ev) {
            showModal('sign-up', ev);
        });

        $('.reset-a').click(function(ev) {
            showModal('user/sign-in/request-password-reset', ev);
        });
    });
</script>