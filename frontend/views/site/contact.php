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
            <button class="bttn btn-2 btn-2a" id="show">
                <?= Yii::t('frontend', 'Submit') ?>
            </button>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>

<script>
    $(document).ready(function() {
        function generate(title, img, desc, link, linkDesc) {
            noty({
                text: '<div class="alert alert-dark media fade in bd-0" id="message-alert">' +
                '<div class="media-left">' +
                '<img src="' + img + '" ' +
                'class="dis-block">' +
                '</div><div class="media-body width-100p">' +
                '<h4 class="alert-title f-14">' + title + '</h4>' +
                '<p class="f-12 alert-message pull-left">' +
                '' + desc + '</p>' +
                '<p class="pull-right">' +
                '<a href="' + link + '" class="f-12">' + linkDesc + '</a>' +
                '</p></div></div>',
                layout: 'topRight',
                theme: 'made',
                maxVisible: 10,
                animation: {
                    open: 'animated bounceIn',
                    close: 'animated bounceOut',
                    easing: 'swing',
                    speed: 500
                },
                timeout: 4000
            });
        }

        $("#show").click(function () {
            if (!$('#contactform-name').val() || !$('#contactform-email').val() ||
                !$('#contactform-subject').val() || !$('#contactform-body').val())
                generate('Ошибка',
                         'images/ballicons 2/svg/wrench.svg',
                         'Хм, похоже, что Вы забыли заполнить необходимые поля!',
                         '',
                         '');
            else
                generate(
                    'Спасибо!',
                    'images/ballicons 2/svg/heart.svg',
                    'Благодарим за проявленную инициативу к проекту! Ваше мнение будет услышано.',
                    '',
                    '');
        });
    });
</script>