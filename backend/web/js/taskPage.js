'use strict';

/**
 * @author hirootkit <admiralexo@gmail.com>
 */
var taskPage = function () {

    var $formAdd  = $("#formAdd"),
        $formEdit = $("#formEdit"),
        tree      = $("#tree"), // Указатель на jsTree
        projectTree  = $(".projectTree"),
        csrfToken = $('meta[name=csrf-token]').attr("content"),
        format    = null, // Форматирование при __task или --task
        dueDate   = null,
        taskPriority = null, // Приоритет при !1task, !2task...
        projName  = null, // Название проекта
        listId    = null; // PK проекта

    // Убрать полосу загрузки при ajax запросах
    Pace.options = { ajax: false };

    // Автоматическая высота страницы
    if ($('.h1200').length) {
        $(window).load(function () {
            $('.h1200').css({ 'height': ($(window).height() + 500) + 'px' });
        });
        $(window).resize(function () {
            $('.h1200').css({ 'height': ($(window).height() + 500) + 'px' });
        });
    }

    var runContentTree = function () {

        var acceptRequest    = false,
            projectIsClicked = false,
            searchInput      = $('#searchText');

        // Получение узла из его экземпляра
        function getInstance(data) {
            return $.jstree.reference(data.reference).get_node(data.reference);
        }

        // Сортировка по заданному условию
        function sortByCondition (cond) {
            tree.jstree(true).settings.core.data = {
                url:  "/task/node",
                data: function (node) {
                    return {
                        id: node.id,
                        sort: cond,
                        listId: listId
                    }
                }
            };
            tree.jstree(true).refresh();
        }

        // Удаление выполненных задач
        function deleteCompleted () {
            $.post("/task/delete", {
                completed: true,
                _csrf:     csrfToken
            });
        }

        // Инкремент или декремент количества задач в той группе, где она была создана (напр. "Входящие")
        function setCountInGroup (decrement) {
            var $projectDiv = $(".list-view div").filter("[data-key=" + listId + "]").find("span:last"),
                $inboxDiv = $(".counter.inbox"),
                number = 0;

            acceptRequest = true;
            // Если переменная с ключом пуста, значит пользователь в "Inbox"
            if (listId == null) {
                number = parseInt($inboxDiv.text());
                decrement ? $inboxDiv.html(--number) : $inboxDiv.html(++number);
            } else {
                number = parseInt($projectDiv.text());
                decrement ? $projectDiv.html(--number) : $projectDiv.html(++number);
            }
            // Исключить все дублированные реквесты
            setTimeout(function () { acceptRequest = false }, 100)
        }

        // Редактирование задачи с полученными параметрами (напр. дата, приоритет)
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
                        pr:   getShortcut('taskPriority', document.getElementById("editInput").value),
                        dt:   dueDate
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

        // Добавление задачи. Перед событием, задача переводится в режим редактирования
        function createContentNode () {
            // Замыкание, инициализирующее создание узла
            var closureAdd = function () {
                // Экземпляр корневого DOM-элемента преобразуется в объект jsTree
                var root = tree.jstree(true).get_node($("a:contains('Root')").last()),
                    text = document.getElementById("taskInput").value,
                    $rootHasChildren = $("li:contains('Root') .jstree-children").length,
                    $taskInp = $("#taskInput");

                if ($taskInp.val()) {
                    // Если у корня нет дочерних элементов, значит стоило бы
                    // обновить дерево после добавления ради избежания ошибок
                    if (!$rootHasChildren) {
                        tree.jstree(true).create_node(root, {
                            text: text,
                            taskPriority: getShortcut('taskPriority', text),
                            dueDate: dueDate
                        }, "last");
                        $taskInp.val('');
                        tree.jstree(true).settings.core.data = {
                            url:  "/task/node",
                            data: function (node) {
                                return { id: node.id, list: listId };
                            }
                        };
                        tree.jstree(true).refresh();
                        if (!acceptRequest) { setCountInGroup(false) }
                    } else {
                        tree.jstree(true).create_node(root, {
                            text: text,
                            taskPriority: getShortcut('taskPriority', text),
                            dueDate: dueDate
                        }, "last");
                        $taskInp.val('');

                        if (!acceptRequest) { setCountInGroup(false) }
                    }
                }
            };

            // Добавление контейнера редактирования новой задачи в jsTree список
            $formEdit.hide(); $formAdd.show();
            setTimeout(function () { $formAdd.find("#taskInput").focus() }, 100);
            $("#taskInput").on("keyup", function (e) {
                // Escape - отмена
                if (e.keyCode == 27) { $formAdd.hide() }
                // Enter  - добавление
                if (e.keyCode == 13) { closureAdd() }
            });
            $(document).on("click", ".buttonCancel", function () { $formAdd.hide() });
            $(document).on("click", ".buttonAdd",    function () { closureAdd()    });
        }

        // Скрытие корневого узла
        function hideRoot () {
            $("a:contains('Root')").css("display", "none");
            $(".jstree-last .jstree-icon").first().hide();
        }

        // Получение сокращений для быстрого форматирования задачи
        function getShortcut (type, text) {
            if (type === 'taskPriority') {
                if (text.indexOf('!1') >= 0) {
                    taskPriority = 3;
                } else if (text.indexOf('!2') >= 0) {
                    taskPriority = 2;
                } else if (text.indexOf('!3') >= 0) {
                    taskPriority = 1;
                } else {
                    taskPriority = null;
                }

                return taskPriority;
            }
        }

        function appendData () {
            // jsTree построен таким образом, что при переполнении стака реквестов
            // ответ с сервера не дойдёт должным образом. Поэтому необходимо помешать
            // пользователю заядло кликать больше, чем раз в полторы секунды
            if (!projectIsClicked) {
                projectIsClicked = true;
                listId   = $(this).parent().data("key");
                projName  = $(this).text().trim().slice(0, -2);

                // Перестроение дерева перед загрузкой проектов
                tree.jstree(true).settings.core.data = {
                    url:  '/task/node',
                    data: function (node) {
                        return { id: node.id, ls: listId };
                    }
                };
                tree.jstree(true).refresh();
                $('.crumb-active span').html(projName);
                setTimeout(function () { projectIsClicked = false }, 1500);
            }
        }

        var treeOptions = {
            "core":        {
                "data": {
                    "url":  "/task/node",
                    "data": function (node) {
                        return { id: node.id };
                    }
                },
                "check_callback": true,
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
                            "label":  "Добавить задачу",
                            "action": function () { createContentNode() }
                        },
                        "SetPriority": {
                            "icon":    "fa fa-flag",
                            "label":   "Степень важности",
                            "action":  false,
                            "submenu": {
                                "high":   {
                                    "icon":   "fa fa-circle",
                                    "label":  "Высокий",
                                    "action": function (data) {
                                        var node = getInstance(data);
                                        $.post("/task/set-priority", {
                                            "id": node.id,
                                            "taskPriority": 3
                                        }).done(function () {
                                            $("#" + node.id).children("a").addClass("high").removeClass("low medium");
                                        }).fail(function () {
                                            data.instance.refresh();
                                        });
                                    }
                                },
                                "medium": {
                                    "icon":   "fa fa-circle",
                                    "label":  "Средний",
                                    "action": function (data) {
                                        var node = getInstance(data);
                                        $.post("/task/set-priority", {
                                            "id": node.id,
                                            "taskPriority": 2
                                        }).done(function () {
                                            $("#" + node.id).children("a").addClass("medium").removeClass("high low");
                                        }).fail(function () {
                                            data.instance.refresh();
                                        });
                                    }
                                },
                                "low":    {
                                    "icon":   "fa fa-circle",
                                    "label":  "Низкий",
                                    "action": function (data) {
                                        var node = getInstance(data);
                                        $.post("/task/set-priority", {
                                            "id": node.id,
                                            "taskPriority": 1
                                        }).done(function () {
                                            $("#" + node.id).children("a").addClass("low").removeClass("high medium");
                                        }).fail(function () {
                                            data.instance.refresh();
                                        });
                                    }
                                },
                                "none":   {
                                    "icon":   "fa fa-circle-o",
                                    "label":  "Отсутствует",
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
                            "label":   "Перенести",
                            "action":  false,
                            "submenu": {
                                "today":    {
                                    "icon":   "fa fa-calendar-o",
                                    "label":  "На сегодня",
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
                                    "label":  "На завтра",
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
                                }
                            }
                        },
                        "Remove":      {
                            "separator_before": true,
                            "icon":             "fa fa-trash-o",
                            "label":            "Удалить задачу",
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

        tree.jstree(
            treeOptions
        ).on('create_node.jstree', function (e, data) {
            if (data.node.text !== '' && data.node.text != 'New node') {
                $.post('/task/create', {
                    'id':       data.node.parent,
                    'name':     data.node.text,
                    'pos':      data.position,
                    'listId':   listId,
                    'taskPriority': taskPriority,
                    'dueDate':  dueDate,
                    '_csrf':    csrfToken
                }).done(function (id) {
                    data.instance.set_id(data.node, id);
                    taskPriority = null;
                    dueDate = null;
                }).fail(function () {
                    data.instance.refresh();
                });

                hideRoot();
            }
        }).on('delete_node.jstree', function (e, data) {
            $.post('/task/delete', {
                'id':    data.node.id,
                '_csrf': csrfToken
            }).done(function () {
                setCountInGroup(true)
            }).fail(function () {
                data.instance.refresh()
            });
        }).on('rename_node.jstree', function (e, data) {
            $.post('/task/rename', {
                'id':   data.node.id,
                'text': data.text,
                'pr':   taskPriority,
                'fr':   format,
                'dt':   dueDate
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
            var $node  = $('#' + data.node.id),
                isDone = null;

            // Задача активная, нужно пометить её как завершенную
            if ($(event.target).is('i') && !$node.hasClass('jstree-checked')) {
                tree.jstree(true).uncheck_node(data.node.id);
                isDone = 1;
                // Поиск чекбокса и добавление svg галочки
                $('.svgBox').appendTo($node.find('a')).css('display', 'block');
                setTimeout(function () {
                    $node.removeClass('jstree-selected').addClass('jstree-checked').fadeOut(240);
                    setCountInGroup(true);
                }, 200);
            // Задача завершена, нужно сделать её активной
            } else if ($(event.target).is('svg') || $(event.target).is('i')) {
                tree.jstree(true).uncheck_node(data.node.id);
                isDone = 0;
                // Поиск чекбокса и скрытие svg галочки
                $node.find('.svgBox').fadeOut(100);
                setTimeout(function () {
                    $node.removeClass('jstree-selected').removeClass('jstree-checked').fadeOut(240);
                    setCountInGroup();
                }, 200);
            }

            $.post('/task/done', {
                'id':     data.node.id,
                'isDone': isDone,
                '_csrf':  csrfToken
            }).fail(function () {
                data.instance.refresh();
            });
        }).on("redraw.jstree", function () {
            tree.jstree("open_all");
            hideRoot();
        });

        searchInput.keyup(function (e) {
            setTimeout(function () {
                $('#tree').jstree(true).search(searchInput.val());
            }, 250);
            if (e.keyCode == 27) { $('.inboxGroup').focus() }
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
                dueDate = inst.selectedYear + '-' + inst.selectedMonth + 1 + '-' + inst.selectedDay;
                $("#editEvent").length ? $("#editEvent").focus() : $("#eventDate").focus();
            }
        });

        // Вычисление позиции введенной даты с помощью интеллектуального ввода
        $('#taskInput').keyup(function() {
            var value = $(this).val();
            var userDate = null;
            var monthNames = [
                ':Янв', ':Фев', ':Мар', ':Апр', ':Май', ':Июн',
                ':Июл', ':Авг', ':Сен', ':Окт', ':Ноя', ':Дек'
            ];
            var dayNamesShort = [':пн', ':вт', ':ср', ':чт', ':пт', ':сб', ':вс'];
            var humanFriendly = [':сегодня', ':завтра', ':послезавтра'];

            // Поиск даты в коротком формате, со стоящей после неё цифрой, обозначающей число
            $.each(monthNames, function(monthNumber, monthName) {
                // Проверка введен ли месяц
                if (value.indexOf(monthName) != -1) {
                    // Месяц найден, поиск числа после него
                    var dayNumber = value.substr(value.indexOf(":") + 4);

                    if (dayNumber >= 1 && dayNumber <= 31) {
                        // Приведение вычисленной даты в формат YYYY-MM-DD
                        userDate = [moment().year(), monthNumber, dayNumber];
                        dueDate = moment(userDate).format('YYYY-MM-DD');
                        console.log(dueDate);
                    }
                }
            });
            // Поиск дня недели в коротком формате
            $.each(dayNamesShort, function(dayNumber, dayName) {
                if (value.indexOf(dayName) != -1) {
                    // Получение дня недели в числовом формате eg. пн => 1
                    userDate = [moment().year(), moment().month(), dayNumber + 1];
                    dueDate = moment(userDate).format('YYYY-MM-DD');
                    console.log(dueDate);
                }
            });
            // Поиск человекопонятной даты
            $.each(humanFriendly, function(key, dateName) {
                if (value.indexOf(dateName) != -1) {
                    switch (dateName) {
                        case ':сегодня':
                            dueDate = moment().format('YYYY-MM-DD');
                            break;
                        case ':завтра':
                            dueDate = moment().add(1, 'd').format('YYYY-MM-DD');
                            break;
                        case ':послезавтра':
                            dueDate = moment().add(2, 'd').format('YYYY-MM-DD');
                            break;
                    }
                    console.log(dueDate);
                }
            });
            // Поиск числа дней с этого момента
            if (value.indexOf(":+") != -1) {
                var quantity = value.substr(value.indexOf(":+") + 2);

                dueDate = moment().add(quantity, 'd').format('YYYY-MM-DD');
                console.log(dueDate);
            }
        });

        // Увеличение количества задач в селекторе групп с определенной скоростью
        $.getJSON("/task/get-task-count", function (data) {
            $('.counter.inbox').countTo({from: 0, to: data.inbox});
            $('.counter.today').countTo({from: 0, to: data.today});
            $('.counter.next7days').countTo({from: 0, to: data.next});
        });

        // Бинд события создания задачи на клавиши
        Mousetrap.bind([ 'q', 'й' ], function () { $('a.action').click() });
        Mousetrap.bind([ '/' ], function () {
            setTimeout(function () { searchInput.focus() }, 100)
        });
        $('.action').click(function () { createContentNode(); return false });
        $('.list-tabs').css('display', 'block');

        // Загрузка входящих задач из [[actionNode()]]
        $('.inboxGroup').click(function () {
            appendData.apply(this);
            $('.history').removeClass('fa-reply out').addClass('fa-clock-o in');
            $(this).find('.sidebar-title').addClass('fw600');
            // Поиск и удаление недействительных хлебных крошек
            $('.crumb-active span').html("Входящие");
            $('.crumb-link').html("Обзор");

            return false;
        });

        // Визуализация завершенных задач в определенной группе или проекте
        $(".history").click(function () {
            // Если пользователь вне завершенных, пускаем его
            if ($(this).hasClass('in')) {
                listId = $(this).parent().data("key");

                // Добавление класса, который означает что следующее действие пользователя - это выход
                $(this).removeClass('fa-clock-o in').addClass('fa-reply out');
                // Добавление хлебных крошек
                $('.crumb-active span').html($("a.active").find(".sidebar-title").text());
                $('.crumb-link').html("Завершенные");
                // Запрос у метода завершенных задач
                tree.jstree(true).settings.core.data = {
                    url:  '/task/get-history',
                    data: function (node) {
                        return { id: node.id, list: listId };
                    }
                };
                tree.jstree(true).refresh();
                // Если внутри, то показываем кнопку возвращения назад
            } else if ($(this).hasClass('out')) {
                // Добавление класса, который означает что следующее действие пользователя - это вход
                $(this).removeClass('fa-reply out').addClass('fa-clock-o in');
                $('.inboxGroup').click();
            }
        });

        // Сортировка по условию и удаление завершенных
        $("#pr").click(function () { sortByCondition('taskPriority') });
        $("#nm").click(function () { sortByCondition('name') });
        $("#dt").click(function () { sortByCondition('dueDate') });
        $("#rm").click(function () { deleteCompleted() });

        // Скрыт или показан инспектор
        if (localStorage.getItem("inspect") == "show") {
            $("body").removeClass("sb-r-c").addClass("sb-r-o");
        }
    };

    var runProjectTree = function () {

        var $projectForm = $('.project'),
            colors = ['first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth'];

        // Скрытие корневого узла
        function hideRoot () {
            $("a:contains('Root')").css("display", "none");
            $(".jstree-last .jstree-icon").first().hide();
        }

        // Замыкание, инициализирующее создание узла
        var closureProjectAdd = function () {
            // Экземпляр корневого DOM-элемента преобразуется в объект jsTree
            var root = projectTree.jstree(true).get_node($("a:contains('Root')").first()),
                text = document.getElementById("projectInput").value,
                $projectInput = $("#projectInput");

            if (text.length) {
                projectTree.jstree(true).create_node(root, { text: text }, "last");
                $projectInput.val('');
            }

            $projectForm.show();
            setTimeout(function () { $projectForm.find("#projectInput").focus() }, 100);
            $("#projectInput").on("keyup", function (e) {
                // Escape - отмена
                if (e.keyCode == 27) { $projectForm.hide() }
                // Enter  - добавление
                if (e.keyCode == 13) { closureProjectAdd() }
            });
        };

        var optionsProject = {
            "core":        {
                "data": {
                    "url":   "/project/node",
                    "data":  function (node) {
                        return { id: node.id };
                    }
                },
                "check_callback": true,
                "multiple":       false,
                "animation":      false,
                "themes":         {
                    name:       "neutron",
                    url:        "vendor/plugins/jstree/themes/neutron/style.css",
                    responsive: true
                }
            },
            "contextmenu": {
                "select_node": false,
                "items":       function (node) {
                    return {
                        "Create":      {
                            "icon":   "fa fa-leaf",
                            "label":  "Добавить проект",
                            "action": function () { closureProjectAdd() }
                        },
                        "Edit":      {
                            "icon":   "fa fa-pencil",
                            "label":  "Редактировать проект",
                            "action": function () { closureProjectAdd() }
                        },
                        "Remove":      {
                            "separator_before": true,
                            "icon":             "fa fa-trash-o",
                            "label":            "Удалить проект",
                            "action":           function () {
                                projectTree.jstree(true).delete_node(node);
                                hideRoot();
                            }
                        }
                    };
                }
            },
            "checkbox":    { "three_state": false },
            'plugins': ['dnd', 'checkbox', 'contextmenu', 'state']
        };

        projectTree.jstree(
            optionsProject
        ).on("redraw.jstree", function () {
            projectTree.jstree("open_all");
            hideRoot();
        }).on('select_node.jstree', function (e, data) {
            listId = data.node.id;
            // Перестроение дерева перед загрузкой проектов
            projectTree.jstree(true).settings.core.data = {
                url: '/project/node',
                data: function (node) {
                    return { id: node.id, listId: data.node.id };
                }
            };
            projectTree.jstree(true).refresh();
            $('.crumb-active span').html(data.node.text);
            return false;
        }).on('create_node.jstree', function (e, data) {
            if (data.node.text !== '' && data.node.text != 'New node') {
                var selectedColor = colors[Math.floor(Math.random() * colors.length)];

                $.post('/project/create', {
                    'id':    data.node.parent,
                    'listName': data.node.text,
                    'badgeColor': selectedColor,
                    '_csrf': csrfToken
                }).done(function (id) {
                    data.instance.set_id(data.node, id);
                    $("#" + id).find("a").addClass(selectedColor);
                }).fail(function () {
                    data.instance.refresh();
                });
                hideRoot();
            }
        }).on('delete_node.jstree', function (e, data) {
            $.post('/project/delete', {
                'id':    data.node.id,
                '_csrf': csrfToken
            }).fail(function () {
                data.instance.refresh()
            });
        });

        $('.actionProject').click(function () { closureProjectAdd(); return false });
    };

    var runTour = function () {
        // Define Bootstrap Tour steps
        var tour = new Tour({
            backdrop: false,
            storage: false,
            steps: [{
                element: ".actionProject",
                content: "Начните с добавления проекта, над которым будет работать Ваша команда или Вы сами.",
                placement: 'right'
            }, {
                element: "#tour-item2",
                content: "This is step 2. I'm a google map",
                placement: 'top'
            }]
        });

        // Инициализация обзора задачника и его запуск
        tour.init();
        setTimeout(function () { tour.restart() }, 3000);
    };

    $(document).ready(function () {
        if ($("body.task-page").length) {
            runContentTree();
            runProjectTree();
        }
    });
}();