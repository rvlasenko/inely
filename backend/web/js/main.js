"use strict";

var Core = function () {

    var Body      = $("body"),
        formAdd   = $("#formAdd"),
        rootDOM   = $("a:contains('Root')"), // Корневой DOM элемент
        listName  = null,  // Primary key категории (проекта)
        isClicked = false,
        listKey   = null,
        tree      = $("#tree"); // Указатель на jsTree

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
    $("#clearLocalStorage").on('click', function () {
        // Очистка локального хранилища
        localStorage.clear();
        location.reload();
    });

    var runTaskPage = function () {

        if (tree.length) {
            $('ul.panel-tabs li:nth-child(3)').addClass('active');
            $('.list-tabs').css('display', 'block');

            var options = {
                'core':        {
                    'data': {
                        'url':   '/task/node',
                        'cache': true,
                        'data':  function (node) {
                            return { 'id': node.id };
                        }
                    },
                    'check_callback' : true,
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
                                "label":            "Add task",
                                "action":           function () {
                                    createNode();
                                }
                            },
                            "Rename":      {
                                "separator_before": false,
                                "separator_after":  false,
                                "icon":             "fa fa-i-cursor",
                                "label":            "Rename task",
                                "action":           function () {
                                    tree.jstree(true).edit($node);
                                }
                            },
                            "Remove":      {
                                "separator_before": false,
                                "separator_after":  true,
                                "icon":             "fa fa-trash-o",
                                "label":            "Delete task",
                                "action":           function () {
                                    tree.jstree(true).delete_node($node);
                                    hideRoot();
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
                'plugins':     [ 'dnd', 'contextmenu', 'search', 'state', 'checkbox', 'types' ]
            };

            tree.jstree(
                options
            ).on('create_node.jstree', function (e, data) {
                if (data.node.text !== '' && data.node.text != 'New node') {
                    $.get('task/create', {
                        'id':       data.node.parent,
                        'position': data.position,
                        'text':     data.node.text,
                        'list':     listKey
                    }).done(function (d) {
                        data.instance.set_id(data.node, d.id);
                    }).fail(function () {
                        data.instance.refresh();
                    });

                    hideRoot();
                }
                    hideRoot();
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
                if (!$(event.target).is('i') || $(event.target).is('.jstree-themeicon')) {
                    tree.jstree(true).uncheck_node(data.node.id);
                }
            }).on('redraw.jstree', function () {
                tree.jstree('open_all');
                hideRoot();
            }).on('loaded.jstree', function () {
                rootDOM = $("a:contains('Root')");
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

        if ($('.h1200').length) {
            $(window).load(function () {
                $('.h1200').css({ 'height': (($(window).height() + 600)) + 'px' });
            });
            $(window).resize(function () {
                $('.h1200').css({ 'height': (($(window).height() + 600)) + 'px' });
            });
        }

        var createNode = function () {
            // Добавление задачи & вызов события create_node
            // Перед добавлением задача переводится в режим редактирования
            var textField       = $(".inputStandard"),
                rootHasChildren = $("a:contains('Root')").parent('li').children('.jstree-children');

            // Замыкание, инициализирующее создание узла
            var closureAdd = function () {
                // Экземпляр корневого DOM-элемента преобразуется в объект jsTree
                var obj = tree.jstree(true).get_node(rootDOM, true);

                // Хелпер, чтобы избежать дублирование кода при создании
                var helperAdd = function () {
                    tree.jstree(true).create_node(obj, { text: textField.val() }, "last", null, true);
                    textField.val('');
                    tree.jstree(true).settings.core.data = {
                        url:  'task/node',
                        data: function (node) {
                            return { id: node.id, list: listKey };
                        }
                    };
                    tree.jstree(true).refresh();
                };
                if (textField.val() != 0) {
                    // Дословно: если у корня нет дочерних элементов...
                    if (rootHasChildren.length == 0) {
                        helperAdd();
                        rootHasChildren.length = 1;
                    } else {
                        if (rootHasChildren.length == 0) {
                            helperAdd();
                        } else {
                            tree.jstree(true).create_node(obj, { text: textField.val() }, "last", null, true);
                            textField.val('');
                        }
                    }
                }
            };

            // Добавление контейнера редактирования новой задачи в jsTree
            formAdd.appendTo(".jstree-container-ul.jstree-children").show();
            $(document).on("keyup", function (e) {
                // Escape - отмена
                if (e.keyCode == 27) { formAdd.hide() }
                // Enter  - добавление
                if (e.keyCode == 13) { closureAdd() }
            });
            $(document).on("click", ".buttonCancel", function () { formAdd.hide() });
            $(document).on("click", ".buttonAdd", function () { closureAdd() });
        };
        var hideRoot = function () {
            // Скрытие корневого элемента. И ничего больше
            $("a:contains('Root')").css("display", "none");
            $(".jstree-last .jstree-icon").first().hide();
        };
        var reloadInboxAndProject = function () {
            // jsTree построен таким образом, что при переполнении стака реквестов
            // ответ с сервера не дойдёт должным образом. Поэтому необходимо помешать
            // пользователю заядло кликать больше, чем раз в полторы секунды
            if (!isClicked) {
                isClicked = true;
                listKey   = $(this).parent().data("key");
                listName  = $(this).text().trim().slice(0, -2);

                // Перестроение дерева перед загрузкой проектов
                tree.jstree(true).settings.core.data = {
                    url:  'task/node',
                    data: function (node) {
                        return { id: node.id, list: listKey };
                    }
                };
                tree.jstree(true).refresh();
                $('.task-head').html(listName);
                setTimeout(function () { isClicked = false }, 1500);
            }
        };

        // Бинд на клавиши, по нажатию которых сработает событие create_node
        Mousetrap.bind([ 'q', 'й' ], function () { $('a.action').click() });
        $('a.action').click(function () { createNode(); return false });

        // Обновление дерева с новыми данными, где поле list эквивалентно выбранному
        $('.user-project').click(function () {
            reloadInboxAndProject.apply(this);
        });

        // Обновление это банальная загрузка Inbox задач из [[actionNode()]]
        $('#inbox').click(function () {
            reloadInboxAndProject.apply(this);
        });
    };
    var runDockModal = function () {
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
                        click:       function () { }
                    }
                ]
            });
        });
    };
    // jQuery хелперы
    var runHelpers = function () {

        // Отключение селекта
        $.fn.disableSelection = function () {
            return this.attr('unselectable', 'on').css('user-select', 'none').on('selectstart', false);
        };
        // Тест функция для IE, добавление класса if version 9 в тег <body>
        function msieversion() {
            var ua   = window.navigator.userAgent;
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
        // Хелпер очищающий оставшиеся классы в основном контейнере
        setTimeout(function () {
            $('#content').removeClass('animated fadeIn');
        }, 500);
    };
    var runAnimations = function () {

        // Добавление класса после загрузки, чтобы предотвратить css анимацию
        // от размытия страниц, на которых много ресурсов.
        setTimeout(function () {
            $('body').addClass('onload-check');
        }, 100);
        // Атрибут data принимает число в миллисекундах (задержка) и стиль анимации
        // При условии, что была передана только задержка, устанавливается анимация fadeIn
        $('.animated-delay[data-animate]').each(function () {
            var This = $(this);
            var delayTime = This.data('animate');
            var delayAnimation = 'fadeIn';
            // Если атрибут data имеет более одного значения, сбрасываем на умолчания
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