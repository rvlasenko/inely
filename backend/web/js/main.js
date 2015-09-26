'use strict';
/*
 * Core theme functions required for
 * most of the themes vital functionality
 */
var Core = function () {

    // Variables
    var Body = $('body');
    var listName = 'Inbox';
    // ID of the jsTree div container
    var tree = $("#tree");
    var parent;
    // jsTree object
    var $root;
    // Clear local storage
    $("#clearLocalStorage").on('click', function () {
        localStorage.clear();
        location.reload();
    });
    // Configure nprogress loader
    NProgress.configure({
        minimum:      0.15,
        trickleRate:  .07,
        trickleSpeed: 360,
        showSpinner:  false,
        barColor:     'firebrick',
        barPos:       'npr-top'
    });
    NProgress.start();
    setTimeout(function () {
        NProgress.done();
        $('.fade').removeClass('out');
    }, 800);
    var runTaskPage = function () {

        // Setting the JSTree. Before start, check for the existence
        if (tree.length) {
            $root = tree.jstree({
                'core':        {
                    'data':           {
                        'url':  'task/node',
                        'data': function (node) {
                            return { 'id': node.id };
                        }
                    },
                    'check_callback': true,
                    'multiple':       false,
                    'themes':         {
                        name:       'proton',
                        url:        'vendor/plugins/jstree/themes/proton/style.css',
                        responsive: true
                    }
                },
                'checkbox':    {
                    'three_state': false,
                    'cascade':     'down'
                },
                'search':      {
                    "show_only_matches": true
                },
                "contextmenu": {
                    'select_node': false,
                    "items":       function ($node) {
                        return {
                            "Create":      {
                                "separator_before": false,
                                "separator_after":  false,
                                "icon":             "fa fa-leaf",
                                "label":            "Add task here",
                                "action":           function (data) {
                                    var inst = $.jstree.reference(data.reference), obj = inst.get_node(data.reference);
                                    inst.create_node(obj, { type: "default" }, "last", function (new_node) {
                                        setTimeout(function () { inst.edit(new_node); }, 0);
                                    });
                                }
                            },
                            "Rename":      {
                                "separator_before": false,
                                "separator_after":  false,
                                "icon":             "fa fa-i-cursor",
                                "label":            "Rename task",
                                "action":           function () {
                                    $root.jstree(true).edit($node);
                                }
                            },
                            "Remove":      {
                                "separator_before": false,
                                "separator_after":  true,
                                "icon":             "fa fa-trash-o",
                                "label":            "Delete task",
                                "action":           function () {
                                    $root.jstree(true).delete_node($node);
                                    $("a:contains('Root')").css("display", "none");
                                    $(".jstree-last .jstree-icon").first().hide();
                                }
                            },
                            "SetPriority": {
                                "separator_before": false,
                                "separator_after":  false,
                                "icon":             "fa fa-clone",
                                "label":            "Priority",
                                "action":           false,
                                "submenu":          {
                                    "high":   {
                                        "separator_before": false,
                                        "separator_after":  false,
                                        "icon":             "fa fa-circle",
                                        "label":            "High",
                                        "action":           function (data) {
                                            var inst = $.jstree.reference(data.reference), obj = inst.get_node(data.reference);
                                            if (inst.is_selected(obj)) {
                                                inst.cut(inst.get_top_selected());
                                            } else {
                                                inst.cut(obj);
                                            }
                                        }
                                    },
                                    "medium": {
                                        "separator_before": false,
                                        "icon":             "fa fa-circle",
                                        "separator_after":  false,
                                        "label":            "Medium",
                                        "action":           function (data) {
                                            var inst = $.jstree.reference(data.reference), obj = inst.get_node(data.reference);
                                            if (inst.is_selected(obj)) {
                                                inst.copy(inst.get_top_selected());
                                            } else {
                                                inst.copy(obj);
                                            }
                                        }
                                    },
                                    "low":    {
                                        "separator_before": false,
                                        "icon":             "fa fa-circle",
                                        "separator_after":  false,
                                        "label":            "Low",
                                        "action":           function (data) {
                                            var inst = $.jstree.reference(data.reference), obj = inst.get_node(data.reference);
                                            inst.paste(obj);
                                        }
                                    },
                                    "none":   {
                                        "separator_before": false,
                                        "icon":             "fa fa-circle-o",
                                        "separator_after":  false,
                                        "label":            "None",
                                        "action":           function (data) {
                                            var inst = $.jstree.reference(data.reference), obj = inst.get_node(data.reference);
                                            inst.paste(obj);
                                        }
                                    }
                                }
                            }
                        };
                    }
                },
                'force_text':  true,
                'plugins':     [ 'dnd', 'contextmenu', 'search', 'state', 'checkbox' ]
            }).on('create_node.jstree', function (e, data) {
                $.get('task/create', {
                    'id':       data.node.parent,
                    'position': data.position,
                    'text':     data.node.text
                }).done(function (d) {
                    data.instance.set_id(data.node, d.id);
                }).fail(function () {
                    data.instance.refresh();
                });
                // user pressed escape, last node will be deleted
                $(document).on('keyup', function (evt) {
                    if (evt.keyCode == 27) {
                        $.get('task/delete-one', { 'id': data.node.id });
                        data.instance.refresh();
                    }
                });
            }).on('delete_node.jstree', function (e, data) {
                $.get('task/delete', {
                    'id': data.node.id
                }).fail(function () {
                    data.instance.refresh();
                });
            }).on('rename_node.jstree', function (e, data) {
                $.get('task/rename', {
                    'id':   data.node.id,
                    'text': data.text
                }).fail(function () {
                    data.instance.refresh();
                });
            }).on('move_node.jstree', function (e, data) {
                $.get('task/move', {
                    'id':       data.node.id,
                    'parent':   data.parent,
                    'position': data.position
                }).fail(function () {
                    data.instance.refresh();
                });
            }).on('select_node.jstree', function (e, data) {
                if (!$(event.target).is('i')) {
                    $root.jstree(true).uncheck_node(data.node.id);
                }
            }).on('redraw.jstree', function () {
                $("a:contains('Root')").css("display", "none");
                $(".jstree-last .jstree-icon").first().hide();
            }).on('loaded.jstree', function () {
                tree.jstree('open_all');
                parent = $("a:contains('Root')");
            });

            var to = null;
            $('#search_q').keyup(function () {
                if (to) { clearTimeout(to); }
                to = setTimeout(function () {
                    var v = $('#search_q').val();
                    $('#tree').jstree(true).search(v);
                }, 250);
            });
        }
        // On success add to header name of the list
        $(document).ajaxSuccess(function () {
            $('.task-head').html(listName);
        });
        $('.list-tabs').css('display', 'block');

        if ($('.h1200').length) {
            $(window).load(function () { // On load
                $('.h1200').css({ 'height': (($(window).height() + 600)) + 'px' });
            });
            $(window).resize(function () { // On resize
                $('.h1200').css({ 'height': (($(window).height() + 600)) + 'px' });
            });
        }

        $('.user-proj').click(function () {
            var divKey = $(this).parent().data('key');
            listName = $(this).text();
            $.ajax({
                type:    "POST",
                url:     "task/project",
                context: ajaxCont,
                data:    { list: divKey }
            }).done(function (data) {
                $(this).html(data);
            });
            return false;
        });
        $('#inbox').click(function () {
            $.ajax({
                url:     "task/node",
                context: tree
            }).done(function (data) {
                $(this).html(data);
            });
            listName = $(this).text().trim().slice(0, -1);
            return false;
        });

        var add = function () {
            var node = $root.jstree(true).create_node(parent, {
                "text": 'New task'
            }, 'last', null, false);
            $("a:contains('Root')").css("display", "none");
            $(".jstree-last .jstree-icon").first().hide();
            $root.jstree(true).edit(node);
            return false;
        };

        // Node will be create on button "add task" or hotkey
        $('a.action').click(function () { add() });
        Mousetrap.bind([ 'q', 'й' ], function () { setTimeout(function () { add() }, 100) });
    };
    var runDockModal = function () {

        // On button click display quick compose message form
        $('#quick-compose').on('click', function () {
            $('.quick-compose-form').dockmodal({
                minimizedWidth: 260,
                width:          390,
                height:         340,
                title:          'Compose Message',
                initialState:   'docked',
                buttons:        [
                    {
                        html:        'Add',
                        buttonClass: 'btn btn-primary btn-sm',
                        click:       function () {  }
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
        $('.animated-waypoint').each(function () {
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
                handler: function () {
                    if (This.hasClass('animated-waypoint')) {
                        This.removeClass('animated-waypoint').addClass('animated ' + Animation).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                            This.removeClass('animated ' + Animation);
                        });
                    }
                },
                offset:  offsetVal
            });
        });
    };
    // Header Functions
    var runHeader = function () {

        // Searchbar - Mobile modifcations
        $('.navbar-search').on('click', function (e) {
            // alert('hi')
            var This = $(this);
            var searchForm = This.find('input');
            var searchRemove = This.find('.search-remove');
            // Don't do anything unless in mobile mode
            if ($('body.mobile-view').length || $('body.sb-top-mobile').length) {

                // Open search bar and add closing icon if one isn't found
                This.addClass('search-open');
                if (!searchRemove.length) {
                    This.append('<div class="search-remove"></div>');
                }
                // Fadein remove btn and focus search input on animation complete
                setTimeout(function () {
                    This.find('.search-remove').fadeIn();
                    searchForm.focus().one('keydown', function () {
                        $(this).val('');
                    });
                }, 250);
                // If remove icon clicked close search bar
                if ($(e.target).attr('class') == 'search-remove') {
                    This.removeClass('search-open').find('.search-remove').remove();
                }
            }
        });
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
                    roundSkillSize:       roundSkillSize,
                    roundSkillAnimate:    roundSkillAnimate,
                    roundSkillWidth:      roundSkillWidth,
                    roundSkillColor:      roundSkillColor,
                    roundSkillTrackColor: roundSkillTrackColor
                };
                element.easyPieChart({
                    size:       Number(properties.roundSkillSize),
                    animate:    Number(properties.roundSkillAnimate),
                    scaleColor: false,
                    trackColor: properties.roundSkillTrackColor,
                    lineWidth:  Number(properties.roundSkillWidth),
                    lineCap:    'square',
                    barColor:   properties.roundSkillColor
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
                    template:  '<div class="tooltip tooltip-white" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
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
        init: function () {
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