var projectTree = (function () {
    'use strict';

    /* ===========================
     jQuery селекторы
     ============================= */
    var $projectTree = $(".projectTree");
    var $projectForm = $('.project');
    var $tree        = $("#tree");
    var $csrfToken   = $('meta[name=csrf-token]').attr("content");

    /* ===========================
     URL константы и прочее
     ============================= */
    var urlNodeGet = "/project/node";

    var colors = [
        'first', 'second', 'third', 'fourth',
        'fifth', 'sixth', 'seventh', 'eighth'
    ];

    // Инициализация плагина, отвечающего за отображение иерархии
    var handleProjectTree = function () {
        $projectTree.jstree({
            "core":        {
                "data": {
                    "url":   urlNodeGet,
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
                            "action": function () { createProjectNode(); }
                        },
                        "Edit":      {
                            "icon":   "fa fa-pencil",
                            "label":  "Редактировать проект",
                            "action": function () { createProjectNode(); }
                        },
                        "Remove":      {
                            "separator_before": true,
                            "icon":             "fa fa-trash-o",
                            "label":            "Удалить проект",
                            "action":           function () {
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
                                    $projectTree.jstree('delete_node', node);
                                    $.magnificPopup.close();
                                });
                                $(".cancel").click(function () { $.magnificPopup.close(); });
                            }
                        }
                    };
                }
            },
            "checkbox":    { "three_state": false },
            'plugins': ['checkbox', 'contextmenu']
        })
        .on("redraw.jstree", function () {
            $projectTree.jstree("open_all");
        }).on('create_node.jstree', function (e, data) {
            if (data.node.text !== '' && data.node.text !== 'New node') {
                // Выбор случайного цвета для иконки проекта
                var selectedColor = colors[Math.floor(Math.random() * colors.length)];

                $.post('/project/create', {
                    'id':         data.node.parent,
                    'listName':   data.node.text,
                    'badgeColor': selectedColor,
                    '_csrf':      $csrfToken
                }).done(function (id) {
                    data.instance.set_id(data.node, id);
                    $("#" + id).find("a").addClass(selectedColor);
                }).fail(function () {
                    data.instance.refresh();
                });
            }
        }).on('delete_node.jstree', function (e, data) {
            $.post('/project/delete', {
                'id':    data.node.id,
                '_csrf': $csrfToken
            }).fail(function () {
                data.instance.refresh();
            });
        }).on('select_node.jstree', function (node, data) {
            localStorage.setItem("listId", data.node.id);

            // Перестроение дерева перед загрузкой проектов
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

            // Хлебные крошки
            $('.crumb-active span').html(data.node.text);
            $('.crumb-link').html("Проект");

            return false;
        });
    };

    var createProjectNode = function () {
        // Экземпляр корневого DOM-элемента преобразуется в объект jsTree
        var root = $("a:contains('Root')").first();
        var text = document.getElementById("projectInput").value;
        var $input = $("#projectInput");

        if (text.length) {
            $projectTree.jstree('create_node', root, {
                text: text
            }, "last");
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

    return {

        init: function () {
            handleProjectTree();

            this.events();
        },

        // Общие обработчики событий
        events: function () {
            $('.actionProject').click(function () {
                createProjectNode();

                return false;
            });
        }

    };

})();