/**
 * @author hirootkit <admiralexo@gmail.com>
 */

var label = (function () {
    'use strict';

    /* ===========================
     jQuery селекторы
     ============================= */
    var $tree = $("#tree");
    var $labels = $('.jstree-label');
    var $csrfToken = $('meta[name=csrf-token]').attr("content");

    /* ===========================
     Прочее
     ============================= */
    var badgeColors = ['first', 'second', 'third', 'fourth'];

    /**
     * Создание нового проекта
     */
    var createLabel = function () {
        var $input    = $("#label-input");
        var labelName = $input.val();

        if (labelName.length) {
            // Выбор случайного цвета для иконки проекта
            var selectedColor = badgeColors[Math.floor(Math.random() * badgeColors.length)];

            $.post('/label/create', {
                'labelName':  labelName,
                'badgeColor': selectedColor,
                '_csrf':      $csrfToken
            }).done(function (data) {
                // Оповещение об отсутствии меток для новых юзеров
                $('.empty').remove();
                $labels.append(
                '<li data-key='+ data.id +'>' +
                    '<a class="tooltip-tip ajax-load '+ selectedColor +'" href="#">' +
                        '<i class="entypo-tag"></i>' +
                        '<span>'+ data.name +'</span>' +
                    '</a>' +
                '</li>'
                );
            });
            $input.val('');
        }

        setTimeout(function () { $input.focus(); }, 100);

        $("#add-save-label").on("click", function () {
            createLabel();
            $.magnificPopup.close();
        });
    };

    /**
     * Удаление существующей метки
     */
    var deleteLabel = function (labelKey) {
        $.post('/label/delete', {
            'id':    labelKey ,
            '_csrf': $csrfToken
        }).done(function () {
            $('[data-key='+ labelKey +']').remove(); // Удаление li элемента
            $tree.jstree(true).settings.core.data = {
                url: "/task/node",
                data: function (node) {
                    return { id: node.id };
                }
            };
        });
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

    return {

        init: function () {
            //fillTree();

            this.events();
        },
        events: function () {
            $(".rm-label").on("click", function () {
                deleteLabel($(this).parent().parent().data('key'));
            });

            $(".config-label-wrap").on("click", function () {
                $.magnificPopup.open({
                    removalDelay: 300,
                    items: { src: '#add-label' },
                    callbacks: {
                        beforeOpen: function () {
                            this.st.mainClass = 'mfp-zoomIn';
                        },
                        open: function () {
                            createLabel();
                        }
                    }
                });
            });
        }

    };

})();