'use strict';
/*! main.js - v0.1.1
 * http://admindesigns.com/
 * Copyright (c) 2013 Admin Designs;*/

/* Core theme functions required for
 * most of the themes vital functionality */
var Core = function (options) {

    // Variables
    var Body = $('body');

    // Clear local storage
    $("#clearLocalStorage").on('click', function () {
        localStorage.clear();
        location.reload();
    });

    // jQuery Helper Functions
    var runHelpers = function () {

        // Disable selection
        $.fn.disableSelection = function () {
            return this
                .attr('unselectable', 'on')
                .css('user-select', 'none')
                .on('selectstart', false);
        };

        // Test for IE, Add body class if version 9
        function msieversion() {
            var ua = window.navigator.userAgent;
            var msie = ua.indexOf("MSIE ");
            if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
                var ieVersion = parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)));
                if (ieVersion === 9) {
                    $('body').addClass('no-js ie' + ieVersion);
                }
                return ieVersion;
            }
            else {
                return false;
            }
        }

        msieversion();

        // Clean up helper that removes any leftover
        // animation classes on the primary content container
        // If left it can cause z-index and visibility problems
        setTimeout(function () {
            $('#content').removeClass('animated fadeIn');
        }, 500);

    }

    // Delayed Animations
    var runAnimations = function () {

        // Add a class after load to prevent css animations
        // from bluring pages that have load intensive resources
        setTimeout(function () {
            $('body').addClass('onload-check');
        }, 100);

        // Delayed Animations
        // data attribute accepts delay(in ms) and animation style
        // if only delay is provided fadeIn will be set as default
        // eg. data-animate='["500","fadeIn"]'
        $('.animated-delay[data-animate]').each(function () {
            var This = $(this)
            var delayTime = This.data('animate');
            var delayAnimation = 'fadeIn';

            // if the data attribute has more than 1 value
            // it's an array, reset defaults
            if (delayTime.length > 1 && delayTime.length < 3) {
                delayTime = This.data('animate')[ 0 ];
                delayAnimation = This.data('animate')[ 1 ];
            }

            var delayAnimate = setTimeout(function () {

                This.removeClass('animated-delay').addClass('animated ' + delayAnimation)
                    .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                        This.removeClass('animated ' + delayAnimation);
                    });

            }, delayTime);
        });

        // "In-View" Animations
        // data attribute accepts animation style and offset(in %)
        // eg. data-animate='["fadeIn","40%"]'
        $('.animated-waypoint').each(function (i, e) {
            var This = $(this);
            var Animation = This.data('animate');
            var offsetVal = '35%';

            // if the data attribute has more than 1 value
            // it's an array, reset defaults
            if (Animation.length > 1 && Animation.length < 3) {
                Animation = This.data('animate')[ 0 ];
                offsetVal = This.data('animate')[ 1 ];
            }

            var waypoint = new Waypoint({
                element: This,
                handler: function (direction) {
                    console.log(offsetVal)
                    if (This.hasClass('animated-waypoint')) {
                        This.removeClass('animated-waypoint').addClass('animated ' + Animation)
                            .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                                This.removeClass('animated ' + Animation);
                            });
                    }
                },
                offset : offsetVal
            });
        });

    };

    // Header Functions
    var runHeader = function () {

        // custom animation for header content dropdown
        if ($('.dropdown-item-slide').length) {
            $('.dropdown-item-slide').on('shown.bs.dropdown', function () {
                var This = $(this);
                setTimeout(function () {
                    This.addClass('slide-open');
                }, 20);
            });
            $('.dropdown-item-slide').on('hidden.bs.dropdown', function () {
                $(this).removeClass('slide-open');
            });
        }

        // Init jQuery Multi-Select for navbar user dropdown
        if ($("#user-status").length) {
            $('#user-status').multiselect({
                buttonClass: 'btn btn-default btn-sm',
                buttonWidth: 100,
                dropRight  : false
            });
        }
        if ($("#user-role").length) {
            $('#user-role').multiselect({
                buttonClass: 'btn btn-default btn-sm',
                buttonWidth: 100,
                dropRight  : true
            });
        }

        // Sliding Topbar Metro Menu
        var menu = $('#topbar-dropmenu');
        var items = menu.find('.metro-tile');
        var metroBG = $('.metro-modal');

        // Toggle menu and active class on icon click
        $('#toggle_sidemenu_l').on('click', function () {

            menu.slideToggle(230).toggleClass('topbar-menu-open');
            $(items).addClass('animated animated-short fadeInDown').css('opacity', 1);

            // Create Modal for hover effect
            if (!metroBG.length) {
                metroBG = $('<div class="metro-modal"></div>').appendTo('body');
            }
            setTimeout(function () {
                metroBG.fadeIn();
            }, 380);

        });

        // If modal is clicked close menu
        $('body').on('click', '.metro-modal', function () {
            metroBG.fadeOut('fast');
            setTimeout(function () {
                menu.slideToggle(150).toggleClass('topbar-menu-open');
            }, 250);
        });
    }

    // Tray related Functions
    var runTrays = function () {

        // Match height of tray with the height of body
        var trayMatch = $('.tray[data-tray-height="match"]');
        if (trayMatch.length) {

            // Loop each tray and set height to match body
            trayMatch.each(function () {
                var Height = $('body').height();
                $(this).height(Height);
            });

        }
        ;

        // Debounced resize handler
        var rescale = function () {
            if ($(window).width() < 1000) {
                Body.addClass('tray-rescale');
            }
            else {
                Body.removeClass('tray-rescale tray-rescale-left tray-rescale-right');
            }
        }
        var lazyLayout = _.debounce(rescale, 300);

        if (!Body.hasClass('disable-tray-rescale')) {
            // Rescale on window resize
            $(window).resize(lazyLayout);

            // Rescale on load
            rescale();
        }

    };

    var runroundedSkill = function(){
        var $roundedSkillEl = $('.rounded-skill');
        if( $roundedSkillEl.length > 0 ){
            $roundedSkillEl.each(function(){
                var element = $(this);

                var roundSkillSize = element.attr('data-size');
                var roundSkillAnimate = element.attr('data-animate');
                var roundSkillWidth = element.attr('data-width');
                var roundSkillColor = element.attr('data-color');
                var roundSkillTrackColor = element.attr('data-trackcolor');

                if( !roundSkillSize ) { roundSkillSize = 110; }
                if( !roundSkillAnimate ) { roundSkillAnimate = 2500; }
                if( !roundSkillWidth ) { roundSkillWidth = 3; }
                if( !roundSkillColor ) { roundSkillColor = '#0093BF'; }
                if( !roundSkillTrackColor ) { roundSkillTrackColor = 'rgba(0,0,0,0.04)'; }

                var properties = {roundSkillSize:roundSkillSize, roundSkillAnimate:roundSkillAnimate, roundSkillWidth:roundSkillWidth, roundSkillColor:roundSkillColor, roundSkillTrackColor:roundSkillTrackColor};

                element.easyPieChart({
                    size: Number(properties.roundSkillSize),
                    animate: Number(properties.roundSkillAnimate),
                    scaleColor: false,
                    trackColor: properties.roundSkillTrackColor,
                    lineWidth: Number(properties.roundSkillWidth),
                    lineCap: 'square',
                    barColor: properties.roundSkillColor
                });
            });
        }
    };

    // Form related Functions
    var runFormElements = function () {

        // Init Jquery Sortable, if present
        if ($(".sortable").length) {
            $(".sortable").sortable();
            $(".sortable").disableSelection();
        }

        var Tooltips = $("[data-toggle=tooltip]");

        // Init Bootstrap tooltips, if present
        if (Tooltips.length) {
            if (Tooltips.parents('#sidebar_left')) {
                Tooltips.tooltip({
                    container: $('body'),
                    template : '<div class="tooltip tooltip-white" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
                });
            } else {
                Tooltips.tooltip();
            }
        }

        // Init Bootstrap Popovers, if present
        if ($("[data-toggle=popover]").length) {
            $('[data-toggle=popover]').popover();
        }

        // Init Bootstrap persistent tooltips. This prevents a
        // popup from closing if a checkbox it contains is clicked
        $('.dropdown-menu .dropdown-persist').click(function (event) {
            event.stopPropagation();
        });

        // Prevents a dropdown menu from closing when a navigation
        // menu it contains is clicked (panel/tab menus)
        $('.dropdown-menu .nav-tabs li a').click(function (event) {
            event.preventDefault();
            event.stopPropagation();
            $(this).tab('show')
        });

        // if btn has ".btn-states" class we monitor it for user clicks. On Click we remove
        // the active class from its siblings and give it to the button clicked.
        // This gives the button set a menu like feel or state
        if ($('.btn-states').length) {
            $('.btn-states').click(function () {
                $(this).addClass('active').siblings().removeClass('active');
            });
        }
    }
    return {
        init: function (options) {

            // Set Default Options
            var defaults = {
                sbl: "sb-l-o", // sidebar left open onload

                siblingRope: true
                // Setting this true will reopen the left sidebar
                // when the right sidebar is closed
            };

            // Extend Default Options.
            var options = $.extend({}, defaults, options);

            // Call Core Functions
            runHelpers();
            runroundedSkill();
            runAnimations();
            runTrays();
            runFormElements();
            runHeader();
        }

    }
}();