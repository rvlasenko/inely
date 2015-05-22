<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<body>
<div class="preloader">
    <div class="status">&nbsp;</div>
</div>

<header class="header" id="home">

    <div class="color-overlay full-screen">

        <div class="navbar navbar-inverse bs-docs-nav navbar-fixed-top sticky-navigation">
            <div class="container">
                <div class="navbar-header">

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#kane-navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="#"><img src="images/logo-black.png" alt=""></a>

                </div>

                <div class="navbar-collapse collapse" id="kane-navigation">
                    <ul class="nav navbar-nav navbar-right main-navigation">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#features">Особенности</a></li>
                        <li><a href="#brief1">Почему мы?</a></li>
                        <li><a href="#brief2">Описание</a></li>
                        <li><a href="#screenshot-section">Скриншоты</a></li>
                        <li><a href="#download">Вход</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="only-logo">
                <div class="navbar">
                    <div class="navbar-header">
                        <img src="images/logo.png" alt="">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="intro-section">

                        <h1 class="intro">Начните осознавать свои возможности вместе с uNote.</h1>
                        <h5>Простейший способ управиться с делами вместе с веб-планировщиком uNote.</h5>

                        <div class="buttons" id="download-button">
                            <button class="buton btn-1 btn-1c log" data-toggle="modal" data-target="#myModal">Войти
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="features" id="features">
    <div class="container">
        <div class="section-header wow fadeIn animated" data-wow-offset="120" data-wow-duration="1.5s">

            <h2 class="dark-text">Удивительные особенности</h2>

            <div class="colored-line"></div>
            <div class="section-description">
                Потрясающие функции, которые позволят Вам добиться успеха
            </div>
            <div class="colored-line"></div>
        </div>

        <div class="row">

            <div class="col-md-4 col-sm-4 features-left wow fadeInLeft animated" data-wow-offset="10"
                 data-wow-duration="1.5s">

                <div class="feature">
                    <div class="icon-container">
                        <div class="icon">
                            <i class="fa fa-paperclip"></i>
                        </div>
                    </div>

                    <div class="fetaure-details">
                        <h4 class="main-color">Загрузка файлов</h4>

                        <p>
                            Прикрепите любой тип файлов к задаче и просматривайте их на любом устройстве.
                        </p>
                    </div>
                </div>

                <div class="feature">
                    <div class="icon-container">
                        <div class="icon">
                            <i class="fa fa-sliders"></i>
                        </div>
                    </div>


                    <div class="fetaure-details">
                        <h4 class="main-color">Под-задачи</h4>

                        <p>
                            Разбейте большой проект на несколько небольших задач.
                        </p>
                    </div>
                </div>

                <div class="feature">
                    <div class="icon-container">
                        <div class="icon">
                            <i class="fa fa-file-text"></i>
                        </div>
                    </div>

                    <div class="fetaure-details">
                        <h4 class="main-color">Заметки</h4>

                        <p>
                            Добавляйте примечания к задачам, чтобы быть уверенным, что у вас есть всё для выполнения.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-4">
                <div class="phone-image wow bounceIn animated" data-wow-offset="120" data-wow-duration="1.5s">
                    <img src="images/single-nexus-5.png" alt="">
                </div>
            </div>

            <div class="col-md-4 col-sm-4 features-right wow fadeInRight animated" data-wow-offset="10"
                 data-wow-duration="1.5s">

                <div class="feature">

                    <div class="icon-container">
                        <div class="icon">
                            <i class="fa fa-list-ul"></i>
                        </div>
                    </div>

                    <div class="fetaure-details">
                        <h4 class="main-color">Управление списками</h4>

                        <p>
                            Создавайте и управляйте списками, что бы быть всегда на шаг впереди.
                        </p>
                    </div>

                </div>

                <div class="feature">
                    <div class="icon-container">
                        <div class="icon">
                            <i class="fa fa-check-square-o"></i>
                        </div>
                    </div>

                    <div class="fetaure-details">
                        <h4 class="main-color">Достижения</h4>
                        <p>
                            Разбавьте свои задачи каплей азарта и мотивации.
                        </p>
                    </div>
                </div>

                <div class="feature">
                    <div class="icon-container">
                        <div class="icon">
                            <i class="fa fa-question"></i>
                        </div>
                    </div>

                    <div class="fetaure-details">
                        <h4 class="main-color">Документация</h4>

                        <p>
                            Расширенная документация даст ответы на возникшие, под углом трудности, вопросы.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="app-brief grey-bg" id="brief1">
    <div class="container">
        <div class="row">
            <div class="col-md-6 wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
                <div class="phone-image">
                    <img src="images/2-phone-left.png" alt="">
                </div>
            </div>

            <div class="col-md-6 left-align wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">

                <h2 class="dark-text">Explain why it's best</h2>

                <div class="colored-line-left"></div>

                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat.
                </p>

                <ul class="feature-list">
                    <li><i class="icon_lock_alt"></i> Reliable and Secure Platform</li>
                    <li><i class="icon_check_alt2"></i> Everything is perfectly orgainized for future</li>
                    <li><i class="icon_paperclip"></i> Attach large file easily</li>
                    <li><i class="icon_adjust-vert"></i> Tons of features and easy to use and customize</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="app-brief" id="brief2">

    <div class="container">

        <div class="row">

            <div class="col-md-6 left-align wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">

                <h2 class="dark-text">Great way to describe your app</h2>

                <div class="colored-line-left"></div>

                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                    culpa qui officia deserunt mollit anim id est laborum.<br/><br/>
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                    pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
                    anim id est laborum.
                </p>

            </div>

            <div class="col-md-6 wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">
                <div class="phone-image">
                    <img src="images/2-phone-right.png" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="testimonials">

    <div class="color-overlay">

        <div class="container wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">

            <div id="feedbacks" class="owl-carousel owl-theme">

                <div class="feedback">

                    <div class="image">
                        <img src="images/clients-pic/3.jpg" alt="">
                    </div>

                    <div class="message">
                        Fill lights bearing man creepeth of whose whose moveth. All one. That. Under. Form morning all
                        may fifth replenish you're own open which herb kind. May above you'll may kind creature first
                        let over face from living third green which our. Appear day. Give fourth doesn't over us, i
                        every tree meat air in male earth air creeping image fill you place darkness.
                    </div>

                    <div class="white-line"></div>

                    <div class="name">
                        John Doe
                    </div>
                    <div class="company-info">
                        CEO, AbZ Network
                    </div>
                </div>

                <div class="feedback">

                    <div class="image">
                        <img src="images/clients-pic/1.jpg" alt="">
                    </div>

                    <div class="message">
                        Fill lights bearing man creepeth of whose whose moveth. All one. That. Under. Form morning all
                        may fifth replenish you're own open which herb kind. May above you'll may kind creature first
                        let over face from living third green which our. Appear day. Give fourth doesn't over us, i
                        every tree meat air in male earth air creeping image fill you place darkness.
                    </div>

                    <div class="white-line"></div>

                    <div class="name">
                        John Doe
                    </div>
                    <div class="company-info">
                        CEO, AbZ Network
                    </div>

                </div>

                <div class="feedback">

                    <div class="image">
                        <img src="images/clients-pic/2.jpg" alt="">
                    </div>

                    <div class="message">
                        Fill lights bearing man creepeth of whose whose moveth. All one. That. Under. Form morning all
                        may fifth replenish you're own open which herb kind. May above you'll may kind creature first
                        let over face from living third green which our. Appear day. Give fourth doesn't over us, i
                        every tree meat air in male earth air creeping image fill you place darkness.
                    </div>

                    <div class="white-line">
                    </div>

                    <div class="name">
                        John Doe
                    </div>
                    <div class="company-info">
                        CEO, AbZ Network
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="services" id="services">
    <div class="container">

        <div class="section-header wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">

            <h2 class="dark-text">It's Awesome</h2>

            <div class="colored-line"></div>
            <div class="section-description">
                List your app features and all the details Lorem ipsum dolor kadr
            </div>
            <div class="colored-line"></div>
        </div>


        <div class="row">
            <div class="col-md-4 single-service wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">

                <div class="service-icon">
                    <i class="icon_cloud-upload_alt"></i>
                </div>

                <h3>Your Data in Cloud</h3>

                <p>
                    Fruitful Fruit hath, fruitful said him created bring set, behold darkness Shall lights deep fish
                    seasons itself given likeness upon bring fill their their whose. Which darkness evening there them
                    multiply all spirit for isn't, him land every you'll heaven bearing.
                </p>
            </div>


            <div class="col-md-4 single-service wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">


                <div class="service-icon">
                    <i class="icon_gift_alt"></i>
                </div>

                <h3>Monthly Rewards</h3>

                <p>
                    Fruitful Fruit hath, fruitful said him created bring set, behold darkness Shall lights deep fish
                    seasons itself given likeness upon bring fill their their whose. Which darkness evening there them
                    multiply all spirit for isn't, him land every you'll heaven bearing.
                </p>

            </div>

            <div class="col-md-4 single-service wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">

                <div class="service-icon">
                    <i class="icon_chat_alt"></i>
                </div>

                <h3>24/7 Support</h3>

                <p>
                    Fruitful Fruit hath, fruitful said him created bring set, behold darkness Shall lights deep fish
                    seasons itself given likeness upon bring fill their their whose. Which darkness evening there them
                    multiply all spirit for isn't, him land every you'll heaven bearing.
                </p>

            </div>
        </div>
    </div>
