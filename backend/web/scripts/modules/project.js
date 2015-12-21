/**
 * @author hirootkit <admiralexo@gmail.com>
 */

var project = (function () {
    'use strict';

    /* ===========================
     jQuery селекторы
     ============================= */
    var $tree = $("#tree");
    var $projectTree  = $('.jstree-neutron');
    var $dropDownMenu = $('#paper-top').find('.dropdown-menu');
    var $userList  = $(".users-list");
    var $assignTo  = $('#assign-to');
    var $csrfToken = $('meta[name=csrf-token]').attr("content");

    /* ===========================
     Прочее
     ============================= */
    var badgeColors = ['first', 'second', 'third', 'fourth'];

    /**
     * Обновление названия проекта
     */
    var renameProjectNode = function () {
        var name = $('#edit-name').val(); // Новое название
        var listId = localStorage.getItem("listId");

        if (name.length) {
            $.post('/project/edit', {
                'id':       listId,
                'listName': name,
                '_csrf':    $csrfToken
            }).done(function () {
                noty({ // Отображение уведомления для пользователя
                    text: 'Новые настройки успешно применены',
                    layout: 'topRight',
                    theme: 'relax',
                    timeout: 3000,
                    type: 'success',
                    animation: {
                        open: 'animated fadeIn',
                        close: 'animated fadeOut'
                    }
                });

                // Присваивание нового названия в элементы, где оно было ранее
                $('[data-key='+ listId +']')
                    .find('.text')
                    .html(name);
                $('.crumb-active')
                    .html(name);
                $('#settings-modal')
                    .find('.panel-title')
                    .html('Настройки проекта "' + name + '"');
            });
        }
    };

    /**
     * Создание нового проекта
     */
    var createProjectNode = function () {
        var $input   = $("#project-input");
        var projName = $input.val();

        if (projName.length) {
            // Выбор случайного цвета для иконки проекта
            var selectedColor = badgeColors[Math.floor(Math.random() * badgeColors.length)];

            $.post('/project/create', {
                'listName':   projName,
                'badgeColor': selectedColor,
                '_csrf':      $csrfToken
            }).done(function (data) {
                // Оповещение об отсутствии проектов для новых юзеров
                $('.empty').remove();
                $projectTree.append(
                '<li class="jstree-node jstree-leaf" data-key='+ data.id +'>' +
                    '<a class="jstree-anchor private '+ selectedColor +'" href="#">' +
                        '<i class="jstree-icon jstree-checkbox"></i>' +
                        '<span class="text">'+ data.name +'</span>' +
                    '</a>' +
                '</li>'
                );
            });
            $input.val('');
        }

        setTimeout(function () { $input.focus(); }, 100);

        $("#save-add").on("click", function () {
            createProjectNode();
            $.magnificPopup.close();
        });
    };

    /**
     * Удаление существующего проекта
     */
    var deleteProjectNode = function () {
        var listId = localStorage.getItem("listId");
        var dlg = confirm("Вы действительно хотите удалить этот проект? Данное действие необратимо!");

        if (dlg === true) { // Утвердительный ответ
            $.post('/project/delete', {
                'id':    listId,
                '_csrf': $csrfToken
            }).done(function () {
                $('[data-key='+ listId +']').remove(); // Удаление li элемента
                $.magnificPopup.close(); // Скрытие диалогово окна
                $tree.jstree(true).settings.core.data = {
                    url: "/task/node",
                    data: function (node) {
                        return {
                            id: node.id
                        };
                    }
                };
            });
        }
    };

    /**
     * Заполнение дерева задачами проекта, во время его выбора в левом сайдбаре
     */
    var fillTree = function () {
        $(document).on('click', '.jstree-neutron a', function () {
            // Переменная хранилища содержит идентификатор проекта
            localStorage.setItem("listId", $(this).parent().data('key'));

            // Перестроение дерева под данный проект
            $tree.jstree(true).settings.core.data = {
                url: "/task/node",
                data: function (node) {
                    return {
                        id:     node.id,
                        listId: localStorage.getItem("listId")
                    };
                },
                success: function () {
                    // Делегирование задач возможно только в проектах
                    $assignTo.parent().show();
                }
            };

            $tree.jstree('refresh');

            $('.action').fadeIn(200);
            $('.history').fadeIn(200).removeClass('fa-reply out').addClass('fa-clock-o in');
            $('#all-completed-today').fadeOut(200);

            // Теперь ни один проект кроме данного не активен
            $(".jstree-neutron li").each(function () {
                $(this).removeClass('active');
            });
            $(this).parent().addClass('active');
            $(".inboxGroup, .todayGroup, .nextGroup").removeClass("active");

            // Хлебные крошки указывают на данный проект
            $('.crumb-active').html($(this).text());

            // Настройки проекта присваиваются только после удаления прошлых
            if ($('#settings').length) {
                $dropDownMenu
                    .find('li:lt(2)')
                    .remove();
            }
            $dropDownMenu.prepend(
                '<li><a href="#" id="settings">' +
                    '<span class="entypo-user-add margin-iconic"></span>Настройки проекта</a>' +
                '</li>' +
                '<li class="divider"></li>'
            );

            return false;
        });
    };

    /**
     * Поиск и отправка сообщения юзеру о вступлении в проект.
     * Отображение диалога об успешной отправке.
     */
    var handleShareWithUser = function () {
        $("#done").click(function () {
            var listId   = localStorage.getItem("listId");
            var $project = $('div[data-key='+ listId +']');
            var $email   = $("#email").val();

            if ($email.length) {
                $.post('/project/share-with-user', {
                    'listId': listId,
                    'email':  $email,
                    '_csrf':  $csrfToken
                }).done(function () {
                    $("#done").attr('disabled', true);
                    $project.find('a').removeClass('private').addClass('shared');

                    noty({
                        text: 'Приглашение для ' + $email + ' было отправлено',
                        layout: 'topRight',
                        theme: 'relax',
                        timeout: 3000,
                        type: 'success',
                        animation: {
                            open: 'animated fadeIn',
                            close: 'animated fadeOut'
                        }
                    });
                });
            }
        });
    };

    /**
     * Поиск необходимых идентификаторов, jQuery объектов и удаление юзера из проекта.
     */
    var handleRemoveCollaborator = function () {
        $(document).on('click', '#del-user', function () {
            var userKey  = $(this).parent().data('key');
            var listId   = localStorage.getItem("listId");
            var $project = $('div[data-key='+ listId +']');
            var $user    = $('.section-item[data-key='+ userKey +']');

            $.post('/project/remove-collaborator', {
                'listId': listId,
                'userId': userKey,
                '_csrf':  $csrfToken
            }).done(function () {
                $user.fadeOut();
                $("#done").attr('disabled', false);
                $project.find('a').removeClass('shared').addClass('private');
            });
        });
    };

    var handleOpenSettings = function () {
        $(document).on('click', '#settings', function () {
            var oldText = $('[data-key='+ localStorage.getItem("listId") +']').find('.text').text();

            $('#settings-modal')
            .find('.panel-title')
                .html('Настройки проекта "' + oldText + '"')
            .end()
            .find('#edit-name')
                .val(oldText);

            $.magnificPopup.open({
                removalDelay: 300,
                items: { src: '#settings-modal' },
                callbacks: {
                    beforeOpen: function () {
                        this.st.mainClass = 'mfp-zoomIn';
                    },
                    open: function() {
                        $.getJSON('/project/get-collaborators', {
                            listId: localStorage.getItem("listId")
                        }).done(function(data) {
                            $userList.empty();
                            $.each(data, function(i, user) {
                                $(".users-list").append(
                                '<li class="section-item" data-key="'+ user.key +'">' +
                                    '<div class="section-icon picture">' +
                                    '<div class="avatar medium">' +
                                        '<img src="'+ user.picture +'">' +
                                    '</div>' +
                                    '</div>' +
                                '<div class="section-content">' +
                                    '<span class="comment-author mr5">'+ user.name +'</span>' +
                                    '<span class="label label-rounded label-primary">'+ user.owner +'</span>' +
                                    '<div class="comment-text fs12">'+ user.email +'</div>' +
                                '</div>' +
                                '</li>'
                                );

                                if (!user.owner) {
                                    $(".users-list li:last-child").append(
                                    '<button type="button" id="del-user" class="close" data-dismiss="alert">×</button>'
                                    );
                                }
                            });

                            if ($userList.children().length >= 2) {
                                $("#done").attr('disabled', true);
                            } else {
                                $("#done").attr('disabled', false);
                            }
                        });
                    }
                }
            });
        });
    };

    return {

        init: function () {
            handleShareWithUser();
            handleRemoveCollaborator();
            handleOpenSettings();
            fillTree();

            this.events();
        },
        events: function () {
            $("#save-proj").on("click", function () {
                renameProjectNode();
            });

            $("#del-proj").on("click", function () {
                deleteProjectNode();
            });

            $(".config-wrap").on("click", function () {
                $.magnificPopup.open({
                    removalDelay: 300,
                    items: { src: '#add-proj' },
                    callbacks: {
                        beforeOpen: function () {
                            this.st.mainClass = 'mfp-zoomIn';
                        },
                        open: function () {
                            createProjectNode();
                        }
                    }
                });
            });
        }

    };

})();