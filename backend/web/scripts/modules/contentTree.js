var contentTree = (function() {
    'use strict';

    /* ===========================
     jQuery селекторы
     ============================= */
    var $tree        = $("#tree");
    var $csrfToken   = $('meta[name=csrf-token]').attr("content");
    var $searchInput = $('#searchText');
    var $taskName = $("#name");
    var $taskDate = $("#date");
    var $taskNote = $("#note");

    /* ===========================
     Атрибуты задачи (включая Smarty Add)
     ============================= */
    var priority = null; // task !1, task !2
    var dueDate  = null; // task :завтра, task :12 Янв, task :+5
    var listId   = localStorage.getItem("listId");
    var nodeObj  = null;

    /* ===========================
     Таймаут реквестов
     ============================= */
    var acceptRequest = false;
    var isClicked     = false;

    /* ===========================
     URL константы и прочие
     ============================= */
    var urlNodeGet     = "/task/node";
    var urlNodeCreate  = "/task/create";
    var urlNodeDelete  = "/task/delete";
    var urlNodeMove    = "/task/move";
    var urlNodeEdit    = "/task/edit";

    var urlDeleteAll   = "/task/delete";
    var urlSetPriority = "/task/set-priority";
    var urlGetCount    = "/task/get-task-count";
    var urlTaskDone    = "/task/done";

    var completeTask     = 1;
    var unCompletelyTask = 2;
    var activeTask       = 0;

    // Инициализация плагина, отвечающего за отображение иерархии
    var handleContentTree = function () {
        $tree.jstree({
            "core":        {
                "data": {
                    "url":  urlNodeGet,
                    "data": function (node) {
                        return {
                            id: node.id
                        };
                    }
                },
                "check_callback": true,
                "multiple":       false,
                "animation":      160,
                "themes":         {
                    name:       "proton",
                    url:        "vendor/plugins/jstree/themes/proton/style.css",
                    responsive: true
                }
            },
            "massload" : {
                "url" : urlNodeGet,
                "data" : function (nodes) {
                    return { "ids" : nodes.join(',') };
                }
            },
            "checkbox": {
                "three_state": false
            },
            "dnd": {
                "check_while_dragging": false
            },
            "search":   {
                "show_only_matches": true
            },
            "contextmenu": {
                "select_node": false,
                "items":       function (node) {
                    return {
                        "Create":      {
                            "icon":   "fa fa-leaf",
                            "label":  "Добавить задачу здесь",
                            "action": function () { createContentNode(node); }
                        },
                        "Edit":      {
                            "icon":   "fa fa-pencil",
                            "label":  "Редактировать задачу",
                            "action": function () { editContentNode(node); }
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
                                        var node = getNodeByInstance(data);

                                        $.post(urlSetPriority, {
                                            "id": node.id,
                                            "taskPriority": 3
                                        }).done(function () {
                                            $("#" + node.id)
                                                .children("a")
                                                .addClass("high")
                                                .removeClass("low medium");
                                        }).fail(function () {
                                            data.instance.refresh();
                                        });
                                    }
                                },
                                "medium": {
                                    "icon":   "fa fa-circle",
                                    "label":  "Средний",
                                    "action": function (data) {
                                        var node = getNodeByInstance(data);

                                        $.post(urlSetPriority, {
                                            "id": node.id,
                                            "taskPriority": 2
                                        }).done(function () {
                                            $("#" + node.id)
                                                .children("a")
                                                .addClass("medium")
                                                .removeClass("high low");
                                        }).fail(function () {
                                            data.instance.refresh();
                                        });
                                    }
                                },
                                "low":    {
                                    "icon":   "fa fa-circle",
                                    "label":  "Низкий",
                                    "action": function (data) {
                                        var node = getNodeByInstance(data);

                                        $.post(urlSetPriority, {
                                            "id": node.id,
                                            "taskPriority": 1
                                        }).done(function () {
                                            $("#" + node.id)
                                                .children("a")
                                                .addClass("low")
                                                .removeClass("high medium");
                                        }).fail(function () {
                                            data.instance.refresh();
                                        });
                                    }
                                },
                                "none":   {
                                    "icon":   "fa fa-circle-o",
                                    "label":  "Отсутствует",
                                    "action": function (data) {
                                        var node = getNodeByInstance(data);

                                        $.post(urlSetPriority, {
                                            "id": node.id,
                                            "taskPriority": null
                                        }).done(function () {
                                            $("#" + node.id)
                                                .children("a")
                                                .removeClass("high medium low");
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
                                $tree.jstree('delete_node', node);
                            }
                        }
                    };
                }
            },
            'plugins': ['dnd', 'contextmenu', 'checkbox']
        }).on('create_node.jstree', function (e, data) {
            if (data.node.text !== '' && data.node.text !== 'New node') {
                data.instance.refresh();

                $.post(urlNodeCreate, {
                    'id':           data.node.parent,
                    'name':         data.node.text,
                    'pos':          data.position,
                    'listId':       localStorage.getItem("listId"),
                    'taskPriority': priority,
                    'dueDate':      dueDate,
                    '_csrf':        $csrfToken
                }).done(function (id) {
                    data.instance.set_id(data.node, id);
                    priority = null;
                    dueDate  = null;
                }).fail(function () {
                    data.instance.refresh();
                });
            }
        }).on('delete_node.jstree', function (e, data) {
            data.instance.refresh();

            $.post(urlNodeDelete, {
                'id':    data.node.id,
                '_csrf': $csrfToken
            }).done(function () {
                setCountInGroup(true);
            }).fail(function () {
                data.instance.refresh();
            });
        }).on('rename_node.jstree', function (e, data) {
            $.post(urlNodeEdit, {
                'id':           data.node.id,
                'name':         data.node.text,
                //'taskPriority': priority,
                'dueDate':      dueDate,
                '_csrf':        $csrfToken
            }).fail(function () {
                data.instance.refresh();
            });
        }).on('move_node.jstree', function (e, data) {
            data.instance.refresh();

            $.post(urlNodeMove, {
                'id':     data.node.id,
                'parent': data.parent
            });
        }).on('select_node.jstree', function (node, data) {
            var $node = $("#" + data.node.id);
            nodeObj = data.node;

            $taskName.val(nodeObj.text);
            $taskDate.val(nodeObj.a_attr.date);
            $taskNote.val(nodeObj.a_attr.note);

            // Редактирование имени задачи в инспекторе
            $taskName.keyup(function () {
                if (nodeObj !== null) {
                    $node.find(".text").html($(this).val());
                    $.post(urlNodeEdit, {
                        'id':    nodeObj.id,
                        'name':  $(this).val(),
                        '_csrf': $csrfToken
                    });
                }
            });

            // Редактирование заметки
            $taskNote.keyup(function () {
                if (nodeObj !== null) {
                    nodeObj.a_attr.note = $(this).val();

                    if ($(this).val()) {
                        $node.find("i").last().addClass('fa fa-commenting');
                    } else {
                        $node.find("i").last().removeClass('fa fa-commenting');
                    }
                    $.post(urlNodeEdit, {
                        'id':    nodeObj.id,
                        'note':  $(this).val(),
                        '_csrf': $csrfToken
                    });
                }
            });
        }).on('deselect_node.jstree', function () {
            //nodeObj = null;

            $taskName.val('');
            $taskNote.val('');
            $taskDate.val('');
        }).on("redraw.jstree", function () {
            $tree.jstree("open_all");
            $(".nano").nanoScroller();
        });
    };

    // Перемещение задачи в историю, либо отметка галочкой, если задача дочерняя
    var handleCompleteTask = function () {
        $(document).on('click', '.jstree-proton .jstree-checkbox, svg', function () {
            var $node = $('#' + nodeObj.id);

            // Если задача активная, нужно обозначить её как завершенную
            if ($(".crumb-link").text() !== 'Завершенные') {
                $tree.jstree(true).uncheck_node(nodeObj.id);

                if ($node.attr("aria-level") > 2 && $node.find('a').attr('incompletely') !== 'true') {
                    // Поиск чекбокса и добавление статуса неполностью завершенной задачи
                    $node
                        .addClass('jstree-checked')
                            .children('a')
                            .attr('incompletely', true)
                            .append(
                                '<svg class="svgBox" viewBox="0 0 32 32">' +
                                    '<polygon points="30,5.077 26,2 11.5,22.5 4.5,15.5 1,19 12,30"></polygon>' +
                                '</svg>'
                            )
                        .end();

                    $.post(urlTaskDone, {
                        'id':     nodeObj.id,
                        'isDone': unCompletelyTask,
                        '_csrf':  $csrfToken
                    }).done(function () {
                        setCountInGroup(true);
                    });
                } else {
                    if ($node.find('a').attr('incompletely') === 'true') {
                        // Возвращение активного статуса дочерней задаче
                        $node
                            .removeClass('jstree-checked')
                                .children('a')
                                .attr('incompletely', false)
                            .find('.svgBox')
                                .fadeOut(100);

                        $.post(urlTaskDone, {
                            'id':     nodeObj.id,
                            'isDone': activeTask,
                            '_csrf':  $csrfToken
                        }).done(function () {
                            setCountInGroup();
                        });
                    } else {
                        // Массив всех дочерних задач, если их вложенность меньше 2 уровня
                        var nestedNodes = $.map($node.find('li'), function (li) {
                            return $(li).attr('id');
                        });

                        $node
                            .addClass('jstree-checked')
                                .find('a')
                                .append(
                                    '<svg class="svgBox" viewBox="0 0 32 32">' +
                                        '<polygon points="30,5.077 26,2 11.5,22.5 4.5,15.5 1,19 12,30"></polygon>' +
                                    '</svg>'
                                )
                            .end()
                            .fadeOut(250);

                        nestedNodes.push(nodeObj.id);
                        $.each(nestedNodes, function(i, id) {
                            $.post(urlTaskDone, {
                                'id':     id,
                                'isDone': completeTask,
                                '_csrf':  $csrfToken
                            }).done(function () {
                                setCountInGroup(true);
                            });
                        });
                    }
                }
            } else {
                // Если задача завершена, но не удалена, возвращаем её к жизни
                $tree.jstree(true).uncheck_node(nodeObj.id);
                $node
                    .removeClass('jstree-checked')
                        .find('.svgBox')
                        .fadeOut(100)
                    .end()
                    .fadeOut(250);

                $.post(urlTaskDone, {
                    'id':     nodeObj.id,
                    'isDone': activeTask,
                    '_csrf':  $csrfToken
                }).done(function () {
                    setCountInGroup();
                });
            }
        });
    };

    // Поиск и получение введенной даты с помощью Smarty Add
    var handleSmartyAdd = function () {
        $(document).on('keyup', '#taskInput, #editInput', function() {
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
                if (value.indexOf(monthName) !== -1) {
                    // Месяц найден, поиск числа после него
                    var dayNumber = value.substr(value.indexOf(":") + 4);

                    if (dayNumber >= 1 && dayNumber <= 31) {
                        // Приведение вычисленной даты в формат YYYY-MM-DD
                        userDate = [moment().year(), monthNumber, dayNumber];
                        dueDate = moment(userDate).format('YYYY-MM-DD');
                    }
                }
            });
            // Поиск дня недели в коротком формате
            $.each(dayNamesShort, function(dayNumber, dayName) {
                if (value.indexOf(dayName) !== -1) {
                    // Получение дня недели в числовом формате eg. пн => 1
                    userDate = [moment().year(), moment().month(), dayNumber + 1];
                    dueDate = moment(userDate).format('YYYY-MM-DD');
                }
            });
            // Поиск человекопонятной даты
            $.each(humanFriendly, function(key, dateName) {
                if (value.indexOf(dateName) !== -1) {
                    switch (dateName) {
                        case ':сегодня':
                            dueDate = moment().format('YYYY-MM-DD');             break;
                        case ':завтра':
                            dueDate = moment().add(1, 'd').format('YYYY-MM-DD'); break;
                        case ':послезавтра':
                            dueDate = moment().add(2, 'd').format('YYYY-MM-DD'); break;
                    }
                }
            });
            // Поиск числа дней с этого момента
            if (value.indexOf(":+") !== -1) {
                var quantity = value.substr(value.indexOf(":+") + 2);

                dueDate = moment().add(quantity, 'd').format('YYYY-MM-DD');
            }
        });
    };

    // Заполнение группы "Входящие задачи" и перестроение иерархии
    var handleFillInbox = function () {
        $('.inboxGroup').click(function () {
            if (!isClicked) {
                isClicked = true;
                localStorage.setItem("listId", '');

                // Перестроение дерева перед загрузкой проектов
                $tree.jstree(true).settings.core.data = {
                    url:  '/task/node',
                    data: function (node) {
                        return {
                            id: node.id
                        };
                    }
                };
                $tree.jstree('refresh');

                $('.history').removeClass('fa-reply out').addClass('fa-clock-o in');
                $(this).addClass('active');
                $('.btn-group button').first().fadeOut(200);
                $('.action').fadeIn(200);

                // Теперь ни один проект не активен, кроме группы "Входящие"
                $(".jstree-neutron li").each(function () {
                    $(this).removeClass('active');
                });

                // Недействительные хлебные крошки
                $('.crumb-active span')
                    .html("Входящие")
                    .parent()
                    .parent()
                    .find('.crumb-link')
                        .html("Обзор");

                setTimeout(function () { isClicked = false; }, 1500);
            }
            return false;
        });
    };

    // Визуализация завершенных задач во входящих или проекте
    var handleFillCompleted = function () {
        $(".history").click(function () {
            // Если пользователь вне завершенных, пускаем его
            if ($(this).hasClass('in')) {
                // Добавление класса, который означает что предполагаемым
                // следующим действием пользователя будет выход из страницы завершенных
                $(this).removeClass('fa-clock-o in').addClass('fa-reply out');

                // Хлебные крошки
                $('.crumb-link').html("Завершенные");
                $('.action').fadeOut(200);

                // Запрос завершенных задач
                $tree.jstree(true).settings.core.data = {
                    url:  '/task/get-history',
                    data: function (node) {
                        return {
                            id:     node.id,
                            listId: localStorage.getItem("listId")
                        };
                    }
                };
                $tree.jstree('refresh');
                // Если пользователь в завершенных, отображается кнопка возвращения назад
            } else if ($(this).hasClass('out')) {
                // Добавление класса, который означает что предполагаемым
                // следующим действием пользователя будет вход на страницу завершенных
                $(this).removeClass('fa-reply out').addClass('fa-clock-o in');
                $('.action').fadeIn(200);

                if ($("a.active").length) {
                    $('.inboxGroup').click();
                } else {
                    $tree.jstree(true).settings.core.data = {
                        url: urlNodeGet,
                        data: function (node) {
                            return {
                                id:     node.id,
                                listId: localStorage.getItem("listId")
                            };
                        }
                    };
                    $tree.jstree('refresh');
                    $('.crumb-link').html("Проект");
                }
            }
        });
    };

    // Получение узла из его экземпляра в JSON представлении
    var getNodeByInstance = function (data) {
        return $.jstree.reference(data.reference).get_node(data.reference);
    };

    // Инкремент или декремент количества задач во входящих
    var setCountInGroup = function (decrement) {
        var $inbox = $(".counter.inbox");
        var number = 0;

        acceptRequest = true;

        // Если переменная с ключом пуста, значит пользователь в "Inbox"
        if (localStorage.getItem("listId") === '') {
            number = parseInt($inbox.text());
            decrement ? $inbox.html(--number) : $inbox.html(++number);
        }

        // Исключить все дублированные реквесты
        setTimeout(function () { acceptRequest = false; }, 100);
    };

    // Сортировка по заданному условию
    var sortByCondition = function (sortBy) {
        $tree.jstree(true).settings.core.data = {
            url:  urlNodeGet,
            data: function (node) {
                return {
                    id:     node.id,
                    sort:   sortBy,
                    listId: localStorage.getItem("listId")
                };
            }
        };
        $tree.jstree('refresh');
    };

    // Удаление выполненных задач
    var deleteCompleted = function () {
        $.post(urlDeleteAll, {
            completed: true,
            listId:    localStorage.getItem("listId"),
            _csrf:     $csrfToken
        });

        $.magnificPopup.close();
        $tree.jstree('refresh');
    };

    // Редактирование задачи с полученными параметрами Smarty Add (дата, приоритет)
    var editContentNode = function (node) {
        var $renameInp  = null;
        var $nodeObject = $tree.find("li#" + node.id);
        var $nodeIcon   = $nodeObject.find("i.jstree-ocl").first();
        var $nodeAnchor = $nodeObject.find("a.jstree-anchor").first();
        var formEdit   =
        '<div id="formEdit" hidden>' +
        '<div class="bs-component ml30">' +
            '<div class="form-group form-material col-md-12 pln prn">' +
                '<span class="input-group-addon">' +
                    '<i class="fa fa-question-circle fs18" title="Интеллектуальный ввод"></i>' +
                '</span>' +
            '<input type="text" class="form-control input-lg input-add" id="editInput" placeholder="Write here something cool" spellcheck="false">' +
            '</div>' +
        '</div>' +
        '</div>';

        var showAnchor = function () {
            $nodeIcon.fadeIn(200);
            $nodeAnchor.fadeIn(200);
        };

        $nodeObject
            .prepend(formEdit)
            .addClass('pln')
            .children('ul')
            .addClass('pl33');

        $renameInp = $("#editInput");
        $("#formEdit")
            .show()
            .find($renameInp)
            .focus();

        $nodeIcon.hide(); $nodeAnchor.hide();

        $renameInp.val($("#" + node.id).find(".text").first().text());
        $renameInp.on("keyup", function (e) {
            // Escape - отмена
            if (e.keyCode === 27) {
                $nodeObject.removeClass('pln').children('ul').removeClass('pl33');
                $("#formEdit").hide().remove();

                showAnchor();
            }
            // Enter  - добавление
            if (e.keyCode === 13) {
                if ($renameInp.val().length) {
                    $tree.jstree(true).rename_node(node, {
                        text:    $renameInp.val(),
                        dueDate: dueDate
                    });
                    $renameInp.val('');
                }

                showAnchor();
            }
        });
    };

    // Показ формы ввода, и создание задачи, при пройденной валидации
    var createContentNode = function (node) {
        var $taskInp  = null;
        var text = null;
        var $selected = null;
        var formAdd   =
        '<div id="formAdd" hidden>' +
        '<div class="bs-component mh30">' +
            '<div class="form-group form-material col-md-12 mt10 mb10 pln prn">' +
                '<span class="input-group-addon">' +
                    '<i class="fa fa-question-circle fs18" title="Интеллектуальный ввод"></i>' +
                '</span>' +
            '<input type="text" class="form-control input-lg input-add" id="taskInput" placeholder="Write here something cool" spellcheck="false">' +
            '</div>' +
        '</div>' +
        '</div>';

        // Добавление формы редактирования задачи внутрь кликнутого узла,
        // если пользователь вызвал событие из контекстного меню.
        if (typeof node !== 'undefined') {
            $tree
                .find("#" + node.id)
                    .append(formAdd)
                .children("#formAdd")
                    .show()
                .find($("#taskInput"))
                    .focus();
            $selected = node;
        } else {
            $(formAdd)
                .insertAfter($tree)
                .fadeIn(200)
                .find($("#taskInput"))
                .focus();

            $selected = $("a:contains('Root')");
        }

        $taskInp = $("#taskInput");
        $taskInp.on("keyup", function (e) {
            // Escape - отмена
            if (e.keyCode === 27) {
                $("#formAdd").fadeOut(200).remove();
            }
            // Enter  - добавление
            if (e.keyCode === 13) {
                text = document.getElementById("taskInput").value;

                if (text.length) {
                    $tree.jstree('create_node', $("a:contains('Root')"), {
                        text:         text,
                        //taskPriority: getShortcut('taskPriority', text),
                        dueDate:      dueDate,
                        listId:       localStorage.getItem("listId")
                    }, "last");
                    $taskInp.val('');
                    $selected = null;
                    if (!acceptRequest) { setCountInGroup(false); }
                }
            }
        });
    };

    return {

        init: function () {
            handleContentTree();
            handleCompleteTask();
            handleSmartyAdd();
            handleFillInbox();
            handleFillCompleted();

            this.events();
        },

        // Общие обработчики событий
        events: function () {
            // Поиск по задачам
            /*$searchInput.keyup(function (e) {
                setTimeout(function () {
                    $tree.jstree(true).search($searchInput.val());
                }, 250);

                if (e.keyCode === 27) { $('.inboxGroup').focus(); }
            });*/

            // Увеличение количества задач в селекторе групп с определенной скоростью
            $.getJSON(urlGetCount, function (data) {
                $('.counter.inbox').countTo({from: 0, to: data.inbox});
                $('.counter.today').countTo({from: 0, to: data.today});
                $('.counter.next7days').countTo({from: 0, to: data.next});
            });

            // Бинд события создания задачи на клавиши
            Mousetrap.bind(['q', 'й'], function () { $('a.action').click(); });
            Mousetrap.bind(['/'], function () {
                setTimeout(function () { $searchInput.focus(); }, 100);
            });

            // Добавление задачи
            $('.action').click(function () {
                setTimeout(function () {
                    createContentNode();
                }, 50);

                return false;
            });

            // Мгновенное редактирование по клику на названии
            $(document).on('click', '.jstree-proton .text', function () {
                editContentNode(nodeObj);
                $tree.jstree('uncheck_node', nodeObj.id);

                return false;
            });

            // Сортировка по выбранному условию и удаление завершенных задач
            $("#pr").click(function () { sortByCondition('taskPriority'); });
            $("#nm").click(function () { sortByCondition('name'); });
            $("#dt").click(function () { sortByCondition('dueDate'); });
            $("#rm").click(function () {
                $.magnificPopup.open({
                    removalDelay: 300,
                    items: { src: '#modal-text' },
                    callbacks: {
                        beforeOpen: function () {
                            this.st.mainClass = 'mfp-zoomIn';
                        }
                    }
                });

                $(".del").click(function ()    { deleteCompleted();       });
                $(".cancel").click(function () { $.magnificPopup.close(); });
            });

            // Отображен или скрыт инспектор задач
            if (localStorage.getItem("inspect") === "show") {
                $("body").removeClass("sb-r-c").addClass("sb-r-o");
            }

            $(".invisible").hover(function() {
                $(this).parent().addClass('jstree-hovered');
            });

            $(".datetimepicker").datetimepicker({
                format:    'DD MMM YYYY',
                autoclose: true,
                minDate:   new Date()
            }).on('dp.change', function () {
                var iso = $('.datetimepicker').data("DateTimePicker").getDate();

                if (nodeObj !== null) {
                    $.post(urlNodeEdit, {
                        'id':       nodeObj.id,
                        'dueDate':  moment(iso).format('YYYY-MM-DD'),
                        '_csrf':    $csrfToken
                    }).done(function () {
                        $tree.jstree('refresh');
                    });
                }
            });
        }

    };
})();