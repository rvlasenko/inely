$(function() {
    "use strict";




    /* ==========================================================================
       Sub Form   
       ========================================================================== */


    $('#mc-form').ajaxChimp({
        callback: callbackFunction,
        url: 'http://csmthemes.us3.list-manage.com/subscribe/post?u=9666c25a337f497687875a388&id=5b881a50fb'
            // http://xxx.xxx.list-manage.com/subscribe/post?u=xxx&id=xxx
    });

    function callbackFunction(resp) {
        if (resp.result === 'success') {
            $('#mc-error').slideUp();
            $('#mc-success').slideDown();
        } else if (resp.result === 'error') {
            $('#mc-success').slideUp();
            $('#mc-error').slideDown();
        }
    }



    /* ==========================================================================
   Tweet
   ========================================================================== */


    $('.tweet').twittie({
        username: 'envatomarket', // change username here
        dateFormat: '%b. %d, %Y',
        template: '{{tweet}} {{user_name}}',
        count: 10
    }, function() {
        var item = $('.tweet ul');

        item.children('li').first().show().siblings().hide();
        setInterval(function() {
            item.find('li:visible').fadeOut(500, function() {
                $(this).appendTo(item);
                item.children('li').first().fadeIn(500);
            });
        }, 8000);
    });




    /* ==========================================================================
   Product statistics counter
   ========================================================================== */


    $('.product-statistics').waypoint(function() {



        $('.counter-1').animateNumber({
            number: 50, //change value here

        }, 2000);

        $('.counter-2').animateNumber({
            number: 70, //change value here

        }, 2000);

        $('.counter-3').animateNumber({
            number: 90, //change value here

        }, 2000);

        $('.counter-4').animateNumber({
            number: 60, //change value here

        }, 2000);

        this.destroy();

    }, {
        offset: '80%'

    });


    /* ==========================================================================
       Navbar button animation
       ========================================================================== */




    var btnCon = $('.navbar-nav #toggle, .mobile-nav a');

    $(btnCon).on("click", function() {




        if ($(btnCon).hasClass('active')) {
            $(btnCon).removeClass('active');
        } else {

            $(btnCon).addClass('active');
        }


        $('#mobile-nav-overlay').toggleClass('open');
    });




    /* ==========================================================================
   litebox
   ========================================================================== */

    $('.video-intro .play-btn, .video-tour .play-btn').magnificPopup({
        type: 'iframe'
    });




    /* ==========================================================================
   Reviews slider
   ========================================================================== */




    $('.reviews-slider').owlCarousel({

        navigation: false,
        slideSpeed: 300,
        paginationSpeed: 400,
        singleItem: true,
        transitionStyle: "fade",
        autoPlay: 7000


    });



    /* ==========================================================================
   Tooltip 
   ========================================================================== */

    $("[data-toggle=tooltip]").tooltip();
		


	 /* ==========================================================================
		 Popover
	 ========================================================================== */
	
	 $('[data-toggle="popover"]').popover({
			 placement: 'auto',
			 trigger: 'hover focus'
	
	 });


    /* ==========================================================================
   Play btn animation
   ========================================================================== */



    $('.video-intro .play-btn i, .video-tour .play-btn i').waypoint(function() {
        $(this.element).addClass('play-btn-animation');


        this.destroy();

    }, {
        offset: '60%'
    });



    /* ==========================================================================
   Team slider
   ========================================================================== */


    var owlTeam = $('.team-slider');

    owlTeam.owlCarousel({

        itemsCustom: [
            [0, 1],
            [450, 1],
            [600, 1],
            [700, 2],
            [1000, 3],
            [1200, 3],
            [1400, 3],
            [1600, 3]
        ],
        navigation: true,
        pagination: false,
        navigationText: [
            "<i class='fa fa-angle-left fa-2x'></i>",
            "<i class='fa fa-angle-right fa-2x'></i>"
        ]

    });




    /* ==========================================================================
   twitter reviews slider
   ========================================================================== */

    var owl = $('.twitter-reviews-slider');

    owl.owlCarousel({

        itemsCustom: [
            [0, 1],
            [450, 1],
            [600, 1],
            [700, 2],
            [1000, 3],
            [1200, 3],
            [1400, 3],
            [1600, 3]
        ],
        navigation: false

    });




    /* ==========================================================================
   Chat button
   ========================================================================== */


    $('.site-footer').waypoint(function() {
        $('.chat-btn').addClass('fixed');

    }, {
        offset: '80%'

    });




    /* ==========================================================================
   Contact form
   ========================================================================== */


    var formFields = $('.contact-form form input, .contact-form form textarea');



    $(formFields).on('focus', function() {
        $(this).removeClass('input-error');
    });
    $('.contact-form form').submit(function(e) {
        e.preventDefault();
        $(formFields).removeClass('input-error');
        var postdata = $('.contact-form form').serialize();
        $.ajax({
            type: 'POST',
            url: 'php/contact.php',
            data: postdata,
            dataType: 'json',
            success: function(json) {

                if (json.nameMessage !== '') {
                    $('.contact-form form .contact-name').addClass('input-error');
                }
                if (json.emailMessage !== '') {
                    $('.contact-form form .contact-email').addClass('input-error');
                }
                if (json.messageMessage !== '') {
                    $('.contact-form form textarea').addClass('input-error');
                }
                if (json.antispamMessage !== '') {
                    $('.contact-form form .contact-antispam').addClass('input-error');
                }
                if (json.nameMessage === '' && json.emailMessage === '' && json.messageMessage === '' && json.antispamMessage === '') {
                    $('.contact-form').fadeOut('3000', "linear", function() {
                        $('.contact-form-success').slideToggle();

                    });
                }
            }
        });
    });




    /* ==========================================================================
   Smooth scroll
   ========================================================================== */


    $('.navbar a, .mobile-nav a, .cta a').on('click', function() {
        if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({

                    scrollTop: (target.offset().top - 80)
                }, 1000);
                return false;
            }
        }
    });




});