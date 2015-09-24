<section id="slider" class="slider-parallax" data-height-lg="600" data-height-md="500"
         data-height-sm="400" data-height-xs="300" data-height-xxs="250">
    <div class="container clearfix">
        <div class="vertical-middle dark center">

            <div class="heading-block nobottommargin center">
                <h1>
                    <span class="text-rotater tp-caption customin ltl tp-resizeme emphasis-text nopadding noborder nocolor" data-separator="|" data-rotate="flipInX" data-speed="4000">
                        <?= Yii::t('frontend', 'Inely. Your personal <span class="t-rotate">Assistant|Scheduler|Task-Manager|Organizer</span>') ?>
                    </span>
                </h1>
                <span><?= Yii::t('frontend', 'Personal Assistant ready to make your life more manageable. In today\'s world it is easy to feel like there is never enough time in a day to get it all done. That is where Inely can come in.') ?></span>
            </div>

            <a href="<?= Yii::$app->urlManagerBackend->createUrl(false) ?>" class="button button-border button-light button-rounded button-reveal tright button-large topmargin hidden-xs">
                <i class="icon-angle-right"></i><span><?= Yii::t('frontend', 'Join') ?></span>
            </a>

        </div>
    </div>
</section>