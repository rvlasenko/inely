var projectTree = (function () {
    'use strict';

    /* ===========================
     jQuery селекторы
     ============================= */
    var $projectForm = $('.project');
    var $projectTree = $('.projectTree');
    var $userList    = $(".users-list");
    var $tree        = $("#tree");
    var $csrfToken   = $('meta[name=csrf-token]').attr("content");

    /* ===========================
     Прочее
     ============================= */
    var colors = [
        'first', 'second', 'third', 'fourth',
        'fifth', 'sixth', 'seventh', 'eighth'
    ];

    var handleContextMenu = function () {
        $.contextMenu({
            selector: '.jstree-neutron .jstree-anchor',
            items: {
                "add": {
                    name: "Добавить проект",
                    icon: function () { return 'fa fa-leaf'; },
                    callback: function() {
                        createProjectNode();
                    }
                },
                "edit":  {
                    name: "Переименовать",
                    icon: function () { return 'fa fa-pencil'; },
                    callback: function(key, opt) {
                        var dom = $projectTree.find('a:contains('+ opt.$trigger.text() +')');

                        renameProjectNode(dom.parent().data('key'));
                    }
                },
                "delete":  {
                    name: "Удалить проект",
                    icon: function () { return 'fa fa-trash-o'; },
                    callback: function (key, opt) {
                        var dom = $projectTree.find('a:contains('+ opt.$trigger.text() +')');

                        $.magnificPopup.open({
                            removalDelay: 300,
                            items: { src: '#modal-del-pr' },
                            callbacks: {
                                beforeOpen: function () {
                                    this.st.mainClass = 'mfp-zoomIn';
                                }
                            }
                        });

                        $(".del").click(function () {
                            deleteProjectNode(dom.parent().data('key'));
                            $.magnificPopup.close();
                        });
                        $(".cancel").click(function () { $.magnificPopup.close(); });
                    }
                }
            }
        });
    };

    var renameProjectNode = function (id) {
        var $project = $('.jstree-node[data-key='+ id +']');
        var $rename  = null;
        var formEdit =
        '<div id="formEditProject">' +
            '<div class="form-group form-material">' +
                '<input type="text" class="form-control input-lg pl50" id="editProjectInput" placeholder="Write here something cool" spellcheck="false">' +
            '</div>' +
        '</div>';

        $project
            .children('a')
                .hide()
            .parent('li')
                .prepend($(formEdit));

        $rename = $("#editProjectInput");
        $rename.val(
            $project
                .children('a')
                    .text()
                    .trim()
        ).focus();
        $rename.on("keyup", function (e) {
            // Escape - отмена
            if (e.keyCode === 27) {
                // Скрытие формы
                $project
                    .children()
                        .show()
                    .prev()
                        .hide()
                        .remove();
            }
            // Enter  - добавление
            if (e.keyCode === 13) {
                if ($rename.val().length) {
                    $.post('/project/rename', {
                        'id':       id,
                        'listName': $rename.val(),
                        '_csrf':    $csrfToken
                    }).done(function (data) {
                        $project
                            .find('.text')
                                .html(data)
                            .end()
                            .children('a')
                                .show()
                            .prev()
                                .hide()
                                .remove();
                    });
                }
            }
        });
    };

    var createProjectNode = function () {
        var $input = $("#projectInput");
        var text   = $input.val();

        if (text.length) {
            // Выбор случайного цвета для иконки проекта
            var selectedColor = colors[Math.floor(Math.random() * colors.length)];

            $.post('/project/create', {
                'listName':   text,
                'badgeColor': selectedColor,
                '_csrf':      $csrfToken
            }).done(function (data) {
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

        setTimeout(function () {
            $projectForm.fadeIn(300).find("#projectInput").focus();
        }, 100);
        $input.on("keyup", function (e) {
            // Escape - отмена
            if (e.keyCode === 27) { $projectForm.fadeOut(300); }
            // Enter  - добавление
            if (e.keyCode === 13) { createProjectNode(); }
        });
    };

    var deleteProjectNode = function (id) {
        $.post('/project/delete', {
            'id':    id,
            '_csrf': $csrfToken
        }).done(function () {
            $('.jstree-node[data-key='+ id +']').remove();
        });
    };

    var fillTree = function () {
        $(document).on('click', '.jstree-neutron a', function () {
            localStorage.setItem("listId", $(this).parent().data('key'));

            // Перестроение дерева на данный проект
            $tree.jstree(true).settings.core.data = {
                url: "/task/node",
                data: function (node) {
                    return {
                        id:     node.id,
                        listId: localStorage.getItem("listId")
                    };
                }
            };

            $tree.jstree('refresh');

            $(".inboxGroup, .todayGroup, .nextGroup").removeClass("active");
            $('.action').fadeIn(200);
            $('.history').removeClass('fa-reply out').addClass('fa-clock-o in');
            $('.btn-group button').first().fadeIn(200);

            // Теперь ни один проект кроме данного не активен
            $(".jstree-neutron li").each(function () {
                $(this).removeClass('active');
            });
            $(this).parent().addClass('active');

            // Хлебные крошки указывают на данный проект
            $('.crumb-active span').html($(this).text());
            $('.crumb-link').html("Проект");

            return false;
        });
    };

    var handleAssignUserToProject = function () {
        $("#done").click(function () {
            var listId   = localStorage.getItem("listId");
            var $project = $('div[data-key='+ listId +']');
            var $email   = $("#email").val();

            if ($email.length) {
                $.post('/project/assign-user', {
                    'listId': listId,
                    'email':  $email,
                    '_csrf':  $csrfToken
                }).done(function () {
                    $("#done").attr('disabled', true);
                    $project.find('a').removeClass('private').addClass('shared');
                });
            }
        });
    };

    var handleUnassignUser = function () {
        $(document).on('click', '#del-user', function () {
            var userKey  = $(this).parent().data('key');
            var listId   = localStorage.getItem("listId");
            var $project = $('div[data-key='+ listId +']');
            var $user    = $('.section-item[data-key='+ userKey +']');

            $.post('/project/unassign-user', {
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

    return {

        init: function () {
            fillTree();
            handleContextMenu();
            handleAssignUserToProject();
            handleUnassignUser();

            this.events();
        },
        events: function () {
            $('.actionProject').click(function () {
                createProjectNode();

                return false;
            });

            $('button.assign').click(function () {
                $.magnificPopup.open({
                    removalDelay: 300,
                    items: { src: '#assign-to-user' },
                    callbacks: {
                        beforeOpen: function () {
                            this.st.mainClass = 'mfp-zoomIn';
                        },
                        open: function() {
                            $.getJSON('/project/get-assigned-users', {
                                listId: localStorage.getItem("listId")
                            }).done(function(data) {
                                $userList.empty();
                                $.each(data, function(i, user) {
                                    $(".users-list").append(
                                    '<li class="section-item pb15" data-key="'+ user.key +'">' +
                                        '<div class="section-icon picture">' +
                                            '<div class="avatar medium">' +
                                                '<img src="'+ user.userpic +'">' +
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
                                            '<button type="button" id="del-user" class="btn btn-rounded btn-default">Удалить</button>'
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
        }

    };

})();