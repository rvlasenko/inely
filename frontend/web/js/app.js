$(document).ready(function () {

    /* =========================
     ScrollReveal
     (on scroll fade animations)
     ============================*/
    var revealConfig = { vFactor: 0.20 };
    window.sr = new scrollReveal(revealConfig);

    /* =========================
     Detect Mobile Device
     ============================*/
    var isMobile = {
        Android:    function () {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function () {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS:        function () {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera:      function () {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows:    function () {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any:        function () {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

    /* ===========================
     jQuery One Page Navigation
     ==============================*/
    $('#main-nav').onePageNav({
        filter: ':not(.external)'
    });

    /* ===========================
     Custom Smooth Scroll For an Anchor
     ==============================*/
    $(function () {
        $('a.scroll-to[href*=#]:not([href=#])').click(function () {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top - 50
                    }, 1000);
                    return false;
                }
            }
        });
    });

    /* ===========================
     Scroll to Top Button
     ==============================*/
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('#to-top').stop().animate({
                bottom: '30px'
            }, 750);
        } else {
            $('#to-top').stop().animate({
                bottom: '-100px'
            }, 750);
        }
    });
    $('#to-top').click(function () {
        $('html, body').stop().animate({
            scrollTop: 0
        }, 750, function () {
            $('#to-top').stop().animate({
                bottom: '-100px'
            }, 750);
        });
    });

    /* =================================
     AjaxChimp JS
     (Integrate subscribe form w/ Mailchimp)
     ====================================*/
    $('.the-subscribe-form').ajaxChimp({
        callback: mailchimpCallback,
        url:      'http://worksofwisnu.us6.list-manage.com/subscribe/post?u=b57b4e6ae38c92ac22d92a234&amp;id=17754c49aa'
        // Replace the URL above with your mailchimp URL (put your URL inside '').
    });
    // callback function when the form submitted, show the notification box
    function mailchimpCallback(resp) {
        if (resp.result === 'success') {
            $('#subscribe-success-notification').addClass('show-up');
        } else if (resp.result === 'error') {
            $('#subscribe-error-notification').addClass('show-up');
        }
    }

    /* =================================
     Add Custom Class to Open Toggle Panel
     ====================================*/
    $('.panel-heading a').click(function () {
        var clickElement = $(this);
        if (clickElement.parents('.panel-heading').is('.panel-active')) {
            $('.panel-heading').removeClass('panel-active');
        } else {
            $('.panel-heading').removeClass('panel-active');
            clickElement.parents('.panel-heading').addClass('panel-active');
        }
    });

    /* ==================================
     Contact Overlay
     (works with multiple buttons)
     =====================================*/
    var triggerBttn = document.querySelectorAll('.contact-trigger');
    var overlay = document.querySelector('div.contact-overlay'),
        closeBttn = overlay.querySelector('a.overlay-close');
    transEndEventNames = {
        'WebkitTransition': 'webkitTransitionEnd',
        'MozTransition':    'transitionend',
        'OTransition':      'oTransitionEnd',
        'msTransition':     'MSTransitionEnd',
        'transition':       'transitionend'
    };
    transEndEventName = transEndEventNames[Modernizr.prefixed('transition')];
    support = { transitions: Modernizr.csstransitions };
    function toggleOverlay() {
        if (classie.has(overlay, 'open')) {
            classie.remove(overlay, 'open');
            classie.add(overlay, 'close');
            $('body').removeClass('overlay-on');
            var onEndTransitionFn = function (ev) {
                if (support.transitions) {
                    if (ev.propertyName !== 'visibility') return;
                    this.removeEventListener(transEndEventName, onEndTransitionFn);
                }
                classie.remove(overlay, 'close');
            };
            if (support.transitions) {
                overlay.addEventListener(transEndEventName, onEndTransitionFn);
            } else {
                onEndTransitionFn();
            }
        } else if (!classie.has(overlay, 'close')) {
            $("body").addClass('overlay-on');
            classie.add(overlay, 'open');
        }
        classie.remove(overlay, 'close');
    }

    var i;
    for (i = 0; i < triggerBttn.length; i++) {
        triggerBttn[i].addEventListener('click', toggleOverlay);
    }
    closeBttn.addEventListener('click', toggleOverlay);

    /* ==================================
     Contact Form Validation
     =====================================*/
    $('#submit').click(function (e) {

        // Stop form submission & check the validation
        e.preventDefault();
        // Variable declaration
        var error = false;
        var fname = $('#fname').val();
        var email = $('#email').val();
        var subject = $('#subject').val();
        var message = $('#message').val();
        // Form field validation
        if (fname.length == 0) {
            var error = true;
            $('#fname').parent('div').addClass('field-error');
        } else {
            $('#fname').parent('div').removeClass('field-error');
        }
        if (email.length == 0 || email.indexOf('@') == '-1') {
            var error = true;
            $('#email').parent('div').addClass('field-error');
        } else {
            $('#email').parent('div').removeClass('field-error');
        }
        if (subject.length == 0) {
            var error = true;
            $('#subject').parent('div').addClass('field-error');
        } else {
            $('#subject').parent('div').removeClass('field-error');
        }
        if (message.length == 0) {
            var error = true;
            $('#message').parent('div').addClass('field-error');
        } else {
            $('#message').parent('div').removeClass('field-error');
        }
        if (error == true) {
            $('#error-notification').addClass('show-up');
        } else {
            $('#error-notification').removeClass('show-up');
        }
        if (error == false) {
            $.post("contact.php", $("#contact-form").serialize(), function (result) {
                if (result == 'sent') {
                    $('#success-notification').addClass('show-up');
                    $('.submit-btn').addClass('disabled');
                }
            });
        }
    });

    // Function to close the Notification
    $('a.notification-close').click(function () {
        $(this).parent('div').fadeOut(200);
    });

    /* ==========================
     Custom Popover
     (for Language Selection)
     =============================*/
    $("[data-toggle=popover]").popover();
});