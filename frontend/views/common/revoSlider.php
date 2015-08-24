<section id="slider" class="slider-parallax revoslider-wrap clearfix">

    <!--
    #################################
        - THEMEPUNCH BANNER -
    #################################
    -->
    <div class="tp-banner-container">
        <div class="tp-banner">
            <ul>
                <!-- SLIDE  -->
                <li class="dark" data-transition="fade" data-slotamount="7" data-masterspeed="1000">
                    <!-- MAIN IMAGE -->
                    <img src="images/slider/rev/notgeneric_bg3.jpg" alt="" data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">
                    <!-- LAYERS -->

                    <div class="tp-caption customin ltl tp-resizeme revo-slider-emphasis-text nopadding noborder"
                         data-x="<?= Yii::t('frontend', '130') ?>"
                         data-y="260"
                         data-customin="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                         data-speed="800"
                         data-start="1000"
                         data-easing="easeOutQuad"
                         data-splitin="none"
                         data-splitout="none"
                         data-elementdelay="0.01"
                         data-endelementdelay="0.1"
                         data-endspeed="1000"
                         data-endeasing="Power4.easeIn" style="z-index: 3;">
                        <?= Yii::t('frontend', 'Inely. Your personal assistant.') ?>
                    </div>

                    <div class="tp-caption customin ltl tp-resizeme revo-slider-desc-text"
                         data-x="195"
                         data-y="370"
                         data-customin="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                         data-speed="800"
                         data-start="1400"
                         data-easing="easeOutQuad"
                         data-splitin="none"
                         data-splitout="none"
                         data-elementdelay="0.01"
                         data-endelementdelay="0.1"
                         data-endspeed="1000"
                         data-endeasing="Power4.easeIn" style="z-index: 3; width: 750px; max-width: 750px; white-space: normal;">
                        <?= Yii::t('frontend', 'Personal Assistant ready to make your life more manageable. In today\'s world it is easy to feel like there is never enough time in a day to get it all done. That is where My Personal Assistant can come in.') ?>
                    </div>

                    <div class="tp-caption customin ltl tp-resizeme"
                         data-x="<?= Yii::t('frontend', '460') ?>"
                         data-y="490"
                         data-customin="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                         data-speed="800"
                         data-start="1550"
                         data-easing="easeOutQuad"
                         data-splitin="none"
                         data-splitout="none"
                         data-elementdelay="0.01"
                         data-endelementdelay="0.1"
                         data-endspeed="1000"
                         data-endeasing="Power4.easeIn" style="z-index: 3;">
                        <a href="<?= Yii::$app->urlManagerBackend->createUrl('') ?>" class="button button-border button-white button-light button-large button-rounded tright nomargin">
                            <span><?= Yii::t('frontend', 'He is here to help!') ?></span> <i class="icon-angle-right"></i>
                        </a>
                    </div>

                </li>
            </ul>

        </div>
    </div>

    <script type="text/javascript">

        var tpj = jQuery;
        tpj.noConflict();

        tpj(document).ready(function () {

            var apiRevoSlider = tpj('.tp-banner').revolution({
                dottedOverlay: "none",
                delay        : 9000,
                startwidth   : 1140,
                startheight  : 700,
                hideThumbs   : 1,
                touchenabled : "off",

                shadow    : 1,
                fullWidth : "on",
                fullScreen: "on",

                spinner: "spinner0",

                stopLoop      : "off",
                stopAfterLoops: -1,
                stopAtSlide   : -1,

                shuffle: "off",

                forceFullWidth      : "off",
                fullScreenAlignForce: "off",
                minFullScreenHeight : "400",

                hideThumbsOnMobile       : "off",
                hideNavDelayOnMobile     : 1500,
                hideBulletsOnMobile      : "off",
                hideArrowsOnMobile       : "off",
                hideThumbsUnderResolution: 0,

                hideSliderAtLimit        : 0,
                hideCaptionAtLimit       : 0,
                hideAllCaptionAtLilmit   : 0,
                startWithSlide           : 0,
                fullScreenOffsetContainer: ".header"
            });

            apiRevoSlider.bind("revolution.slide.onchange", function (e, data) {
                if ($(window).width() > 992) {
                    if (!$('body').hasClass('dark')) {
                        $('#header.transparent-header:not(.semi-transparent)').removeClass('dark');
                        $('#header-wrap').removeClass('not-dark');
                    } else {
                        $('#header.transparent-header:not(.semi-transparent)').removeClass('dark');
                        $('#header.transparent-header:not(.sticky-header,.semi-transparent)').find('#header-wrap').addClass('not-dark');
                    }
                    if ($('#slider ul > li').eq(data.slideIndex - 1).hasClass('dark')) {
                        $('#header.transparent-header:not(.sticky-header,.semi-transparent)').addClass('dark');
                        $('#header.transparent-header.sticky-header,#header.transparent-header.semi-transparent.sticky-header').removeClass('dark');
                        $('#header-wrap').removeClass('not-dark');
                    }
                    SEMICOLON.header.darkLogo();
                }
            });

        });

    </script>

    <!-- END REVOLUTION SLIDER -->

</section>