'use strict';

/**
 * @author hirootkit <admiralexo@gmail.com>
 */
var Core = function () {

    var Body      = $("body"),
        $formAdd   = $("#formAdd"),
        $formEdit  = $("#formEdit"),
        popover   = $("[data-toggle=popover]"),
        tree      = $("#tree"), // Указатель на jsTree
        format    = null,
        date      = null,
        priority  = null,
        listName  = null, // Название категории (проекта)
        listKey   = null; // PK категории (проекта)

    // Переменные, определяющие принадлежность пользователя к странице
    var onDashBoard = $("body.site-page").length,
        onTaskPage  = $("body.task-page").length,
        onHelpPage  = $("body.help-page").length,
        onSchPage   = $("body.schedule-page").length;

    NProgress.configure({
        minimum:      0.15,
        trickleRate:  .07,
        trickleSpeed: 360,
        showSpinner:  false,
        barColor:     "firebrick",
        barPos:       "npr-top"
    });
    NProgress.start();
    setTimeout(function () {
        NProgress.done();
        $(".fade").removeClass("out");
    }, 800);
    $("#clearLocalStorage").on("click", function () {
        // Очистка локального хранилища
        localStorage.clear();
        location.reload();
    });

    var runTaskPage = function () {
        var to        = null,
            accept    = false,
            isClicked = false,
            searchInp = $('#search_q');

        $("ul.panel-tabs li:nth-child(3)").addClass("active");
        function getInstance(data) {
            return $.jstree.reference(data.reference).get_node(data.reference);
        }

        var options = {
            "core":        {
                "data": {
                    "url":   "/task/node",
                    "data":  function (node) {
                        return { "id": node.id };
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
                "three_state": false,
                "cascade":     "down"
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
                        "Rename":      {
                            "separator_after": true,
                            "icon":            "fa fa-i-cursor",
                            "label":           "Edit task",
                            "action":          function () {
                                renameNode(node);
                            }
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
                                        $.get("task/set-priority", {
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
                                        $.get("task/set-priority", {
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
                                        $.get("task/set-priority", {
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
                                        $.get("task/set-priority", {
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
                                        $.get("task/set-priority", {
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
                                        $.get("task/set-priority", {
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
                                        $.get("task/set-priority", {
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
            'plugins': ['dnd', 'contextmenu', 'search', 'state', 'checkbox']
        };

        tree.jstree(
            options
        ).on('create_node.jstree', function (e, data) {
            if (data.node.text !== '' && data.node.text != 'New node') {
                $.get('task/create', {
                    'id':   data.node.parent,
                    'text': data.node.text,
                    'ps':   data.position,
                    'ls':   listKey,
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
            $.get('task/delete', {
                'id': data.node.id
            }).done(function () {
                setCount(true)
            }).fail(function () {
                data.instance.refresh()
            });
        }).on('rename_node.jstree', function (e, data) {
            $.get('task/rename', {
                'id':   data.node.id,
                'text': data.text,
                'pr':   priority,
                'fr':   format,
                'dt':   date
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
        }).on("redraw.jstree", function () {
            tree.jstree("open_all");
            hideRoot();
        });

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
                date = inst.selectedYear + '-' + Math.abs(inst.selectedMonth + 1) + '-' + inst.selectedDay;
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
                url:  "task/node",
                data: function (node) {
                    return { id: node.id, sort: cond, list: listKey }
                }
            };
            tree.jstree(true).refresh();
        };

        // Инкремент или декремент количества задач в той группе, где она была создана
        var setCount = function (decrement) {
            var $projectDiv = $(".list-view div").filter("[data-key=" + listKey + "]").find("span:last"),
                inboxDiv   = $("#inbox").find("span"),
                number     = 0;
                accept = true;

            // Если переменная с ключом пуста, значит пользователь в "Inbox"
            if (listKey == null) {
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
                            url:  "task/node",
                            data: function (node) {
                                return { id: node.id, ls: listKey };
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
        Mousetrap.bind([ '/' ], function () {
            setTimeout(function () { searchInp.focus() }, 100)
        });
        $('a.action').click(function () { createNode(); return false });
        $('.list-tabs').css('display', 'block');

        // Обновление дерева с новыми данными, где поле list эквивалентно выбранному
        $('.user-project').click(function () { appendData.apply(this) });

        // Загрузка Inbox задач из [[actionNode()]]
        $('#inbox').click(function () { appendData.apply(this) });

        // Сортировка по условию
        $("#pr").click(function () { sortByCondition('priority') });
        $("#nm").click(function () { sortByCondition('name') });
        $("#dt").click(function () { sortByCondition('dueDate') });
    };

    var runSchedule = function () {
        // Инициализация внешних событий FullCalendar
        $('#external-events').find('.fc-event').each(function() {
            // Хранить данные так, чтобы календарь знал, как рендерить событие после drop'а
            $(this).data('event', {
                title: $.trim($(this).text()), // использовать текст элемента в качестве имени события
                stick: true, // (см. renderEvent method)
                className: 'fc-event-' + $(this).attr('data-event') // добавить имя класса из data атрибута 'attr'
            });

            // сделать событие перетаскиваемым используя jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true,
                revertDuration: 0
            });

        });

        var Calendar = $('#calendar');
        var Picker   = $('.inline-mp');

        // Инициализация плагина FullCalendar
        Calendar.fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            events: [{
                title: 'Sony Meeting',
                start: '2015-10-4',
                end: '2015-10-6',
                className: 'fc-event-success'
            }, {
                title: 'Conference',
                start: '2015-10-14',
                end: '2015-10-16',
                className: 'fc-event-warning'
            }, {
                title: 'System Testing',
                start: '2015-10-26',
                end: '2015-10-28',
                className: 'fc-event-primary'
            }],
            viewRender: function(view) {
                // Если monthPicker был инициализирован, обновить его дату
                if (Picker.hasClass('hasMonthpicker')) {
                    var selectedDate = Calendar.fullCalendar('getDate');
                    var formatted = moment(selectedDate, 'MM-DD-YYYY').format('MM/YY');
                    Picker.monthpicker("setDate", formatted);
                }
                // Обновить заголовок мини-календаря с месяцами
                var titleContainer = $('.fc-title-clone');
                if (!titleContainer.length) {
                    return;
                }
                titleContainer.html(view.title);
            },
            droppable: true, // Свойство, позволяющее перетаскивать события на календарь
            drop: function() {
                if (!$(this).hasClass('event-recurring')) {
                    $(this).remove();
                }
            },
            eventRender: function(event, element) {
                // Создание подсказки используя bootstrap как основу
                $(element).attr("data-original-title", event.title);
                $(element).tooltip({
                    container: 'body',
                    delay: {
                        "show": 100,
                        "hide": 200
                    }
                });
                $(element).on('show.bs.tooltip', function() {
                    setTimeout(function() {
                        $('.tooltip').fadeOut()
                    }, 3500);
                });
            }
        });

        // Инициализация модального окна через Magnific Popup
        $('#compose-event-btn').magnificPopup({
            removalDelay: 500, // удаление задержки по оси X
            callbacks: {
                beforeOpen: function() {
                    // Добавление класса к body чтобы показать, что наложение активно
                    // Свойство z-index должно правильно конфигурировать отображение вложенности
                    $('body').addClass('mfp-bg-open');
                    this.st.mainClass = this.st.el.attr('data-effect');
                },
                afterClose: function() {
                    $('body').removeClass('mfp-bg-open');
                }
            },
            midClick: true
        });

        Picker.monthpicker({
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            showButtonPanel: false,
            onSelect: function(selectedDate) {
                var formatted = moment(selectedDate, 'MM/YYYY').format('MM/DD/YYYY');
                Calendar.fullCalendar('gotoDate', formatted)
            }
        });

        // Инициализация выбора дат в модальном окне
        $.datepicker.setDefaults($.datepicker.regional["ru"]);
        $('#eventDate').datepicker({
            numberOfMonths:  1,
            minDate:         0,
            prevText:        '<i class="fa fa-chevron-left"></i>',
            nextText:        '<i class="fa fa-chevron-right"></i>',
            showButtonPanel: false,
            dateFormat:      'd M'
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
                buttons:        [{
                    html:        'Add',
                    buttonClass: 'btn btn-primary btn-sm',
                    click:       function () { }
                }]
            });
        });
    };

    var runDashBoard = function () {
        $('.skillbar').each(function () {
            jQuery(this).find('.skillbar-bar').animate({
                width: jQuery(this).attr('data-percent')
            }, 2500);
        });

        $('.ct-chart').highcharts({
            title:   { text: null },
            credits: false,
            chart:   {
                marginTop:       0,
                plotBorderWidth: 0
            },
            xAxis:   {
                categories: [ 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun' ]
            },
            yAxis:   {
                labels: { enabled: false },
                title:  { text: null }
            },
            legend:  { enabled: false },
            series:  [
                {
                    name: 'All visits',
                    data: [ 29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6 ]
                }, {
                    name: 'XP earned',
                    data: [ 4, 6, 5, 9, 11, 14, 1 ]
                }
            ]
        });

        $('.highcharts-grid path:first-child').remove();
        // Init plugins for ".task-widget"
        // plugins: Custom Functions + jQuery Sortable
        var taskWidget = $('div.task-widget');
        var taskItems = taskWidget.find('li.task-item');
        var currentItems = taskWidget.find('ul.task-current');
        var completedItems = taskWidget.find('ul.task-completed');
        // Init jQuery Sortable on Task Widget
        taskWidget.sortable({
            items:       taskItems, // only init sortable on list items (not labels)
            axis:        'y',
            connectWith: ".task-list",
            update:      function (event, ui) {
                var Item = ui.item;
                var ParentList = Item.parent();
                // If item is already checked move it to "current items list"
                if (ParentList.hasClass('task-current')) {
                    Item.removeClass('item-checked').find('input[type="checkbox"]').prop('checked', false);
                }
                if (ParentList.hasClass('task-completed')) {
                    Item.addClass('item-checked').find('input[type="checkbox"]').prop('checked', true);
                }
            }
        });
        // Custom Functions to handle/assign list filter behavior
        taskItems.on('click', function (e) {
            e.preventDefault();
            var This = $(this);
            if ($(e.target).hasClass('fa-remove')) {
                This.remove();
                return;
            }
            // If item is already checked move it to "current items list"
            if (This.hasClass('item-checked')) {
                This.removeClass('item-checked').appendTo(currentItems).find('input[type="checkbox"]').prop('checked', false);
            }
            // Otherwise move it to the "completed items list"
            else {
                This.addClass('item-checked').appendTo(completedItems).find('input[type="checkbox"]').prop('checked', true);
            }
        });

        // Инициализация плагина для FullCalendar
        $('#calendar-widget').fullCalendar({
            contentHeight: 397,
            editable:      true,
            firstDay:      1,
            events:        [
                {
                    title:     'Sony Meeting',
                    start:     '2015-10-1',
                    end:       '2015-10-3',
                    className: 'fc-event-success'
                }, {
                    title:     'Conference',
                    start:     '2015-10-13',
                    end:       '2015-10-15',
                    className: 'fc-event-primary'
                }, {
                    title:     'Lunch Testing',
                    start:     '2015-10-23',
                    end:       '2015-10-25',
                    className: 'fc-event-danger'
                }
            ],
            eventRender:   function (event, element) {
                // Создание подсказки используя bootstrap как основу
                $(element).attr("data-original-title", event.title);
                $(element).tooltip({
                    container: 'body',
                    delay:     {
                        "show": 100,
                        "hide": 200
                    }
                });
                // Автоскрытие подсказки по истечнию таймера
                $(element).on('show.bs.tooltip', function () {
                    setTimeout(function () {
                        $('.tooltip').fadeOut();
                    }, 3500);
                });
            }
        });
        // Инициализация Summertnote плагина
        $('.summernote').summernote({
            height:   255,
            focus:    false,
            oninit:   function () {},
            onChange: function (contents, $editable) {},
            toolbar:  [
                ['style', [ 'style' ]],
                ['font', ['bold', 'italic', 'underline']],
                ['color', [ 'color' ]],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', [ 'hr' ]],
                ['view', [ 'codeview' ]]
            ]
        });

        // Инициализация пользовательских виджетов внутри контейнера ".admin-panels"
        $('.admin-panels').adminpanel({
            grid:         '.admin-grid',
            draggable:    true,
            preserveGrid: true,
            mobile:       false,
            onFinish:     function () {
                $('.admin-panels').addClass('animated fadeIn').removeClass('fade-onload')
            },
            onSave:       function () { $(window).trigger('resize') }
        });
    };

    var runHelpPage = function () {

        // Slide content functionality for template pages
        if ($('html').hasClass('template-page')) {
            $('#template-code').on('click', function () {
                Body.addClass('offscreen-active');
            });
            $('#template-return').on('click', function () {
                Body.removeClass('offscreen-active');
            });
        }
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
            if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv:11\./)) {
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
        // Атрибут data принимает число в миллисекундах (задержка) и класс анимации
        // При условии, что была передана только задержка, устанавливается анимация fadeIn
        $('.animated-delay[data-animate]').each(function () {
            var This = $(this);
            var delayTime = This.data('animate');
            var delayAnimation = 'fadeIn';
            // Если атрибут data имеет более одного значения, сброс на умолчания
            if (delayTime.length > 1 && delayTime.length < 3) {
                delayTime = This.data('animate')[ 0 ];
                delayAnimation = This.data('animate')[ 1 ];
            }
            setTimeout(function () {
                This.removeClass('animated-delay').addClass('animated ' + delayAnimation).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                    This.removeClass('animated ' + delayAnimation);
                });
            }, delayTime);
        });
    };

    // Header функции
    var runHeader = function () {

        // Панель поиска - модификация для мобильных устройств
        $('.navbar-search').on('click', function (e) {
            var This         = $(this),
                searchForm   = This.find('input'),
                searchRemove = This.find('.search-remove');
            // Ничего не делать, только если не мобильный режим
            if ($('body.mobile-view').length || $('body.sb-top-mobile').length) {

                // Открыть панель поиска и добавить иконку сброса, если она не найдена
                This.addClass('search-open');
                if (!searchRemove.length) {
                    This.append('<div class="search-remove"></div>');
                }
                // Появление кнопки сброса и фокус на поле ввода по завершению анимации
                setTimeout(function () {
                    This.find('.search-remove').fadeIn();
                    searchForm.focus().one('keydown', function () {
                        $(this).val('');
                    });
                }, 250);
                // Если нажата кнопка сброса, закрыть панель поиска
                if ($(e.target).attr('class') == 'search-remove') {
                    This.removeClass('search-open').find('.search-remove').remove();
                }
            }
        });
        var dropDown = $('.dropdown-item-slide');
        // Анимация для для выпадающего списка в хедере
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

    // Связанные с треем функции
    var runTrays = function () {

        // Соответствие высоты трея с высотой body
        var trayMatch = $('.tray[data-tray-height="match"]');
        if (trayMatch.length) {

            // Установка такой высоты, которая соответствует высоте body
            trayMatch.each(function () {
                var Height = $('body').height();
                $(this).height(Height);
            });
        }
        // Обработчик изменения размеров
        var rescale = function () {
            if ($(window).width() < 1000) {
                Body.addClass('tray-rescale');
            } else {
                Body.removeClass('tray-rescale tray-rescale-left tray-rescale-right');
            }
        };
        var lazyLayout = _.debounce(rescale, 300);
        if (!Body.hasClass('disable-tray-rescale')) {
            // Масштабирование при изменении размеров окна
            $(window).resize(lazyLayout);
            // Масштабирование при загрузке
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
            onTaskPage  ? runTaskPage()  : false;
            onDashBoard ? runDashBoard() : false;
            onHelpPage  ? runHelpPage()  : false;
            onSchPage  ? runSchedule()  : false;
            runHelpers();
            runDockModal();
            runRoundedSkill();
            runAnimations();
            runTrays();
            //runFormElements();
            runHeader();
        }
    }
}();