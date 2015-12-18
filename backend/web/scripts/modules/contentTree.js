/**
 * @author hirootkit <admiralexo@gmail.com>
 */

var contentTree = (function() {
    'use strict';

    /* ===========================
     jQuery селекторы
     ============================= */
    var $tree = $("#tree");
    var Body  = $("body");
    var $csrfToken   = $('meta[name=csrf-token]').attr("content");
    var $searchInput = $('.searchText');
    var $addComment  = $("#add-comment");
    var $taskName = $("#name");
    var $assignTo = $('#assign-to');
    var $comments = $(".comment-list");
    var $taskDate = $("#date");
    var $taskNote = $('#summernote');

    var inspector = new $.slidebars({ siteClose: false });

    /* ===========================
     Атрибуты задачи (включая Smarty Add)
     ============================= */
    var taskPriority; // task !1, task !2
    var dueDate; // task :завтра, task :12 Янв, task :+5
    var listId  = localStorage.getItem("listId");
    var nodeObj = null;

    /* ===========================
     Предотвращение дублирования запросов
     ============================= */
    var acceptRequest = false;

    /* ===========================
     URL константы и прочее
     ============================= */
    var urlNodeGet    = "/task/node";
    var urlNodeCreate = "/task/create";
    var urlNodeDelete = "/task/delete";
    var urlNodeMove   = "/task/move";
    var urlNodeEdit   = "/task/edit";
    var urlDeleteAll  = "/task/delete";
    var urlGetCount   = "/task/get-task-count";

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
                    },
                    success: function () {
                        localStorage.setItem('listId', '');
                    }
                },
                "check_callback": true,
                "multiple":  false,
                "worker":    false,
                "animation": 160,
                "themes":         {
                    responsive: true,
                    name: "proton",
                    url:  "vendor/jstree/themes/proton/style.css"
                }
            },
            "checkbox": {
                "three_state": false
            },
            "dnd": {
                "check_while_dragging": false
            },
            "contextmenu": {
                "select_node": true,
                "items":       function (node) {
                    return {
                        "Complete":      {
                            "icon":   "fa fa-check",
                            "separator_after": true,
                            "label":  "Изменить статус завершения"
                        },
                        "Create":      {
                            "icon":   "fa fa-leaf",
                            "label":  "Добавить задачу внутрь",
                            "action": function () { createContentNode(node); }
                        },
                        "Edit":      {
                            "icon":   "fa fa-i-cursor",
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
                                    "action": function () {
                                        setPriority(node.id, 3);
                                    }
                                },
                                "medium": {
                                    "icon":   "fa fa-circle",
                                    "label":  "Средний",
                                    "action": function () {
                                        setPriority(node.id, 2);
                                    }
                                },
                                "low":    {
                                    "icon":   "fa fa-circle",
                                    "label":  "Низкий",
                                    "action": function () {
                                        setPriority(node.id, 1);
                                    }
                                },
                                "none":   {
                                    "icon":   "fa fa-circle-o",
                                    "label":  "Отсутствует",
                                    "action": function () {
                                        setPriority(node.id, null);
                                    }
                                }
                            }
                        },
                        "Today":      {
                            "icon":   "fa fa-calendar-plus-o",
                            "separator_before": true,
                            "label":  "Перенести на сегодня",
                            "action": function () {
                                setDueDate(moment().format('YYYY-MM-DD'), 'сегодня');
                            }
                        },
                        "Tomorrow":      {
                            "icon":   "fa fa-calendar-plus-o",
                            "label":  "Перенести на завтра",
                            "action": function () {
                                setDueDate(moment().add(1, 'd').format('YYYY-MM-DD'), 'завтра');
                            }
                        },
                        "DeleteDate":      {
                            "icon":   "fa fa-calendar-minus-o",
                            "label":  "Удалить дату выполнения",
                            "action": function () {
                                setDueDate(null, '');
                            }
                        },
                        "Remove":      {
                            "separator_before": true,
                            "icon":   "fa fa-trash-o",
                            "label":  "Удалить задачу",
                            "action": function () {
                                $tree.jstree('delete_node', node);
                            }
                        }
                    };
                }
            },
            'plugins': ['dnd', 'contextmenu', 'checkbox', 'search']
        }).on('create_node.jstree', function (e, data) {
            if (data.node.text !== '' && data.node.text !== 'New node') {
                data.instance.refresh();

                $.post(urlNodeCreate, {
                    'id':           data.node.parent,
                    'name':         data.node.text,
                    'pos':          data.position,
                    'listId':       localStorage.getItem("listId"),
                    'taskPriority': taskPriority,
                    'dueDate':      dueDate,
                    '_csrf':        $csrfToken
                }).done(function (id) {
                    data.instance.set_id(data.node, id);
                    // Обнуление атрибутов Smarty Add
                    taskPriority = null;
                    dueDate = null;
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
                'taskPriority': taskPriority,
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
            nodeObj = data.node; // Объект хелпер, содержащий свойства задачи

            // Не нужно вызывать инспектор, если пользователь намеренно этого не хотел
            // e.g. было вызвано контекстное меню, сработало событие, но было отменено
            if (!$(data.event.target).is("i, div, span, polygon, svg") && data.event.which !== 3) {
                var listId = localStorage.getItem("listId");

                $('.wrap-fluid').css({ "margin-left": "300px" });
                $('.navbar').css({ "margin-left": "290px" });
                inspector.open('right'); // Открывашка инспектора задач

                // Заполнение полей ввода атрибутами
                $taskName.val(nodeObj.text);
                $taskDate.val(nodeObj.a_attr.date);
                $taskNote.summernote('code', nodeObj.a_attr.note);

                if (listId !== '') {
                    // Получение пользователей, работающих над проектом
                    $.get('/project/get-assigned', {
                        listId: listId
                    }).done(function (users) {
                        var $assignedUserId = $('#' + nodeObj.id).find('img').attr('id');

                        $assignTo.select2({
                            data: users, // Данные
                            templateResult: formatState // Перегрузка шаблона
                        });

                        // Если задача кому-то назначена, выбрать его в списке
                        // Иначе в списке пользователей активен пункт "Нет"
                        if ($assignedUserId) {
                            $assignTo.val($assignedUserId).trigger('change');
                        } else {
                            $assignTo.val(0).trigger('change');
                        }
                    });
                }

                // Циклическое заполнение списка комментариев
                $.getJSON('/task/get-comments', {
                    taskId: nodeObj.id
                }).done(function(data) {
                    $comments.empty(); // Очистить старые комменты
                    $.each(data, function(i, entity) { // Добавить новые
                        $comments.append(
                        '<li class="section-item">' +
                            '<div class="section-icon picture">' +
                                '<div class="avatar medium" title="'+ entity.author +'">' +
                                    '<img src="'+ entity.picture +'" />' +
                                '</div>' +
                            '</div>' +
                            '<div class="section-content">' +
                                '<span class="comment-author mr5">'+ entity.author +'</span>' +
                                '<span class="comment-time">'+ entity.time +'</span>' +
                                '<div class="comment-text">'+ entity.comment +'</div>' +
                            '</div>' +
                        '</li>'
                        );
                    });
                });
            }
        }).on('deselect_node.jstree', function () {
            emptyInspector(); // Закрывашка инспектора
        }).on("redraw.jstree", function () {
            $tree.jstree("open_all");
            //$(".nano").nanoScroller();
        });
    };

    // Перемещение задачи в историю, либо отметка галочкой, если задача дочерняя.
    // Т.е. она становится выполненной "наполовину"
    var handleCompleteTask = function () {
        $(document).on('click', '.jstree-proton .jstree-checkbox, svg, .vakata-context a[rel="0"]', function () {
            var $node = $('#' + nodeObj.id); // Поиск объекта, который был нажат
            $.vakata.context.hide(); // Скрытие контекстного меню (может оно инициатор события)

            // Если задача активная, нужно обозначить её как завершенную
            if ($(".crumb-active").text() !== 'Завершенные') {
                $tree.jstree(true).uncheck_node(nodeObj.id);

                // Проверка, является ли задача дочерней
                if ($node.attr("aria-level") > 2 && $node.find('a').attr('incomplete') !== 'true') {
                    // Добавление галки и статуса неполностью завершенной задачи
                    $node
                        .addClass('jstree-checked')
                            .children('a')
                            .attr('incomplete', true)
                            .append(
                                '<svg class="svgBox" viewBox="0 0 32 32">' +
                                    '<polygon points="30,5.077 26,2 11.5,22.5 4.5,15.5 1,19 12,30"></polygon>' +
                                '</svg>'
                            );

                    $.post(urlNodeEdit, {
                        'id':     nodeObj.id,
                        'isDone': unCompletelyTask,
                        '_csrf':  $csrfToken
                    }).done(function () {
                        setCountInGroup(true);
                    });
                } else {
                    if ($node.find('a').attr('incomplete') === 'true') {
                        // Возвращение активного статуса дочерней задаче
                        $node
                            .removeClass('jstree-checked')
                            .children('a')
                                .attr('incomplete', false)
                            .find('.svgBox')
                                .fadeOut(100);

                        $.post(urlNodeEdit, {
                            'id':     nodeObj.id,
                            'isDone': activeTask,
                            '_csrf':  $csrfToken
                        }).done(function () {
                            setCountInGroup(true);
                        });
                    } else {
                        // Массив всех дочерних задач, если их уровень вложенности меньше 2
                        var nestedNodes = $.map($node.find('li'), function (li) {
                            return $(li).attr('id');
                        });

                        // Завершение всех задач, вместе с вложенными
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
                            $.post(urlNodeEdit, {
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
                // Если задача хранится в завершенных, возвращаем её к жизни
                $tree.jstree(true).uncheck_node(nodeObj.id);
                $node
                    .removeClass('jstree-checked')
                    .find('.svgBox')
                        .fadeOut(100) // Скрытие галки
                    .end()
                        .fadeOut(250); // Скрытие задачи

                $.post(urlNodeEdit, {
                    'id':     nodeObj.id,
                    'isDone': activeTask,
                    '_csrf':  $csrfToken
                }).done(function () {
                    setCountInGroup(true);
                });
            }
        });
    };

    // Поиск и получение введенных ключевых слов с помощью Smarty Add
    // e.g. :завтра, :Янв 12 ...
    var handleSmartyAdd = function () {
        $(document).on('keyup', '#taskInput, #editInput', function() {
            var value = $(this).val(); // Что-то, введенное пользователем
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
                        dueDate  = moment(userDate).format('YYYY-MM-DD');
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
                            dueDate = moment().format('YYYY-MM-DD');
                            break;
                        case ':завтра':
                            dueDate = moment().add(1, 'd').format('YYYY-MM-DD');
                            break;
                        case ':послезавтра':
                            dueDate = moment().add(2, 'd').format('YYYY-MM-DD');
                            break;
                    }
                }
            });
            // Поиск числа дней с этого момента
            if (value.indexOf(":+") !== -1) {
                var quantity = value.substr(value.indexOf(":+") + 2);

                dueDate = moment().add(quantity, 'd').format('YYYY-MM-DD');
            }
            // Поиск степени важности
            if (value.indexOf("!1") !== -1) {
                taskPriority = 3; // Высокий
            } else if (value.indexOf("!2") !== -1) {
                taskPriority = 2; // Средний
            } else if (value.indexOf("!3") !== -1) {
                taskPriority = 1; // Низкий
            }
        });
    };

    // Заполнение необходимой группы (Входящие, Сегодня...) и её перестроение под полученные задачи
    var handleFillGroup = function () {
        var prepare = function (group) {
            emptyInspector(); // Закрывашка инспектора
            if ($('#settings').length) {
                // Не нужны операции с проектами в выпадающем списке
                $('#paper-top')
                    .find('.dropdown-menu')
                    .find('li:lt(2)')
                        .remove();
            }
            // Указатель на id списка в группах отсутствует
            localStorage.setItem("listId", '');

            $('#all-completed-today').hide(); // По умолчанию неизвестно, выполнены ли задачи
            $('#assign-to').parent().hide(); // Делегирование в группах не требуется
            $('.crumb-active').html(group); // Заголовок соответствует названию группы
            $('.history').fadeOut(200);
            $('a.action').fadeOut(200);

            // Теперь ни один проект не активен, кроме этой группы
            $(".jstree-neutron li").each(function () {
                $(this).removeClass('active');
            });
        };

        $('.inboxGroup').click(function () { // Получение входящих задач
            prepare('Входящие'); // Выполнение стандартных операций для всех типов групп
            $('a.action')
                .fadeIn(200);
            $('.history')
                .fadeIn(200)
                .removeClass('entypo-reply out')
                .addClass('entypo-clock in');
            $(this).addClass('active');

            // Ленивая загрузка и обновление дерева
            fillTree(urlNodeGet, function (node) {
                return { id: node.id };
            });

            $tree.jstree('refresh');
            return false;
        });

        $('.todayGroup').click(function () { // Получение задач на сегодня
            prepare('На сегодня');
            $tree.jstree(true).settings.core.data = {
                url:  urlNodeGet,
                data: function (node) {
                    return {
                        id:    node.id,
                        group: 'today'
                    };
                },
                success: function (node) {
                    // Сообщение добавляется, если активных задач нет
                    if ($.isEmptyObject(node)) {
                        $('.content-wrap .row').append(
                        '<div id="all-completed-today">' +
                            '<img src="/images/sunset.png" class="illustration">' +
                            '<div class="head">Нет задач на сегодня.</div>' +
                            '<span class="text">Все задачи в списке выполнены. Поздравляем!</span>' +
                        '</div>'
                        );
                        $('#all-completed-today').fadeIn(200);
                    }
                }
            };

            $tree.jstree('refresh');
            return false;
        });

        $('.nextGroup').click(function () { // Получение задач на след. неделю
            prepare('На неделю');
            fillTree(urlNodeGet, function (node) {
                return {
                    id:    node.id,
                    group: 'next'
                };
            });

            $tree.jstree('refresh');
            return false;
        });

        $('.assignedGroup').click(function () { // Получение назначенных для юзера задач
            prepare('Поручены мне');
            fillTree('/tree/node', function (node) {
                return { id: node.id };
            });

            $tree.jstree('refresh');
            return false;
        });
    };

    // Визуализация завершенных задач в группах или проектах
    var handleFillCompleted = function () {
        $(".history").click(function () {
            emptyInspector();
            // Если пользователь вне завершенных, разрешить вход
            if ($(this).hasClass('in')) {
                // Добавление иконки и класса, указывающие на выход из завершенных
                $(this).removeClass('entypo-clock in').addClass('entypo-reply out');

                $('.crumb-active').html("Завершенные"); // Хлебные крошки
                $('a.action').fadeOut(200); // Добавлять задачи нельзя

                // Ленивая загрузка завершенных задач (включая проекты)
                fillTree('/task/get-history', function (node) {
                    return {
                        id:     node.id,
                        listId: localStorage.getItem("listId")
                    };
                });
                $tree.jstree('refresh');
            } else
            // Если пользователь в завершенных, отображается кнопка возвращения назад
            if ($(this).hasClass('out')) {
                // Добавление иконки и класса, указывающие на вход в завершенные
                $(this).removeClass('entypo-reply out').addClass('entypo-clock in');
                $('a.action').fadeIn(200);

                // Условие выполнится, если пользователь в группах
                if ($("a.active").length) {
                    $('.inboxGroup').click();
                } else {
                    $('.crumb-active').html($('.active').find('.text').text());
                    fillTree(urlNodeGet, function (node) {
                        return {
                            id:     node.id,
                            listId: localStorage.getItem("listId")
                        };
                    });
                    $tree.jstree('refresh');
                }
            }
        });
    };

    // Вызов функции сортировки или удаление завершенных задач
    var handleSort = function () {
        $("#pr").click(function () { sortByCondition('taskPriority'); });
        $("#nm").click(function () { sortByCondition('name');         });
        $("#dt").click(function () { sortByCondition('dueDate');      });
        $("#rm").click(function () {
            $.magnificPopup.open({ // Диалоговое окно
                removalDelay: 300,
                items: { src: '#modal-text' },
                callbacks: {
                    beforeOpen: function () {
                        this.st.mainClass = 'mfp-zoomIn'; // Кастомный класс анимации открытия
                    }
                }
            });

            $(".del").click(function ()    { deleteCompleted();       });
            $(".cancel").click(function () { $.magnificPopup.close(); });
        });
    };

    var handleEditInspector = function () {
        // Добавление комментария к задаче
        $addComment.keyup(function (e) {
            if (e.keyCode === 13 && this.value.length) {
                $.post('/task/set-comment', {
                    'taskId':     nodeObj.id,
                    'comment':    this.value,
                    'timePosted': moment().format('YYYY-MM-DD'),
                    '_csrf':      $csrfToken
                }).done(function (entity) {
                    $addComment.val('');
                    // Если комментариев до этого момента не было, не помешала бы иконка
                    if (!$('.comment-list li').length) {
                        $('#' + nodeObj.id)
                        .find('.jstree-icon')
                        .last()
                        .addClass('entypo-chat');
                    }
                    $comments.append(
                    '<li class="section-item">' +
                        '<div class="section-icon picture">' +
                            '<div class="avatar medium" title="'+ entity.author +'">' +
                            '<img src="'+ entity.picture +'" />' +
                        '</div>' +
                        '</div>' +
                        '<div class="section-content">' +
                            '<span class="comment-author mr5">'+ entity.author +'</span>' +
                            '<span class="comment-time">'+ entity.time +'</span>' +
                        '<div class="comment-text">'+ entity.comment +'</div>' +
                        '</div>' +
                    '</li>'
                    );
                });
            }
        });

        // Редактирование названия в инспекторе
        $taskName.keyup(function () {
            if (nodeObj !== null) {
                $.post(urlNodeEdit, {
                    'id':    nodeObj.id,
                    'name':  $(this).val(),
                    '_csrf': $csrfToken
                });
            }
        });

        $assignTo.on('select2:select', function () {
            var userId  = $assignTo.select2('data')[0].id;
            var $avatar = $('#' + nodeObj.id).find('img');

            $.post(urlNodeEdit, {
                'id':         nodeObj.id,
                'assignedTo': userId,
                '_csrf':      $csrfToken
            }).done(function () {
                if (userId === '0') {
                    $avatar
                        .attr('src', '')
                        .removeClass('assigned-userpic');
                }

                $avatar.attr('id', userId);
            });
        });
    };

    var handleChangeBackground = function () {
        var bgKey = localStorage.getItem("back");
        // Ключ фона хранится в локальном хранилище
        $("li.theme-bg div").click(function () {
            Body.css({
                "background": "url('images/bg/bg"+ $(this).data('key') +".jpg') no-repeat center center fixed"
            });

            localStorage.setItem("back", $(this).data('key'));
        });

        // При пустом ключе, ставится фон по умолчанию
        if (bgKey === null) {
            Body.css({
                "background": "url('images/bg/bg5.jpg') no-repeat center center fixed"
            });
        } else {
            Body.css({
                "background": "url('images/bg/bg"+ bgKey +".jpg') no-repeat center center fixed"
            });
        }
    };

    // Инкремент или декремент количества задач в группах
    var setCountInGroup = function (decrement) {
        var $inbox = $(".counter.inbox"); // Изначальное количество
        var listId = localStorage.getItem("listId");
        var number;

        acceptRequest = true; // Исключение дублированных реквестов

        if (listId === '') {
            number = parseInt($inbox.text());
            decrement ? $inbox.html(--number) : $inbox.html(++number);
        }

        setTimeout(function () { acceptRequest = false; }, 100);
    };

    // Установка степени важности
    var setPriority = function (id, priority) {
        var $node = $("#" + id).children("a"); // Задача, которой требуется изменить приоритет
        $tree.jstree('uncheck_node', id);

        // Добавление класса без обновления дерева
        var addClass = function () {
            switch (priority) {
                case 3:
                    $node
                        .addClass("high")
                        .removeClass("low medium");
                    break;
                case 2:
                    $node
                        .addClass("medium")
                        .removeClass("high low");
                    break;
                case 1:
                    $node
                        .addClass("low")
                        .removeClass("high medium");
                    break;
                default:
                    $node
                        .removeClass("high medium low");
            }
        };

        $.post(urlNodeEdit, {
            "id": id,
            "taskPriority": priority
        }).done(function () {
            addClass();
        });
    };

    // Выполнение сортировки по заданному условию
    var sortByCondition = function (sortBy) {
        fillTree(urlNodeGet, function (node) {
            return {
                id:     node.id,
                sort:   sortBy,
                listId: localStorage.getItem("listId")
            };
        });
        $tree.jstree('refresh');
    };

    // Удаление выполненных задач в группе или списке
    var deleteCompleted = function () {
        var listId = localStorage.getItem("listId");
        var $crumb = $(".crumb-active"); // Заголовок списка, где был выбран данный пункт

        $.post(urlDeleteAll, {
            completed: true,
            listId:    listId === '' ? null : listId,
            _csrf:     $csrfToken
        });
        $.magnificPopup.close();

        // Перенаправление из завершенных обратно в тот список, где пользователь был до этого
        if ($crumb.text() === 'Завершенные') {
            fillTree(urlNodeGet, function (node) {
                return {
                    id:     node.id,
                    listId: localStorage.getItem("listId")
                };
            });
            $tree.jstree('refresh');
            $('a.action').fadeIn(200);
            $crumb.text($('.active').find('span').text());
        }
    };

    // Сброс значений в полях инспектора задач и его скрытие
    var emptyInspector = function () {
        $('.wrap-fluid').css({ "margin-left": "270px" });
        $('.navbar').css({ "margin-left": "260px" });
        inspector.close();
        $taskName.val('');
        $taskNote.val('');
        $taskDate.val('');
        $addComment.val('');
        $comments.empty();
    };

    var formatState = function (state) {
        if (!state.id) {
            return state.text;
        }
        return $('<span><img src="' + state.picture + '" class="assigned-userpic" /> ' + state.text + '</span>');
    };

    // Перенос задачи на завтра или сегодня с помощью контектового меню
    var setDueDate = function (date, text) {
        $.post(urlNodeEdit, {
            'id':      nodeObj.id,
            'dueDate': date,
            '_csrf':   $csrfToken
        }).done(function () {
            $tree.jstree('uncheck_node', nodeObj.id); // Выделение контекстного меню снято
            $('.noft-blue-number').first().removeClass('noft-red'); // Просроченных задач теперь нет
            $('#' + nodeObj.id).find('.due-date').html(text); // Срок выполнения виден в строке задачи
        });
    };

    // Отображение формы редактирования задачи и отправка данных
    var editContentNode = function (node) {
        var $renameInp  = null; // Поле ввода недоступно т.к. формы пока не существует
        var $nodeObject = $tree.find("li#" + node.id); // Объект редактирования
        var $nodeIcon   = $nodeObject.find("i.jstree-ocl").first(); // Иконка задачи
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

        $tree.jstree('uncheck_node', nodeObj.id); // Выделение на задаче не требуется
        $nodeObject
            .prepend(formEdit) // Добавление формы внутрь задачи
            .addClass('pln')  // И её выравнивание
            .children('ul')
            .addClass('pl33');

        $renameInp = $("#editInput");
        $("#formEdit")
            .show()
            .find($renameInp)
            .focus();

        $nodeIcon.hide(); $nodeAnchor.hide(); // Форма ставится "поверх" задачи

        // Исходный текст задачи внутри поля редактирования
        $renameInp.val($("#" + node.id).find(".text").first().text());
        $renameInp.on("keyup", function (e) {
            if (e.keyCode === 27) { // Escape - отмена
                $nodeObject.removeClass('pln').children('ul').removeClass('pl33');
                $("#formEdit").hide().remove();

                showAnchor();
            }
            if (e.keyCode === 13) { // Enter  - добавление
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

    // Отображение формы создания задачи и отправка данных на сервер
    var createContentNode = function (node) {
        var text = null;     // Данные от пользователя
        var $taskInp = null; // Поле ввода
        var selected = null; // Значение зависит от пути добавления задачи: внутрь другой или в корень
        var formAdd  =
        '<div id="formAdd" hidden>' +
        '<div class="bs-component">' +
            '<div class="form-group form-material col-md-12 mt5 mb5 pln prn">' +
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
            $tree.jstree('uncheck_node', nodeObj.id);
            $tree
                .find("#" + node.id)
                    .append(formAdd)
                .children("#formAdd")
                    .show()
                    .addClass('mh30')
                .find($("#taskInput"))
                    .focus();
            selected = node;
        } else {
            $(formAdd)
                .insertAfter($tree)
                .addClass('mh55')
                .fadeIn(200)
                .find($("#taskInput"))
                    .focus();

            selected = $("a:contains('Root')");
        }

        $taskInp = $("#taskInput");
        $taskInp.on("keyup", function (e) {
            if (e.keyCode === 27) { // Escape - отмена
                $("#formAdd").fadeOut(200).remove();
            }
            if (e.keyCode === 13) { // Enter  - добавление
                text = document.getElementById("taskInput").value;

                if (text.length) {
                    $tree.jstree('create_node', selected, {
                        text:         text,
                        taskPriority: taskPriority,
                        dueDate:      dueDate,
                        listId:       localStorage.getItem("listId")
                    }, "last");
                    $taskInp.val('');
                    selected = null;
                    if (!acceptRequest) { setCountInGroup(false); }
                }
            }
        });
    };

    // Ленивая загрузка данных а-ля обновление дерева
    var fillTree = function (url, data) {
        $tree.jstree(true).settings.core.data = {
            url:  url,
            data: data
        };
    };

    return {

        // Инициализация независимых функциональных обработчиков и событий к ним
        init: function () {
            handleContentTree();
            handleCompleteTask();
            handleSmartyAdd();
            handleFillGroup();
            handleFillCompleted();
            handleSort();
            handleEditInspector();
            handleChangeBackground();

            this.events();
        },

        // Общие обработчики событий
        events: function () {
            // Внутризадачный поиск
            $searchInput.keyup(function (e) {
                setTimeout(function () {
                    $tree.jstree(true).search($searchInput.val());
                }, 250);

                if (e.keyCode === 27) { $('.inboxGroup').focus(); }
            });

            // Отображение сессионного сообщения при его наличии
            if ($("#alert").length) {
                noty({
                    text: $('#alert').find('.body').text(),
                    layout: 'topRight',
                    theme: 'relax',
                    type: 'success',
                    animation: {
                        open:  'animated fadeIn',
                        close: 'animated fadeOut'
                    }
                });
            }

            // Увеличение счетчика задач в группах
            $.getJSON(urlGetCount, function (data) {
                $('.counter.inbox') .countTo({from: 0, to: data.inbox});
                $('.counter.today') .countTo({from: 0, to: data.today});
                $('.counter.week')  .countTo({from: 0, to: data.next});
                $('.counter.assign').countTo({from: 0, to: data.assign});
            });

            // Просто горячие клавиши
            Mousetrap.bind(['q', 'й'], function () { $('a.action').click(); });
            Mousetrap.bind(['/'], function () {
                setTimeout(function () { $searchInput.focus(); }, 100);
            });

            // Добавление задачи
            $('.action').click(function () {
                setTimeout(function () { createContentNode(); }, 50);

                return false;
            });

            // Мгновенное редактирование по нажатию на название задачи
            $(document).on('click', '.jstree-proton .text', function () {
                editContentNode(nodeObj);
                $tree.jstree('uncheck_node', nodeObj.id);

                return false;
            });

            $(window).load(function () {
                $('#status').fadeOut();
                $('#preloader').fadeOut();
                Body.delay(350).css({
                    'overflow': 'visible'
                });
            });

            // Невидимое пространство для отображения иконки захвата задачи
            $(".invisible").hover(function () {
                $(this).parent().addClass('jstree-hovered');
            });

            // Взаимодействие с датой посредством календаря в input форме
            $(".datetimepicker").datetimepicker({
                format:     'DD MMM YYYY',
                autoclose:  true,
                useCurrent: false, // Дата "Сегодня" не ставится автоматически
                minDate:    new Date() // Нельзя выбрать день до текущего
            }).on('dp.change', function () {
                var dateISO = $('.datetimepicker').data("DateTimePicker").getDate();

                if (nodeObj !== null) {
                    $.post(urlNodeEdit, {
                        'id':       nodeObj.id,
                        'dueDate':  moment(dateISO).format('YYYY-MM-DD'),
                        '_csrf':    $csrfToken
                    }).done(function () {
                        $tree.jstree('refresh');
                    });
                }
            });

            // WYSIWYG редактор заметок
            $taskNote.summernote({
                lang: 'ru-RU',
                height: 70,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['paragraph']],
                    ['fontsize', ['fontsize']]
                ],
                callbacks: {
                    onBlur: function() { // При потере элемента фокуса заметка сохраняется
                        var value = $taskNote.summernote('code');
                        if (nodeObj !== null) {
                            nodeObj.a_attr.note = value;

                            $.post(urlNodeEdit, {
                                'id':    nodeObj.id,
                                'note':  value,
                                '_csrf': $csrfToken
                            });
                        }
                    }
                }
            });

            // При выборе проекта, детальная информация о задачах не особо нужна
            $('.jstree-neutron a').click(function () {
                emptyInspector();
            });
        }

    };
})();