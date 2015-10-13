'use strict';

/**
 * @author hirootkit <admiralexo@gmail.com>
 */
var Docs = function () {

    var Body    = $('body');
    var popover = $("[data-toggle=popover]");

    // Form related Functions
    var runCore = function () {

        // Hover function for expanding large highlight trays
        // that are marked with the "highlight-hover" class
        function highlightCheck() {
            if ($('html.template-page').length) {return;}
            $('div.highlight').each(function () {
                var This = $(this);
                if (This.hasClass('force-height')) { return;}
                var Selector = This.children('pre');
                if (Selector.height() > 185) {
                    This.addClass('highlight-hover');
                    Selector.css('height', '175');
                }
            });
        }

        highlightCheck();
        // Trigger highlight check on tab change.
        $('li.list-group-item a[data-toggle]').on('click', function () {
            setTimeout(function () {
                highlightCheck();
            }, 200);
        });
        // Slide content functionality for template pages
        if ($('html').hasClass('template-page')) {
            $('#template-code').on('click', function () {
                Body.addClass('offscreen-active');
            });
            $('#template-return').on('click', function () {
                Body.removeClass('offscreen-active');
            });
        }
        // Init Bootstrap Popovers, if present
        if (popover.length) {
            popover.popover();
        }
        // Clear popovers after timeout
        var timer;
        popover.on('click', function () {
            clearTimeout(timer);
            timer = setTimeout(function () { popover.popover('hide') }, 3000)
        });

        // Toggle left sidebar functionality
        var toggleInput = $('#left-col-toggle');
        toggleInput.on('click', function () {
            if ($('body.left-col-hidden').length) {
                $('body').removeClass('left-col-hidden');
            } else {
                $('body').addClass('left-col-hidden');
            }
        });
        // list-group-accordion functionality
        var listAccordion = $('.list-group-accordion');
        var accordionItems = listAccordion.find('.list-group-item');
        var accordionLink = listAccordion.find('.sign-toggle');
        accordionLink.on('click', function () {
            var This = $(this);
            var Parent = This.parent('.list-group-item');
            if (Parent.hasClass('active')) {
                Parent.toggleClass('active');
            } else {
                accordionItems.removeClass('active');
                Parent.addClass('active');
            }
        });
        // Mobile catch for hiding the left sidebar
        if ($(window).width() < 940) {
            $('body').addClass('left-col-hidden');
        } else {
            $('body').removeClass('left-col-hidden');
        }
        var scrollBtn = $('.scrollup');
        // on scoll toggle scrollTop in/out
        $(window).scroll(function () {
            if ($('body').hasClass('scrolling')) {return;}
            if ($(this).scrollTop() > 300) {
                scrollBtn.fadeIn();
            } else {
                scrollBtn.fadeOut();
            }
        });
        // on button click scrollTop
        $('.scrollup, .return-top').on('click', function (e) {
            e.preventDefault();
            scrollReset();
        });
        // if link item clicked scrollTop
        $('#nav-spy').find('li a').on('click', function () {
            if ($(this).hasClass('sign-toggle')) { return; }
            if ($(window).scrollTop() > 170) {
                scrollReset();
            }
        });
        // scrollTop function
        function scrollReset() {
            scrollBtn.fadeOut();
            $("html, body").addClass('scrolling').animate({
                scrollTop: 0
            }, 320, function () {
                $("html, body").removeClass('scrolling')
            });
            return false;
        }
    };

    return {
        init: function (options) {
            runCore(options);
        }
    }
}();