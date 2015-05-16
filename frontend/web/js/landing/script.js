;
(function ($) {
    "use strict";

    /* =======================================
     * Function: Detect Mobile Device
     * =======================================
     */

    // source: http://www.abeautifulsite.net/detecting-mobile-devices-with-javascript/
    var isMobile = {
        Android: function () {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function () {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function () {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function () {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function () {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function () {
            return ( isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows() );
        }
    };

    /* =======================================
     * Function: Resize Video Background
     * =======================================
     */
    var resizeVideoBackground = function () {

        $('.video-background').each(function (i, el) {
            var $el = $(el),
                $section = $el.parent(),
                min_w = 300,
                video_w = 16,
                video_h = 9,
                section_w = $section.outerWidth(),
                section_h = $section.outerHeight(),
                scale_w = section_w / video_w,
                scale_h = section_h / video_h,
                scale = scale_w > scale_h ? scale_w : scale_h,
                new_video_w, new_video_h, offet_top, offet_left;


            if (scale * video_w < min_w) {
                scale = min_w / video_w;
            }
            ;

            new_video_w = scale * video_w;
            new_video_h = scale * video_h;
            offet_left = ( new_video_w - section_w ) / 2 * -1;
            offet_top = ( new_video_h - section_h ) / 2 * -1;

            $el.css('width', new_video_w);
            $el.css('height', new_video_h);
            $el.css('marginTop', offet_top);
            $el.css('marginLeft', offet_left);
        });

    };

    $(document).on('ready', function () {

        /* =======================================
         * Splash Screen Logo
         * =======================================
         */
        $('#preloader .preloader-logo > img').on('load', function () {
            $(this).show().addClass('bounceIn').next().show();
        });

        /* =======================================
         * Detect Mobile Device
         * =======================================
         */
        if (isMobile.any()) {
            // add identifier class to <body>
            $('body').addClass('mobile-device');
            // remove all element with class "remove-on-mobile-device"
            $('.remove-on-mobile-device').remove();
        }

        /* =======================================
         * Resize Video Background
         * =======================================
         */
        $(window).on('resize', function () {
            resizeVideoBackground();
        });
        resizeVideoBackground();

        /* =======================================
         * Initiate Stellar JS
         * =======================================
         */
        $.stellar({
            responsive: true,
            horizontalScrolling: false,
            hideDistantElements: false,
        });

        /* =======================================
         * WOW JS
         * =======================================
         */
        var wow = new WOW({
            mobile: false,
            offset: 60,
        });
        wow.init();

        $('#contact').on('shown.bs.collapse', function () {
            wow.scrollHandler();
        });

        /* =======================================
         * Initiate Owl Carousel
         * =======================================
         */
        $('.screenshot-images').owlCarousel({
            items: 4,
            itemsCustom: [
                [0, 1],
                [480, 2],
                [768, 3],
                [992, 4]
            ],
        });
        $('.testimonial-items').owlCarousel({
            singleItem: true,
            autoHeight: true,
        });

        /* =======================================
         * Scroll Spy
         * =======================================
         */
        $(window).on('scroll', function () {

            // Floating Header
            if ($(window).scrollTop() > 60) {
                $('.header-floating').addClass('floating');
            } else {
                $('.header-floating').removeClass('floating');
            }
        });

        /* =======================================
         * One Page Navigation
         * =======================================
         */
        $('#navigation').onePageNav({
            changeHash: true,
            scrollSpeed: 1000,
            scrollOffset: 60,
        });

        $('a.anchor-link').on('click', function (e) {
            e.preventDefault();

            var $a = $(this),
                $target = $($a.attr('href'));

            if ($target.length < 1) return;

            $('html, body').animate({scrollTop: $target.offset().top}, 1000);
        });

        /* =======================================
         * Nivo Lightbox
         * =======================================
         */
        $('.screenshot-images a').nivoLightbox({
            effect: 'fadeScale',
            beforeShowLightbox: function () {
                $('#document').addClass('blur');
            },
            afterHideLightbox: function () {
                $('#document').removeClass('blur');
            },
        });

        /* =======================================
         * Subscribe Form AJAX
         * =======================================
         */
        $('#subscribe-form').on('submit', function (e) {
            e.preventDefault();

            var $el = $(this),
                $alert = $el.find('.form-validation'),
                $submit = $el.find('button'),
                action = $el.attr('action');

            // button loading
            $submit.button('loading');

            // reset alert
            $alert.removeClass('alert-danger alert-success');
            $alert.html('');

            $.ajax({
                type: 'POST',
                url: action,
                data: $el.serialize() + '&ajax=1',
                dataType: 'JSON',
                success: function (response) {

                    // error
                    if (response.status == 'error') {
                        $alert.html(response.message);
                        $alert.addClass('alert-danger').fadeIn(500);
                    }

                    // success
                    else {
                        $el.trigger('reset');
                        $alert.html(response.message);
                        $alert.addClass('alert-success').fadeIn(500);
                    }

                    // reset button
                    $submit.button('reset');
                },
            })
        });

        /* =======================================
         * Contact Form AJAX
         * =======================================
         */
        $('#contact-form').on('submit', function (e) {
            e.preventDefault();

            var $el = $(this),
                $alert = $el.find('.form-validation'),
                $submit = $el.find('button'),
                action = $el.attr('action');

            // button loading
            $submit.button('loading');

            // reset alert
            $alert.removeClass('alert-danger alert-success');
            $alert.html('');

            $.ajax({
                type: 'POST',
                url: action,
                data: $el.serialize() + '&ajax=1',
                dataType: 'JSON',
                success: function (response) {

                    // error
                    if (response.status == 'error') {
                        $alert.html(response.message);
                        $alert.addClass('alert-danger').fadeIn(500);
                    }

                    // success
                    else {
                        $el.trigger('reset');
                        $alert.html(response.message);
                        $alert.addClass('alert-success').fadeIn(500);
                    }

                    // reset button
                    $submit.button('reset');
                },
            })
        });
    });

    $(window).on('load', function () {

        $('#preloader').fadeOut(1000, function () {
            $('body').addClass('preloader-done');
            resizeVideoBackground();
        });

    });

})(jQuery);