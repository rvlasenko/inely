'use strict';

/**
 * @author hirootkit <admiralexo@gmail.com>
 */
var Core = function () {

    var Body      = $("body"),
        $formAdd  = $("#formAdd"),
        $formEdit = $("#formEdit"),
        tree      = $("#tree"), // Указатель на jsTree
        projTree  = $("#projTree"),
        format    = null, // Форматирование при __task или --task
        date      = null,
        priority  = null, // Приоритет при !1task, !2task...
        projName  = null, // Название проекта
        projKey   = null; // PK проекта

    Pace.options = { ajax: false };

    // SideMenu Functions
    var runSideMenu = function() {

        // Sidebar state naming conventions:
        // "sb-l-o" - SideBar Left Open
        // "sb-l-c" - SideBar Left Closed
        // "sb-l-m" - SideBar Left Minified
        // Same naming convention applies to right sidebar

        // SideBar Left Toggle Function
        var sidebarLeftToggle = function() {

            // We check to see if the the user has closed the entire
            // leftside menu. If true we reopen it, this will result
            // in the menu resetting itself back to a minified state.
            // A second click will fully expand the menu.
            if (Body.hasClass('sb-l-c') && 'sb-l-m' === "sb-l-m") {
                Body.removeClass('sb-l-c');
            }

            // Toggle sidebar state(open/close)
            Body.toggleClass('sb-l-m');
            triggerResize();
        };

        // Sidebar Left Collapse Entire Menu event
        $('.sidebar-toggle-mini').on('click', function(e) {
            e.preventDefault();

            // Close Menu
            Body.addClass('sb-l-c');
            triggerResize();

            // After animation has occured we toggle the menu.
            // Upon the menu reopening the classes will be toggled
            // again, effectively restoring the menus state prior
            // to being hidden
            if (!Body.hasClass('mobile-view')) {
                setTimeout(function() {
                    Body.toggleClass('sb-l-m sb-l-o');
                }, 250);
            }
        });

        // SideBar Right Toggle Function
        var sidebarRightToggle = function() {

            // toggle sidebar state(open/close)
            if (!Body.hasClass('mobile-view') && Body.hasClass('sb-r-o')) {
                Body.toggleClass('sb-r-o sb-r-c');
            }
            else {
                Body.toggleClass('sb-r-o sb-r-c');
            }

            setTimeout(function () {
                if (!Body.hasClass("sb-r-o")) {
                    localStorage.setItem("inspect", "hide");
                } else {
                    localStorage.setItem("inspect", "show");
                    Body.removeClass("sb-r-c").addClass("sb-r-o");
                }
            }, 100);
            triggerResize();
        };

        // Check window size on load
        // Adds or removes "mobile-view" class based on window size
        var sbOnLoadCheck = function() {

            if (Body.hasClass('sb-l-m')) { Body.addClass('sb-l-disable-animation'); }
            else { Body.removeClass('sb-l-disable-animation'); }

            // If window is < 1080px wide collapse both sidebars and add ".mobile-view" class
            if ($(window).width() < 1080) {
                Body.removeClass('sb-r-o').addClass('mobile-view sb-l-m sb-r-c');
            }

            resizeBody();
        };


        // Check window size on resize
        // Adds or removes "mobile-view" class based on window size
        var sbOnResize = function() {

            // If window is < 1080px wide collapse both sidebars and add ".mobile-view" class
            if ($(window).width() < 1080 && !Body.hasClass('mobile-view')) {
                Body.removeClass('sb-r-o').addClass('mobile-view sb-l-m sb-r-c');
            } else if ($(window).width() > 1080) {
                Body.removeClass('mobile-view');
            } else {
                return;
            }

            resizeBody();
        };

        // Function to set the min-height of content
        // to that of the body height. Ensures trays
        // and content bgs span to the bottom of the page
        var resizeBody = function() {

            var sidebarH = $('#sidebar_left').outerHeight();

            Body.css('min-height', sidebarH);
        };

        // Most CSS menu animations are set to 300ms. After this time
        // we trigger a single global window resize to help catch any 3rd
        // party plugins which need the event to resize their given elements
        var triggerResize = function() {
            setTimeout(function() {
                $(window).trigger('resize');

                if (Body.hasClass('sb-l-m')) {
                    Body.addClass('sb-l-disable-animation');
                } else {
                    Body.removeClass('sb-l-disable-animation');
                }
            }, 300)
        };

        // Functions Calls
        sbOnLoadCheck();
        $("#toggle_sidemenu_l").on('click', sidebarLeftToggle);
        $("#toggle_sidemenu_r").on('click', sidebarRightToggle);

        // Attach debounced resize handler
        var rescale    = function() { sbOnResize() };
        var lazyLayout = _.debounce(rescale, 300);
        $(window).resize(lazyLayout);

        // LEFT MENU LINKS TOGGLE
        $('.sidebar-menu li a.accordion-toggle').on('click', function(e) {
            e.preventDefault();

            // If the clicked menu item is minified and is a submenu (has sub-nav parent) we do nothing
            if ($('body').hasClass('sb-l-m') && !$(this).parents('ul.sub-nav').length) { return; }

            // If the clicked menu item is a dropdown we open its menu
            if (!$(this).parents('ul.sub-nav').length) {

                // If sidebar menu is set to Horizontal mode we return
                // as the menu operates using pure CSS
                if ($(window).width() > 900) {
                    if ($('body.sb-top').length) { return; }
                }

                $('a.accordion-toggle.menu-open').next('ul').slideUp('fast', 'swing', function() {
                    $(this).attr('style', '').prev().removeClass('menu-open');
                });
            }
            // If the clicked menu item is a dropdown inside of a dropdown (sublevel menu)
            // we only close menu items which are not a child of the uppermost top level menu
            else {
                var activeMenu = $(this).next('ul.sub-nav');
                var siblingMenu = $(this).parent().siblings('li').children('a.accordion-toggle.menu-open').next('ul.sub-nav');

                activeMenu.slideUp('fast', 'swing', function() {
                    $(this).attr('style', '').prev().removeClass('menu-open');
                });
                siblingMenu.slideUp('fast', 'swing', function() {
                    $(this).attr('style', '').prev().removeClass('menu-open');
                });
            }

            // Now we expand targeted menu item, add the ".open-menu" class
            // and remove any left over inline jQuery animation styles
            if (!$(this).hasClass('menu-open')) {
                $(this).next('ul').slideToggle('fast', 'swing', function() {
                    $(this).attr('style', '').prev().toggleClass('menu-open');
                });
            }

        });
    };

    var runTaskPage = function () {
        var to        = null,
            accept    = false,
            isClicked = false,
            searchInp = $('#searchText');

        var options = {
            "core":        {
                "data": {
                    "type": "POST",
                    "url":  "/task/node",
                    "data": function (node) {
                        return {
                            "id":    node.id,
                            "_csrf": $('meta[name=csrf-token]').attr("content")
                        };
                    }
                },
                "check_callback" : true,
                "multiple":       false,
                "animation":      false,
                "themes":         {
                    name:       "proton",
                    url:        "vendor/plugins/jstree/themes/proton/style.css",
                    responsive: true
                }
            },
            "checkbox":    {
                "three_state": false
            },
            "search":      {
                "show_only_matches": true
            },
            "contextmenu": {
                "select_node": false,
                "items":       function (node) {
                    return {
                        "Create":      {
                            "icon":   "fa fa-leaf",
                            "label":  "Add task",
                            "action": function () { createNode() }
                        },
                        "SetPriority": {
                            "icon":    "fa fa-flag",
                            "label":   "Priority",
                            "action":  false,
                            "submenu": {
                                "high":   {
                                    "icon":   "fa fa-circle",
                                    "label":  "High",
                                    "action": function (data) {
                                        var node = getInstance(data);
                                        $.post("/task/set-priority", {
                                            "id": node.id,
                                            "pr": 3
                                        }).done(function () {
                                            $("#" + node.id).children("a").addClass("high").removeClass("low medium");
                                        }).fail(function () {
                                            data.instance.refresh();
                                        });
                                    }
                                },
                                "medium": {
                                    "icon":   "fa fa-circle",
                                    "label":  "Medium",
                                    "action": function (data) {
                                        var node = getInstance(data);
                                        $.post("/task/set-priority", {
                                            "id": node.id,
                                            "pr": 2
                                        }).done(function () {
                                            $("#" + node.id).children("a").addClass("medium").removeClass("high low");
                                        }).fail(function () {
                                            data.instance.refresh();
                                        });
                                    }
                                },
                                "low":    {
                                    "icon":   "fa fa-circle",
                                    "label":  "Low",
                                    "action": function (data) {
                                        var node = getInstance(data);
                                        $.post("/task/set-priority", {
                                            "id": node.id,
                                            "pr": 1
                                        }).done(function () {
                                            $("#" + node.id).children("a").addClass("low").removeClass("high medium");
                                        }).fail(function () {
                                            data.instance.refresh();
                                        });
                                    }
                                },
                                "none":   {
                                    "icon":   "fa fa-circle-o",
                                    "label":  "None",
                                    "action": function (data) {
                                        var node = getInstance(data);
                                        $.post("/task/set-priority", {
                                            "id": node.id,
                                            "pr": null
                                        }).done(function () {
                                            $("#" + node.id).children("a").removeClass("high medium low");
                                        }).fail(function () {
                                            data.instance.refresh();
                                        });
                                    }
                                }
                            }
                        },
                        "Move":        {
                            "icon":    "fa fa-clock-o",
                            "label":   "Move",
                            "action":  false,
                            "submenu": {
                                "today":    {
                                    "icon":   "fa fa-calendar-o",
                                    "label":  "Today",
                                    "action": function (data) {
                                        var node = getInstance(data);
                                        $.post("/task/set-priority", {
                                            "id": node.id,
                                            "pr": "high"
                                        }).done(function () {
                                            $("#" + node.id).children("a").addClass("high");
                                        }).fail(function () {
                                            data.instance.refresh();
                                        });
                                    }
                                },
                                "tomorrow": {
                                    "icon":   "fa fa-mail-forward",
                                    "label":  "Tomorrow",
                                    "action": function (data) {
                                        var node = getInstance(data);
                                        $.post("/task/set-priority", {
                                            "id": node.id,
                                            "pr": "medium"
                                        }).done(function () {
                                            $("#" + node.id).children("a").addClass("medium");
                                        }).fail(function () {
                                            data.instance.refresh();
                                        });
                                    }
                                },
                                "more":     {
                                    "icon":   "fa fa-ellipsis-h",
                                    "label":  "More",
                                    "action": function (data) {
                                        var node = getInstance(data);
                                        $.post("/task/set-priority", {
                                            'id': node.id,
                                            'pr': 'low'
                                        }).done(function () {
                                            $("#" + node.id).children('a').addClass('low');
                                        }).fail(function () {
                                            data.instance.refresh();
                                        });
                                    }
                                }
                            }
                        },
                        "Remove":      {
                            "separator_before": true,
                            "icon":             "fa fa-trash-o",
                            "label":            "Delete task",
                            "action":           function () {
                                tree.jstree(true).delete_node(node);
                                hideRoot();
                            }
                        }
                    };
                }
            },
            'plugins': ['dnd', 'contextmenu', 'search', 'checkbox']
        };

        var optionsProject = {
            "core":        {
                "data": {
                    "url":   "/task-project/node",
                    "data":  function (node) {
                        return { "id": node.id };
                    }
                },
                "check_callback" : true,
                "multiple":       false,
                "animation":      false,
                "themes":         {
                    name:       "neutron",
                    url:        "vendor/plugins/jstree/themes/neutron/style.css",
                    responsive: true
                }
            },
            "checkbox":    { "three_state": false },
            "contextmenu": {
                "select_node": false,
                "items":       function (node) {
                    return {
                        "Create":      {
                            "icon":   "fa fa-leaf",
                            "label":  "Add task",
                            "action": function () { createNode() }
                        },
                        "Remove":      {
                            "separator_before": true,
                            "icon":             "fa fa-trash-o",
                            "label":            "Delete task",
                            "action":           function () {
                                tree.jstree(true).delete_node(node);
                                hideRoot();
                            }
                        }
                    };
                }
            },
            'plugins': ['dnd', 'contextmenu', 'checkbox', 'state']
        };

        tree.jstree(
            options
        ).on('create_node.jstree', function (e, data) {
            if (data.node.text !== '' && data.node.text != 'New node') {
                $.post('/task/create', {
                    'id':   data.node.parent,
                    'name': data.node.text,
                    'pos':  data.position,
                    'ls':   projKey,
                    'pr':   priority,
                    'fr':   format,
                    'dt':   date
                }).done(function (d) {
                    data.instance.set_id(data.node, d.id);
                    priority = null;
                    date     = null;
                }).fail(function () {
                    data.instance.refresh();
                });

                hideRoot();
            }
                hideRoot();
        }).on('delete_node.jstree', function (e, data) {
            $.post('/task/delete', {
                'id': data.node.id
            }).done(function () {
                setCount(true)
            }).fail(function () {
                data.instance.refresh()
            });
        }).on('rename_node.jstree', function (e, data) {
            $.post('/task/rename', {
                'id':   data.node.id,
                'text': data.text,
                'pr':   priority,
                'fr':   format,
                'dt':   date
            }).fail(function () {
                data.instance.refresh();
            });
        }).on('move_node.jstree', function (e, data) {
            $.post('/task/move', {
                'id':       data.node.id,
                'parent':   data.parent,
                'position': data.position
            }).fail(function () {
                data.instance.refresh();
            });
        }).on('select_node.jstree', function (node, data) {
            // Результирующий узел, на котором был нажат чекбокс
            var $node = $('#' + data.node.id);
            if ($(event.target).is('i')) {
                tree.jstree(true).uncheck_node(data.node.id);
                // Поиск нажатого чекбокса и добавление svg галочки
                $('.svgBox').appendTo($node.find('.jstree-checkbox')).show();
                setTimeout(function () {
                    $node.removeClass('jstree-selected').addClass('jstree-checked').fadeOut(100);
                }, 200);
                $.post('/task/done', {
                    'id':     data.node.id,
                    'isDone': 1,
                    '_csrf':  $('meta[name=csrf-token]').attr("content")
                }).fail(function () {
                    data.instance.refresh();
                });
            }
        }).on("redraw.jstree", function () {
            tree.jstree("open_all");
            hideRoot();
        });

        /*projTree.jstree(
            optionsProject
        ).on("redraw.jstree", function () {
            projTree.jstree("open_all");
            hideRoot();
        }).on('select_node.jstree', function (e, data) {
            projKey = data.node.id;
            // Перестроение дерева перед загрузкой проектов
            tree.jstree(true).settings.core.data = {
                url:  '/task/node',
                data: function (node) {
                    return { id: node.id, ls: data.node.id };
                }
            };
            tree.jstree(true).refresh();

            $('.crumb-active a').html(data.node.text);
            $('.breadcrumb .crumb-link').each(function () {
                $(this).remove();
                $('.breadcrumb').append('<li class="crumb-link">Проекты</li>');
            });
            $("#inbox").removeClass("fw600 bg-white");
            projTree.find("ul li .jstree-children").each(function () {
                $(this).children().removeClass("bg-light fw600");
            });
            $(this).find("#" + data.node.id).addClass("bg-light fw600");

            return false;
        });*/

        searchInp.keyup(function (e) {
            if (to) { clearTimeout(to) }
            to = setTimeout(function () {
                var v = searchInp.val();
                $('#tree').jstree(true).search(v);
            }, 250);
            if (e.keyCode == 27) { $('#inbox').focus() }
        });

        // Применение набора языковых правил для календаря
        $.datepicker.setDefaults($.datepicker.regional["ru"]);
        $("#eventDate, #editEvent").datepicker({
            numberOfMonths:  1,
            minDate:         0,
            prevText:        '<i class="fa fa-chevron-left"></i>',
            nextText:        '<i class="fa fa-chevron-right"></i>',
            showButtonPanel: false,
            dateFormat:      'd M',
            onSelect: function(dateText, inst) {
                date = inst.selectedYear + '-' + inst.selectedMonth + 1 + '-' + inst.selectedDay;
                $("#editEvent").length ? $("#editEvent").focus() : $("#eventDate").focus();
            }
        });

        if ($('.h1200').length) {
            $(window).load(function () {
                $('.h1200').css({ 'height': ($(window).height() + 600) + 'px' });
            });
            $(window).resize(function () {
                $('.h1200').css({ 'height': ($(window).height() + 600) + 'px' });
            });
        }

        var sortByCondition = function (cond) {
            tree.jstree(true).settings.core.data = {
                url:  "/task/node",
                data: function (node) {
                    return { id: node.id, sr: cond, ls: projKey }
                }
            };
            tree.jstree(true).refresh();
        };

        // Инкремент или декремент количества задач в той группе, где она была создана
        var setCount = function (decrement) {
            var $projectDiv = $(".list-view div").filter("[data-key=" + projKey + "]").find("span:last"),
                inboxDiv   = $("#inbox").find("span"),
                number     = 0;
                accept = true;

            // Если переменная с ключом пуста, значит пользователь в "Inbox"
            if (projKey == null) {
                number = parseInt(inboxDiv.text());
                decrement ? inboxDiv.html(--number) : inboxDiv.html(++number);
            } else {
                number = parseInt($projectDiv.text());
                decrement ? $projectDiv.html(--number) : $projectDiv.html(++number);
            }
            // Исключить все дублированные реквесты, которыми любит мусорить jsTree
            setTimeout(function () { accept = false }, 100)
        };

        // Редактирование задачи и вызов события rename_node
        function renameNode (node) {
            // Полезные DOM элементы исходя из полученной задачи
            var $nodeObject = tree.find("li#" + node.id),
                $nodeIcon   = $nodeObject.find("i.jstree-ocl"),
                $nodeAnchor = $nodeObject.find("a.jstree-anchor"),
                $renameInp  = $("#editInput");

            var showAnchor    = function () { $nodeIcon.show(); $nodeAnchor.show() };
            var closureRename = function () {
                if ($renameInp.val() != 0) {
                    tree.jstree(true).rename_node(node, {
                        text: document.getElementById("editInput").value,
                        fr:   getShortcut('format', document.getElementById("editInput").value),
                        pr:   getShortcut('priority', document.getElementById("editInput").value),
                        dt:   date
                    });
                    $renameInp.val('');
                }
            };

            // Становится видна форма и курсор фокусируется внутри input
            $formEdit.prependTo($nodeObject).css({"margin-left": 0}).show().find($("#editInput")).focus();
            // jsTree не дает напрямую изменять свойства якорей, исправляется это просто
            $nodeIcon.hide(); $nodeAnchor.hide(); $formAdd.hide();
            // Текст помещается внутрь поле ввода
            $renameInp.val($("li#" + node.id).find("a span:first").text());
            $("#editEvent, #editInput").on("keyup", function (e) {
                // Escape - отмена
                if (e.keyCode == 27) { $formEdit.hide(); showAnchor() }
                // Enter  - добавление
                if (e.keyCode == 13) { closureRename(); showAnchor() }
            });
            $(document).on("click", ".buttonCancelEdit", function () {
                $formEdit.hide(); showAnchor();
            });
            $(document).on("click", ".buttonRename", function () { closureRename() });
        }

        // Добавление задачи & вызов события create_node
        // Перед добавлением, задача переводится в режим редактирования
        function createNode () {
            // Замыкание, инициализирующее создание узла
            var closureAdd = function () {
                // Экземпляр корневого DOM-элемента преобразуется в объект jsTree
                var obj = tree.jstree(true).get_node($("a:contains('Root')")),
                    $rootHasChildren = $("#1").children('.jstree-children').length,
                    $taskInp = $("#taskInput"),
                    $eventInp = $("#eventDate");

                if ($taskInp.val() != 0) {
                    // Дословно: если у корня нет дочерних элементов...
                    if (!$rootHasChildren) {
                        tree.jstree(true).create_node(obj, {
                            text: document.getElementById("taskInput").value,
                            fr: getShortcut('format', $taskInp.val()),
                            pr: getShortcut('priority', $taskInp.val()),
                            dt: date
                        }, "last");
                        $taskInp.val('');
                        $eventInp.val('');
                        tree.jstree(true).settings.core.data = {
                            url:  "/task/node",
                            data: function (node) {
                                return { id: node.id, ls: projKey };
                            }
                        };
                        tree.jstree(true).refresh();
                        if (!accept) { setCount(false) }
                    } else {
                        tree.jstree(true).create_node(obj, {
                            text: document.getElementById("taskInput").value,
                            fr: getShortcut('format', $taskInp.val()),
                            pr: getShortcut('priority', $taskInp.val()),
                            dt: date
                        }, "last");
                        $taskInp.val('');
                        $eventInp.val('');

                        if (!accept) { setCount(false) }
                    }
                }
            };

            // Добавление контейнера редактирования новой задачи в jsTree
            $formEdit.hide(); $formAdd.show();
            setTimeout(function () { $formAdd.find("#taskInput").focus() }, 100);
            $("#eventDate, #taskInput").on("keyup", function (e) {
                // Escape - отмена
                if (e.keyCode == 27) { $formAdd.hide() }
                // Enter  - добавление
                if (e.keyCode == 13) { closureAdd() }
            });
            $(document).on("click", ".buttonCancel", function () { $formAdd.hide() });
            $(document).on("click", ".buttonAdd", function () { closureAdd() });
        }

        // jsTree не способен скрыть необходимый узел. Решается банально
        var hideRoot = function () {
            $("a:contains('Root')").css("display", "none");
            $(".jstree-last .jstree-icon").first().hide();
        };

        // Получение ключевых знаков для быстрого задания формата задачи
        var getShortcut = function (type, text) {
            if (type === 'format') {
                // Если в начале строки содержится '__' значит требуется курсивное начертание
                if (text.substring(0, 2) == '__') {
                    format = 'cursive';
                } else if (text.substring(0, 2) == '--') {
                    format = 'bold';
                } else {
                    format = null;
                }

                return format;
            } else if (type === 'priority') {
                if (text.substring(0, 3) == '!!1') {
                    priority = 3;
                } else if (text.substring(0, 3) == '!!2') {
                    priority = 2;
                } else if (text.substring(0, 3) == '!!3') {
                    priority = 1;
                } else {
                    priority = null;
                }

                return priority;
            }
        };

        var appendData = function () {
            // jsTree построен таким образом, что при переполнении стака реквестов
            // ответ с сервера не дойдёт должным образом. Поэтому необходимо помешать
            // пользователю заядло кликать больше, чем раз в полторы секунды
            if (!isClicked) {
                isClicked = true;
                projKey   = $(this).parent().data("key");
                projName  = $(this).text().trim().slice(0, -2);

                // Перестроение дерева перед загрузкой проектов
                tree.jstree(true).settings.core.data = {
                    url:  '/task/node',
                    data: function (node) {
                        return { id: node.id, ls: projKey };
                    }
                };
                tree.jstree(true).refresh();
                $('.crumb-active a').html(projName);
                $('.tray-left a').removeClass('fw600');
                $(this).toggleClass('fw600 link-color');
                setTimeout(function () { isClicked = false }, 1500);
            }
        };

        // Бинд на клавиши, по нажатию которых сработает событие create_node
        Mousetrap.bind([ 'q', 'й' ], function () { $('a.action').click() });
        Mousetrap.bind([ '/' ], function () {
            setTimeout(function () { searchInp.focus() }, 100)
        });
        $('a.action').click(function () { createNode(); return false });
        $('.list-tabs').css('display', 'block');

        // Загрузка Inbox задач из [[actionNode()]]
        $('#inbox').click(function () {
            appendData.apply(this);
            $(this).addClass("bg-white");
            // Поиск и удаление недействительных хлебных крошек
            $('.breadcrumb .crumb-link').each(function () {
                $(this).remove();
                $('.breadcrumb').append('<li class="crumb-link">Обзор</li>');
            });
            // Поиск и удаление #fff с уже не активных проектов
            projTree.find("ul li .jstree-children").each(function () {
                $(this).children().removeClass("bg-light fw600");
            });

            return false;
        });

        // Сортировка по условию
        $("#pr").click(function () { sortByCondition('priority') });
        $("#nm").click(function () { sortByCondition('name') });
        $("#dt").click(function () { sortByCondition('dueDate') });

        // Скрыт или показан инспектор
        if (localStorage.getItem("inspect") == "show") {
            Body.removeClass("sb-r-c").addClass("sb-r-o");
        }

        function getInstance(data) {
            return $.jstree.reference(data.reference).get_node(data.reference);
        }
    };

    $(document).ready(function () {
        if ($("body.task-page").length) {
            runTaskPage();
            runSideMenu();
        }
    });
}();