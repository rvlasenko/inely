jQuery(window).load(function () {
    jQuery(".status").fadeOut();
    jQuery(".preloader").delay(200).fadeOut("slow");
});
(function ($) {
    'use strict';
    $('.flexslider').flexslider({animation: "slide", directionNav: true, controlNav: true, slideShow: true});
    $('.imac-device').flexslider({
        animation: "slide",
        directionNav: false,
        controlNav: false,
        slideShow: true,
        pausePlay: true,
        mouseWheel: true
    });
})(jQuery);
function showModal(url) {
    $.get(url, function (html) {
        $('.modal-body').html(html);
        $('myModal').modal('show', {backdrop: 'static'});
    });
}
function popUpWindow(url, title, w, h) {
    var left = (screen.width / 2) - (w / 2);
    var top = (screen.height / 2) - (h / 2);
    return window.open(url, title, 'toolbar=no, location=no, ' + 'resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
}
if (matchMedia('(max-width: 480px)').matches) {
    $('.main-navigation a').on('click', function () {
        $(".navbar-toggle").click();
    });
}
$(document).ready(function () {
    mainNav();
});
$(window).scroll(function () {
    mainNav();
});
if (matchMedia('(min-width: 992px), (max-width: 767px)').matches) {
    function mainNav() {
        var top = (document.documentElement && document.documentElement.scrollTop) || document.body.scrollTop;
        if (top > 40)$('.sticky-navigation').stop().animate({"top": '0'}); else $('.sticky-navigation').stop().animate({"top": '-60'});
    }
}
if (matchMedia('(min-width: 768px) and (max-width: 991px)').matches) {
    function mainNav() {
        var top = (document.documentElement && document.documentElement.scrollTop) || document.body.scrollTop;
        if (top > 40)$('.sticky-navigation').stop().animate({"top": '0'}); else $('.sticky-navigation').stop().animate({"top": '-120'});
    }
}
function alturaMaxima() {
    var altura = $(window).height();
    $(".full-screen").css('min-height', altura);
}
$(document).ready(function () {
    alturaMaxima();
    $(window).bind('resize', alturaMaxima);
});
var scrollAnimationTime = 1200, scrollAnimation = 'easeInOutExpo';
$('a.scrollto').bind('click.smoothscroll', function (event) {
    event.preventDefault();
    var target = this.hash;
    $('html, body').stop().animate({'scrollTop': $(target).offset().top}, scrollAnimationTime, scrollAnimation, function () {
        window.location.hash = target;
    });
});
wow = new WOW({mobile: false});
wow.init();
$('.expand-form').simpleexpand({'defaultTarget': '.expanded-contact-form'});
$(window).stellar({horizontalScrolling: false});
if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
    var msViewportStyle = document.createElement('style');
    msViewportStyle.appendChild(document.createTextNode('@-ms-viewport{width:auto!important}'));
    document.querySelector('head').appendChild(msViewportStyle)
}