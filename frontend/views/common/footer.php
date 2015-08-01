<footer id="footer" class="dark">

    <div class="container">

        <!-- Footer Widgets
        ============================================= -->
        <div class="footer-widgets-wrap clearfix">

            <div class="col_two_third">

                <div class="widget clearfix">

                    <img src="images/footer-widget-logo.png" alt="" class="alignleft" style="margin-top: 8px; padding-right: 18px; border-right: 1px solid #4A4A4A;">

                    <p><?= Yii::t('frontend', 'I believe in <strong>Simple</strong> &amp; <strong>Creative</strong> Design. My mission - to provide the way to properly manage your time. What I do? I give humanity my project, like a gift.') ?></p>

                    <div class="line" style="margin: 30px 0;"></div>

                    <div class="col_half">
                        <div class="widget clearfix">

                            <div class="hidden-xs hidden-sm"><div class="clear" style="padding-top: 10px;"></div></div>

                            <div class="col-md-6 bottommargin-sm center">
                                <div class="counter counter-small" style="color: #35BBAA;"><span data-from="50" data-to="1506" data-refresh-interval="80" data-speed="3000" data-comma="true"></span></div>
                                <h5 class="nobottommargin"><?= Yii::t('frontend', 'Coins earned') ?></h5>
                            </div>

                            <div class="col-md-6 bottommargin-sm center col_last">
                                <div class="counter counter-small" style="color: #2CAACA;"><span data-from="10" data-to="184" data-refresh-interval="50" data-speed="2000" data-comma="true"></span></div>
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

            <div class="col_one_third col_last">

                <div class="widget quick-contact-widget clearfix">

                    <h4><?= Yii::t('frontend', 'Send Message') ?></h4>

                    <div id="quick-contact-form-result" data-notify-type="success" data-notify-msg="<i class=icon-ok-sign></i> <?= Yii::t('frontend', 'Message Sent Successfully!') ?>"></div>

                    <form id="quick-contact-form" name="quick-contact-form" action="include/quickcontact.php" method="post" class="quick-contact-form nobottommargin">

                        <div class="form-process"></div>

                        <div class="input-group divcenter">
                            <span class="input-group-addon"><i class="icon-user"></i></span>
                            <input type="text" class="required form-control input-block-level" id="quick-contact-form-name" name="quick-contact-form-name" value="" placeholder="<?= Yii::t('frontend', 'Full Name') ?>" />
                        </div>
                        <div class="input-group divcenter">
                            <span class="input-group-addon"><i class="icon-email2"></i></span>
                            <input type="text" class="required form-control email input-block-level" id="quick-contact-form-email" name="quick-contact-form-email" value="" placeholder="<?= Yii::t('frontend', 'Email Address') ?>" />
                        </div>
                        <textarea class="required form-control input-block-level short-textarea" id="quick-contact-form-message" name="quick-contact-form-message" rows="4" cols="30" placeholder="<?= Yii::t('frontend', 'Message') ?>"></textarea>
                        <input type="text" class="hidden" id="quick-contact-form-botcheck" name="quick-contact-form-botcheck" value="" />
                        <button type="submit" id="quick-contact-form-submit" name="quick-contact-form-submit" class="btn btn-danger nomargin" value="submit"><?= Yii::t('frontend', 'Send Letter') ?></button>

                    </form>

                    <script type="text/javascript">

                        $("#quick-contact-form").validate({
                            submitHandler: function(form) {
                                $(form).animate({ opacity: 0.4 });
                                $(form).find('.form-process').fadeIn();
                                $(form).ajaxSubmit({
                                    target: '#quick-contact-form-result',
                                    success: function() {
                                        $(form).animate({ opacity: 1 });
                                        $(form).find('.form-process').fadeOut();
                                        $(form).find('.form-control').val('');
                                        $('#quick-contact-form-result').attr('data-notify-msg', $('#quick-contact-form-result').html()).html('');
                                        SEMICOLON.widget.notifications($('#quick-contact-form-result'));
                                    }
                                });
                            }
                        });

                    </script>

                </div>

            </div>

        </div><!-- .footer-widgets-wrap end -->

    </div>

    <!-- Copyrights
    ============================================= -->
    <div id="copyrights">

        <div class="container clearfix">

            <div class="col_half">
                <div class="copyrights-menu copyright-links clearfix">
                    <?php foreach (Yii::$app->params['availableLocales'] as $key => $language): ?>
                    <?= \yii\helpers\Html::a($language, ['/site/set', 'locale' => $key]) ?>
                    <?php endforeach ?>
                </div>
                Copyrights &copy; <?= date('Y') ?> All Rights Reserved by rootkit.
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

    </div><!-- #copyrights end -->

</footer><!-- #footer end -->