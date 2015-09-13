<?php

use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?php $this->registerJs('$("a.signup").click(function() { $.get("signup", function(data) { $("#content").html(data) }) })') ?>
<?php $this->registerJs('$.get("reset", function(data) { $("#modal-form").html(data) })') ?>

<section id="content">

    <div class="admin-form theme-info">

        <div class="row mb15 table-layout">

            <div class="col-xs-6 va-m pln">
                <a href="/">
                    <img src="//admindesigns.com/demos/admin/theme/assets/img/logos/logo_white.png" title="Inely Logo" class="img-responsive w250">
                </a>
            </div>

            <div class="col-xs-6 text-right va-b pr5">
                <div class="login-links">
                    <a href="#" class="active login" title="<?= Yii::t('backend', 'Sign In') ?>"><?= Yii::t('backend', 'Sign In') ?></a>
                    <span class="text-white"> | </span>
                    <a href="#" class="signup" title="<?= Yii::t('backend', 'Sign Up') ?>"><?= Yii::t('backend', 'Sign Up') ?></a>
                </div>

            </div>

        </div>

        <div class="panel panel-info mt10 br-n">

            <div class="panel-heading heading-border bg-white">

                <div class="section row mn">
                    <div class="col-sm-4">
                        <a href="user/sign-in/oauth?authclient=facebook" class="button btn-social facebook span-left mr5 btn-block">
                            <span><i class="fa fa-facebook"></i></span>Facebook</a>
                    </div>
                    <div class="col-sm-4">
                        <a href="user/sign-in/oauth?authclient=vkontakte" class="button btn-social vkontakte span-left mr5 btn-block">
                            <span><i class="fa fa-vk"></i></span>Vkontakte</a>
                    </div>
                    <div class="col-sm-4">
                        <a href="user/sign-in/oauth?authclient=google" class="button btn-social googleplus span-left btn-block">
                            <span><i class="fa fa-google-plus"></i></span>Google+</a>
                    </div>
                </div>
            </div>

            <!-- end .form-header section -->
            <?php Pjax::begin([ 'enablePushState' => false ]) ?>
            <?php $form = ActiveForm::begin([ 'options' => [ 'data-pjax' => true ] ]) ?>
            <div class="panel-body bg-light p30">
                <div class="row">
                    <div class="col-sm-7 pr30">

                        <div class="section">
                            <label for="username" class="field-label text-muted fs18 mb10"><?= Yii::t('backend', 'Username') ?></label>
                            <label for="username" class="field prepend-icon">

                                <?= $form->field($model, 'identity', [ 'template' => '{input}' ])
                                    ->textInput([ 'class' => 'gui-input' ])
                                    ->label(false) ?>

                            </label>
                        </div>
                        <!-- end section -->

                        <div class="section">
                            <label for="username" class="field-label text-muted fs18 mb10"><?= Yii::t('backend', 'Password') ?>
                                <a href="reset" class="fs14 forgot"><?= Yii::t('backend', 'you forgot?') ?></a>
                            </label>
                            <label for="password" class="field prepend-icon">

                                <?= $form->field($model, 'password', [ 'template' => '{input}{error}' ])
                                    ->passwordInput([ 'class' => 'gui-input' ])
                                    ->label(false) ?>

                            </label>
                        </div>
                        <!-- end section -->

                    </div>
                    <div class="col-sm-5 br-grey pl20">
                        <h3 class="mb25"><?= Yii::t('backend', 'You\'ll love your Inely') ?></h3>

                        <p class="mb15">
                            <span class="fa fa-check text-success pr5"></span><?= Yii::t('backend', 'A new look at the task scheduling') ?>
                        </p>

                        <p class="mb15">
                            <span class="fa fa-check text-success pr5"></span><?= Yii::t('backend', 'Notifications, Lists, Stats...') ?>
                        </p>

                        <p class="mb15">
                            <span class="fa fa-check text-success pr5"></span><?= Yii::t('backend', 'And your new friend!') ?>
                        </p>

                    </div>
                </div>
            </div>
            <!-- end .form-body section -->
            <div class="panel-footer clearfix p10 ph15">
                <?= Html::submitButton(Yii::t('backend', 'Sign In'), [ 'class' => 'button btn-primary mr10 pull-right' ]) ?>

                <label class="switch ib switch-primary pull-left input-align mt10">
                    <input type="checkbox" name="LoginForm[rememberMe]" id="remember" checked="">
                    <label for="remember" data-on="<?= Yii::t('backend', 'Yes') ?>" data-off="<?= Yii::t('backend', 'No') ?>"></label>
                    <span><?= Yii::t('backend', 'Remember Me') ?></span>
                </label>
            </div>
            <!-- end .form-footer section -->
            <?php ActiveForm::end() ?>
            <?php Pjax::end() ?>
            <div class="col-xs-12 va-b mt10 pr5">
                <div class="login-links">
                    <?= $this->render('_locale') ?>
                </div>
            </div>
        </div>
    </div>

</section>