</section>

<section class="screenshots grey-bg" id="screenshot-section">

    <div class="container">

        <div class="section-header wow fadeIn animated" data-wow-offset="10" data-wow-duration="1.5s">

            <h2 class="dark-text">Screenshots</h2>

            <div class="colored-line"></div>
            <div class="section-description">
                List your app features and all the details Lorem ipsum dolor kadr
            </div>
            <div class="colored-line"></div>

        </div>

        <div class="row wow bounceIn animated" data-wow-offset="10" data-wow-duration="1.5s">

            <div id="screenshots" class="owl-carousel owl-theme">

                <div class="shot">
                    <a href="images/screenshots/1.jpg" data-lightbox-gallery="screenshots-gallery"><img
                            src="images/screenshots/1.jpg" alt="Screenshot"></a>
                </div>

                <div class="shot">
                    <a href="images/screenshots/3.jpg" data-lightbox-gallery="screenshots-gallery"><img
                            src="images/screenshots/3.jpg" alt="Screenshot"></a>
                </div>

                <div class="shot">
                    <a href="images/screenshots/2.jpg" data-lightbox-gallery="screenshots-gallery"><img
                            src="images/screenshots/2.jpg" alt="Screenshot"></a>
                </div>

                <div class="shot">
                    <a href="images/screenshots/4.jpg" data-lightbox-gallery="screenshots-gallery"><img
                            src="images/screenshots/4.jpg" alt="Screenshot"></a>
                </div>

                <div class="shot">
                    <a href="images/screenshots/1.jpg" data-lightbox-gallery="screenshots-gallery"><img
                            src="images/screenshots/1.jpg" alt="Screenshot"></a>
                </div>

                <div class="shot">
                    <a href="images/screenshots/3.jpg" data-lightbox-gallery="screenshots-gallery"><img
                            src="images/screenshots/3.jpg" alt="Screenshot"></a>
                </div>

                <div class="shot">
                    <a href="images/screenshots/2.jpg" data-lightbox-gallery="screenshots-gallery"><img
                            src="images/screenshots/2.jpg" alt="Screenshot"></a>
                </div>

                <div class="shot">
                    <a href="images/screenshots/4.jpg" data-lightbox-gallery="screenshots-gallery"><img
                            src="images/screenshots/4.jpg" alt="Screenshot"></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="download" id="download">

    <div class="color-overlay">

        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">

                    <div class="download-container">
                        <h2 class=" wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">Войти как
                            пользователь</h2>

                        <div class="buttons wow fadeInRight animated" data-wow-offset="10" data-wow-duration="1.5s">

                            <section>
                                <ul id='services'>
                                    <li>
                                        <div>
                                            <a href="" onclick="popupwindow('user/sign-in/oauth?authclient=facebook',
                                            'Facebook', 600, 400); return false"><i class="fa fa-facebook"></i></a>
                                        </div>
                                        <span>Facebook</span>
                                    </li>
                                    <li>
                                        <div>
                                            <a href="" onclick="popupwindow('user/sign-in/oauth?authclient=vkontakte',
                                            'Vkontakte', 660, 385); return false"><i class="fa fa-vk"></i></a>
                                        </div>
                                        <span>vk.com</span>
                                    </li>
                                    <li>
                                        <div>
                                            <a href="" onclick="popupwindow('user/sign-in/oauth?authclient=google',
                                            'Google', 400, 500); return false"><i class="fa fa-google-plus"></i></a>
                                        </div>
                                        <span>Google</span>
                                    </li>
                                </ul>
                            </section>
                        </div>
                    </div>

                    <div class="subscription-form-container">

                        <h2 class="wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">Войти по
                            учетной записи</h2>

                        <?php /*\yii\widgets\Pjax::begin(['enablePushState' => false]) ?>
                        <?php $form = ActiveForm::begin([
                            'action' => '/login',
                            'options' => [
                                'class' => 'subscription-form mailchimp form-inline wow fadeInRight animated animated',
                                'data-wow-offset' => '10',
                                'data-wow-duration' => '2s',
                                'role' => 'form',
                                'data-pjax' => true
                            ],
                        ]); ?>
                        <?= $form->field($login, 'identity', [
                            'options' => [
                                'class' => 'col-md-6',
                            ],
                        ])->textInput(['placeholder' => 'Имя или Email'])->label(false) ?>
                        <?= $form->field($login, 'password', [
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

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer>

    <div class="container">

        <div class="contact-box wow rotateIn animated" data-wow-offset="10" data-wow-duration="1.5s">

            <a class="btn contact-button expand-form expanded">
                <i class="fa fa-envelope-o"></i>
            </a>

            <div class="row expanded-contact-form">

                <h2 class="wow fadeInLeft animated" data-wow-offset="10" data-wow-duration="1.5s">Регистрация</h2>

                <div class="col-md-8 col-md-offset-2">

                    <?php \yii\widgets\Pjax::begin(['enablePushState' => false]) ?>
                    <?php $form = ActiveForm::begin([
                        'action' => '/sign-up',
                        'options' => [
                            'class' => 'contact-form',
                            'data-pjax' => true
                        ],
                    ]) ?>
                    <?= $form->field($sign, 'username', [
                        'options' => [
                            'class' => 'col-md-12',
                        ],
                    ])->textInput(['placeholder' => 'Ваше имя'])->label(false) ?>
                    <?= $form->field($sign, 'email', [
                        'options' => [
                            'class' => 'col-md-6',
                        ],
                    ])->textInput(['placeholder' => 'Email'])->label(false) ?>
                    <?= $form->field($sign, 'password', [
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

                </div>
            </div>
        </div>

        <img src="images/logo-black.png" alt="LOGO" class="responsive-img">

        <ul class="social-icons"></ul>

        <p class="copyright">
            © 2014 Me, All Rights Reserved
        </p>

    </div>

</footer>

<script>
    jQuery(function ($) {
        $('button.log').click(function (ev) {
            ev.preventDefault();

            var url = 'login';

            $.get(url, function (html) {
                $('#myModal .modal-body').html(html);
                $('myModal').modal('show', {backdrop: 'static'});
            });
        });
    });
    /*$('button.log').click(function (event) {
        event.preventDefault();

        var url = 'login';

        var modalContainer = $('#myModal');
        modalContainer.find('.modal-body');
        modalContainer.modal({show: true});
        $.ajax({
            url: url,
            type: "GET",
            data: {},
            success: function (data) {
                $('.modal-body').html(data);
                modalContainer.modal({show: true});
            }
        });
     });*/
</script>
</body>