<footer id="footer" class="dark">

    <div class="container">

        <!-- Footer Widgets
        ============================================= -->
        <div class="footer-widgets-wrap clearfix">

            <div class="col_two_third">

                <div class="widget clearfix">

                    <h2 class="purple-footer-logo">inely</h2>

                    <p></p>

                    <h4 class="author" style="font-weight: 500;">Crafted with love by hirootkit.</h4>

                    <div class="line" style="margin: 30px 0;"></div>

                    <div class="col_half">
                        <div class="widget clearfix">

                            <div class="hidden-xs hidden-sm">
                                <div class="clear" style="padding-top: 10px;"></div>
                            </div>

                            <div class="col-md-6 col-xs-6 bottommargin-sm center">
                                <div class="counter counter-small" style="color: #35BBAA;">
                                    <span data-from="50" data-to="1506" data-refresh-interval="80" data-speed="3000" data-comma="true"></span>
                                </div>
                                <h5 class="nobottommargin"><?= Yii::t('frontend', 'XP earned') ?></h5>
                            </div>

                            <div class="col-md-6 col-xs-6 bottommargin-sm center col_last">
                                <div class="counter counter-small" style="color: #2CAACA;">
                                    <span data-from="10" data-to="184" data-refresh-interval="50" data-speed="2000" data-comma="true"></span>
                                </div>
                                <h5 class="nobottommargin"><?= Yii::t('frontend', 'Tasks performed') ?></h5>
                            </div>

                        </div>
                    </div>

                    <div class="col_half col_last">

                        <div class="widget clearfix">
                            <h4><?= Yii::t('frontend', 'Client Testimonials') ?></h4>

                            <div class="fslider testimonial no-image nobg noborder noshadow nopadding" data-animation="slide" data-arrows="false">
                                <div class="flexslider">
                                    <div class="slider-wrap">
                                        <div class="slide">
                                            <div class="testi-content">
                                                <p>Similique fugit repellendus expedita excepturi iure perferendis provident quia eaque. Repellendus, vero numquam?</p>

                                                <div class="testi-meta">Steve Jobs<span>Apple Inc.</span></div>
                                            </div>
                                        </div>
                                        <div class="slide">
                                            <div class="testi-content">
                                                <p>Incidunt deleniti blanditiis quas aperiam recusandae consequatur ullam quibusdam cum libero illo rerum!</p>

                                                <div class="testi-meta">John Doe<span>XYZ Inc.</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col_one_third col_last contact"></div>

        </div>
        <!-- .footer-widgets-wrap end -->

    </div>

    <!-- Copyrights
    ============================================= -->
    <div id="copyrights">

        <div class="container clearfix">

            <div class="col_half">
                <div class="copyrights-menu copyright-links clearfix">
                    <?= $this->render('//layouts/_locale') ?>
                </div>
                Copyrights &copy; <?= date('Y') ?> All Rights Reserved by Vlasenko.
            </div>

            <div class="col_half col_last tright">
                <div class="fright clearfix">
                    <a href="#" class="social-icon si-small si-borderless nobottommargin si-facebook">
                        <i class="icon-facebook"></i>
                        <i class="icon-facebook"></i>
                    </a>

                    <a href="#" class="social-icon si-small si-borderless nobottommargin si-twitter">
                        <i class="icon-twitter"></i>
                        <i class="icon-twitter"></i>
                    </a>

                    <a href="#" class="social-icon si-small si-borderless nobottommargin si-gplus">
                        <i class="icon-gplus"></i>
                        <i class="icon-gplus"></i>
                    </a>

                    <a href="#" class="social-icon si-small si-borderless nobottommargin si-github">
                        <i class="icon-github"></i>
                        <i class="icon-github"></i>
                    </a>
                </div>
            </div>

        </div>

    </div>
    <!-- #copyrights end -->

</footer><!-- #footer end -->