'use strict';
/*! main.js - v0.1.1
 * http://admindesigns.com/
 */

/* Core theme functions required for
 * most of the themes vital functionality */
var Core = function (options) {

    // Variables
    var Body = $('body');
    var listName = 'Inbox';
    var ajaxCont = $('#taskWrap');

    // Clear local storage
    $("#clearLocalStorage").on('click', function () {
        localStorage.clear();
        location.reload();
    });

    // Configure Progress Loader
    NProgress.configure({
        minimum: 0.15, trickleRate: .07, trickleSpeed: 360, showSpinner: false, barColor: 'firebrick', barPos: 'npr-top'
    });

    NProgress.start();
    setTimeout(function () {
        NProgress.done();
        $('.fade').removeClass('out');
    }, 800);

    function taskCallback() {
        if ($('#task-name').val().length > 0) {
            $('#form-compose').submit();
            setTimeout(function () {
                $('.quick-compose-form').dockmodal("close");
            $.ajax({
                url: "/task/inbox"
            }).done(function (data) {
                ajaxCont.html(data);
            });
            }, 400);
        }
    }

    var runTaskPage = function () {

        $(document).ajaxSuccess(function () {
            $('.task-head').html(listName);
        });

        $(document).ajaxStart(function () {
            NProgress.start();
            setTimeout(function () {
                NProgress.done();
                $('.fade').removeClass('out');
            }, 400);
        });

        $('.list-tabs').css('display', 'block');

        $(document).on('click', 'input[type=checkbox]', function () {
            $(this).parent().parent().parent().toggleClass('highlight');
        });

        $(document).on('click', '.message.undone', function (event) {
            if ($(event.target).is('span')) {
                alert('I only fire when A not clicked!');
            } else {
                var taskCheck = $(this).find('input[type=checkbox]');

                $(this).toggleClass('highlight');
                taskCheck.prop('checked', taskCheck.is(':checked') ? false : true);
            }
        });

        $('.user-proj').click(function () {
            var divKey = $(this).parent().data('key');
            listName = $(this).text();

            $.ajax({
                type: "POST", url: "/task/project", context: ajaxCont, data: { list: divKey }
            }).done(function (data) {
                $(this).html(data);
            });

            return false;
        });

        $('#inbox').click(function () {
            $.ajax({
                url: "/task/inbox", context: ajaxCont
            }).done(function (data) {
                $(this).html(data);
            });

            listName = $(this).text().trim().slice(0, -1);
            return false;
        });
    };

    var runDockModal = function () {

        $('#form-compose').on('keypress', function (e) {
            if (e.keyCode == 13) { taskCallback(); }
        });

        // On button click display quick compose message form
        $('#quick-compose').on('click', function () {
            $('.quick-compose-form').dockmodal({
                minimizedWidth: 260,
                width         : 390,
                height        : 340,
                title         : 'Compose Message',
                initialState  : 'docked',
                buttons       : [
                    {
                        html: 'Add', buttonClass: 'btn btn-primary btn-sm', click: function () { taskCallback(); }
                    }
                ]
            });
        });

        $('#quick-list').on('click', function () {
            $('.quick-list-form').dockmodal({
                height: 200, title: 'Compose Message', initialState: 'docked', buttons: [
                    {
                        html: 'Add', buttonClass: 'btn btn-primary btn-sm', click: function (e, dialog) {
                        dialog.dockmodal('close');

                        setTimeout(function () { msgCallback(); }, 500);
                    }
                    }
                ]
            });
        });
    };

    // jQuery Helper Functions
    var runHelpers = function () {

        // Disable selection
        $.fn.disableSelection = function () {
            return this.attr('unselectable', 'on').css('user-select', 'none').on('selectstart', false);
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
            } else {
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

    };

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
            var This = $(this);
            var delayTime = This.data('animate');
            var delayAnimation = 'fadeIn';

            // if the data attribute has more than 1 value
            // it's an array, reset defaults
            if (delayTime.length > 1 && delayTime.length < 3) {
                delayTime = This.data('animate')[ 0 ];
                delayAnimation = This.data('animate')[ 1 ];
            }

            var delayAnimate = setTimeout(function () {

                This.removeClass('animated-delay').addClass('animated ' + delayAnimation).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
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
                element  : This, handler: function (direction) {
                    if (This.hasClass('animated-waypoint')) {
                        This.removeClass('animated-waypoint').addClass('animated ' + Animation).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                            This.removeClass('animated ' + Animation);
                        });
                    }
                }, offset: offsetVal
            });
        });

    };

    // Header Functions
    var runHeader = function () {

        var dropDown = $('.dropdown-item-slide');
        // custom animation for header content dropdown
        if (dropDown.length) {
            dropDown.on('shown.bs.dropdown', function () {
                var This = $(this);
                setTimeout(function () {
                    This.addClass('slide-open');
                }, 20);
            });
            dropDown.on('hidden.bs.dropdown', function () {
                $(this).removeClass('slide-open');
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
    };

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

        // Debounced resize handler
        var rescale = function () {
            if ($(window).width() < 1000) {
                Body.addClass('tray-rescale');
            } else {
                Body.removeClass('tray-rescale tray-rescale-left tray-rescale-right');
            }
        };
        var lazyLayout = _.debounce(rescale, 300);

        if (!Body.hasClass('disable-tray-rescale')) {
            // Rescale on window resize
            $(window).resize(lazyLayout);

            // Rescale on load
            rescale();
        }

    };

    var runRoundedSkill = function () {
        var $roundedSkillEl = $('.rounded-skill');
        if ($roundedSkillEl.length > 0) {
            $roundedSkillEl.each(function () {
                var element = $(this);

                var roundSkillSize = element.attr('data-size');
                var roundSkillAnimate = element.attr('data-animate');
                var roundSkillWidth = element.attr('data-width');
                var roundSkillColor = element.attr('data-color');
                var roundSkillTrackColor = element.attr('data-trackcolor');

                if (!roundSkillSize) { roundSkillSize = 110; }
                if (!roundSkillAnimate) { roundSkillAnimate = 2500; }
                if (!roundSkillWidth) { roundSkillWidth = 3; }
                if (!roundSkillColor) { roundSkillColor = '#0093BF'; }
                if (!roundSkillTrackColor) { roundSkillTrackColor = 'rgba(0,0,0,0.04)'; }

                var properties = {
                    roundSkillSize      : roundSkillSize,
                    roundSkillAnimate   : roundSkillAnimate,
                    roundSkillWidth     : roundSkillWidth,
                    roundSkillColor     : roundSkillColor,
                    roundSkillTrackColor: roundSkillTrackColor
                };

                element.easyPieChart({
                    size      : Number(properties.roundSkillSize),
                    animate   : Number(properties.roundSkillAnimate),
                    scaleColor: false,
                    trackColor: properties.roundSkillTrackColor,
                    lineWidth : Number(properties.roundSkillWidth),
                    lineCap   : 'square',
                    barColor  : properties.roundSkillColor
                });
            });
        }
    };

    // Form related Functions
    var runFormElements = function () {

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
    };

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
            runTaskPage();
            runDockModal();
            runRoundedSkill();
            runAnimations();
            runTrays();
            runFormElements();
            runHeader();
        }
    }
}();