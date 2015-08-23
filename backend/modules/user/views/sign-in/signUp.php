<?php use yii\widgets\Pjax; use yii\widgets\ActiveForm; use yii\helpers\Html; ?>
<?php $this->registerJs('$("a.login").click(function() { $.get("login", function(data) { $("#content").html(data) }) })') ?>

<section id="content">

    <div class="admin-form theme-info">

        <div class="row mb15 table-layout">

            <div class="col-xs-6 va-m pln">
                <a href="/" title="<?= Yii::t('backend', 'Return to Dashboard') ?>">
                    <img src="//admindesigns.com/demos/admin/theme/assets/img/logos/logo_white.png" title="Inely Logo" class="img-responsive w250">
                </a>
            </div>

            <div class="col-xs-6 text-right va-b pr5">
                <div class="login-links">
                    <a href="#" class="login" title="<?= Yii::t('backend', 'Sign In') ?>"><?= Yii::t('backend', 'Sign In') ?></a>
                    <span class="text-white"> | </span>
                    <a href="#" class="active signup" title="<?= Yii::t('backend', 'Sign Up') ?>"><?= Yii::t('backend', 'Sign Up') ?></a>
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

            <?php Pjax::begin([ 'enablePushState' => false ]) ?>
            <?php $form = ActiveForm::begin([ 'options' => [ 'data-pjax' => true ] ]) ?>
                <div class="panel-body p25 bg-light">
                    <div class="section-divider col-md-12 mt10 mb40">
                        <span><?= Yii::t('backend', 'A few words about you') ?></span>
                    </div>

                    <div class="section col-md-6">
                        <label for="email" class="field prepend-icon">

                            <?= $form->field($model, 'email', [ 'template' => '{input}{error}' ])->textInput([
                                'class' => 'gui-input', 'placeholder' => Yii::t('backend', 'Email address')
                            ])->label(false) ?>

                        </label>
                    </div>
                    <!-- end section -->

                    <div class="section col-md-6">
                        <div class="smart-widget sm-right">
                            <label for="username" class="field prepend-icon">

                                <?= $form->field($model, 'username', [ 'template' => '{input}{error}' ])->textInput([
                                    'class' => 'gui-input', 'placeholder' => Yii::t('backend', 'Choose your username')
                                ])->label(false) ?>

                            </label>
                        </div>
                        <!-- end .smart-widget section -->
                    </div>
                    <!-- end section -->

                    <div class="section col-md-6">
                        <label for="password" class="field prepend-icon">

                            <?= $form->field($model, 'password', [ 'template' => '{input}' ])->passwordInput([
                                'class' => 'gui-input', 'placeholder' => Yii::t('backend', 'Create a password')
                            ])->label(false) ?>

                        </label>
                    </div>
                    <!-- end section -->

                    <div class="section col-md-6">
                        <label for="confirmPassword" class="field prepend-icon">

                            <?= $form->field($model, 'passwordConfirm', [ 'template' => '{input}{error}' ])->passwordInput([
                                'class' => 'gui-input', 'placeholder' => Yii::t('backend', 'Retype your password')
                            ])->label(false) ?>

                        </label>
                    </div>
                    <!-- end section -->

                </div>
                <!-- end .form-body section -->
                <div class="panel-footer clearfix">
                    <?= Html::submitButton(Yii::t('backend', 'Finish sign up'), [ 'class' => 'button btn-primary pull-right' ]) ?>
                </div>
                <!-- end .form-footer section -->
            <?php ActiveForm::end() ?>
            <?php Pjax::end() ?>
            <div class="col-xs-12 va-b mt10 pr5">
                <div class="login-links">
                    <?php
                        $items = Yii::$app->params[ 'availableLocales' ]; $i = 0; $numItems = count($items);

                        foreach ($items as $key => $language) {
                            echo Html::a($language, [ '/site/set', 'locale' => $key ]);
                            if (++$i !== $numItems) echo '<span class="text-white"> | </span>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

</section>
