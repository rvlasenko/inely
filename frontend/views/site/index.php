<div class="content-wrap">

    <div class="container clearfix">

        <div id="section-intro" class="divcenter center clearfix" style="max-width: 900px;">
            <h1><?= Yii::t('frontend', 'Welcome! This is <span class="tright">Inely</span>') ?></h1>

            <h2><?= Yii::t('frontend', 'Manage your personal goals, your projects, etc. in one place. Our task-manager designed to adapt to all needs. Inely will not give you get bored.') ?></h2>
            <a href="<?= Yii::$app->urlManagerBackend->createUrl('') ?>" class="button button-3d button-large"><?= Yii::t('frontend', 'Try Now') ?></a>
        </div>

        <div class="line"></div>

    </div>

    <div class="section notopmargin" style="padding-bottom: 150px;">

        <div class="hidden-sm hidden-xs desc"></div>

        <div id="section-desc" class="container clearfix" style="z-index: 1;">

            <div class="col-md-6 nobottommargin">

                <div class="heading-block topmargin-sm">
                    <h2>Awesome Scalable Apps</h2>
                    <span>Our Template acts &amp; behaves truly as a Canvas.</span>
                </div>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem maiores pariatur voluptatem placeat laborum iste accusamus nam unde, iure id.</p>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet cumque, perferendis accusamus porro illo exercitationem molestias, inventore obcaecati ut omnis voluptatibus ratione odio amet magnam quidem tempore necessitatibus quaerat, voluptates excepturi voluptatem, veritatis qui temporibus.</p>

            </div>

        </div>

    </div>

    <div class="container clearfix">

        <div id="section-features" class="heading-block title-center page-section">
            <h2><?= Yii::t('frontend', 'Features Overview') ?></h2>
            <span><?= Yii::t('frontend', 'Some of the Features that are gonna blow your mind off') ?></span>
        </div>

        <div class="col_one_third">
            <div class="feature-box fbox-plain">
                <div class="fbox-icon" data-animate="bounceIn">
                    <a href="#"><img src="images/icons/features/responsive.png" alt="Responsive Layout"></a>
                </div>
                <h3><?= Yii::t('frontend', 'Responsive Layout') ?></h3>

                <p><?= Yii::t('frontend', 'Powerful Layout with Responsive functionality that can be adapted to any screen size. Resize browser to view.') ?></p>
            </div>
        </div>

        <div class="col_one_third">
            <div class="feature-box fbox-plain">
                <div class="fbox-icon" data-animate="bounceIn" data-delay="200">
                    <a href="#"><img src="images/icons/features/retina.png" alt="Retina Graphics"></a>
                </div>
                <h3><?= Yii::t('frontend', 'Retina Graphics') ?></h3>

                <p><?= Yii::t('frontend', 'Looks beautiful &amp; ultra-sharp on Retina Screen Displays. Retina Icons &amp; all others graphics are optimized.') ?></p>
            </div>
        </div>

        <div class="col_one_third col_last">
            <div class="feature-box fbox-plain">
                <div class="fbox-icon" data-animate="bounceIn" data-delay="400">
                    <a href="#"><img src="images/icons/features/performance.png" alt="Powerful Performance"></a>
                </div>
                <h3><?= Yii::t('frontend', 'Powerful Performance') ?></h3>

                <p><?= Yii::t('frontend', 'Inely includes tons of optimized code that are completely customizable and deliver unmatched optimization.') ?></p>
            </div>
        </div>

        <div class="clear"></div>

        <div class="col_one_third">
            <div class="feature-box fbox-plain">
                <div class="fbox-icon" data-animate="bounceIn" data-delay="600">
                    <a href="#"><img src="images/icons/features/speedometer.png" alt="Completely yours"></a>
                </div>
                <h3><?= Yii::t('frontend', 'Personalization') ?></h3>

                <p><?= Yii::t('frontend', 'You have complete easy control on each &amp; every element that provides endless customization possibilities.') ?></p>
            </div>
        </div>

        <div class="col_one_third">
            <div class="feature-box fbox-plain">
                <div class="fbox-icon" data-animate="bounceIn" data-delay="800">
                    <a href="#"><img src="images/icons/features/trends.png" alt="Visualize opportunities"></a>
                </div>
                <h3><?= Yii::t('frontend', 'Visualize opportunities') ?></h3>

                <p><?= Yii::t('frontend', 'By means of adaptive schedules trace the productivity and over time visualize it.') ?></p>
            </div>
        </div>

        <div class="col_one_third col_last">
            <div class="feature-box fbox-plain">
                <div class="fbox-icon" data-animate="bounceIn" data-delay="1000">
                    <a href="#"><img src="images/icons/features/gamecontroller.png" alt="Fascinating achievements"></a>
                </div>
                <h3><?= Yii::t('frontend', 'Fascinating achievements') ?></h3>

                <p><?= Yii::t('frontend', 'Earn achievements, increasing the level, receiving more coins and getting to various stages of the game.') ?></p>
            </div>
        </div>

    </div>

    <div class="section nobottommargin nobottomborder" data-stellar-background-ratio="0.3">

        <div id="section-responsive" class="container clearfix">

            <div class="heading-block center">
                <h2><?= Yii::t('frontend', 'Access everywhere') ?></h2>
                <span><?= Yii::t('frontend', 'With responsive design, your tasks are always there: on mobile devices, browsers, and more.') ?></span>
            </div>

            <div style="position: relative; margin-bottom: -60px; height: 415px;" data-height-lg="415" data-height-md="342" data-height-sm="262" data-height-xs="160" data-height-xxs="102">
                <img src="<?= Yii::t('frontend', 'images/services/chrome.png') ?>" style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" alt="Chrome" class="fadeInUp animated">
                <img src="<?= Yii::t('frontend', 'images/services/ipad3.png') ?>" style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" data-delay="300" alt="iPad" class="fadeInUp animated">
            </div>

        </div>

    </div>

    <a href="<?= Yii::$app->urlManagerBackend->createUrl('') ?>" class="button button-full center tright footer-stick">
        <div class="container clearfix">
            <?= Yii::t('frontend', 'Now that you have read all the Tid-Bits, <strong>Let\'s go!</strong>') ?>
            <i class="icon-caret-right"></i>
        </div>
    </a>

</div>