/**
 * @author hirootkit <admiralexo@gmail.com>
 */

var label = (function () {
    'use strict';

    /* ===========================
     jQuery селекторы
     ============================= */
    var $tree = $('#tree');
    var $labels = $('.jstree-label');
    var $csrfToken = $('meta[name=csrf-token]').attr('content');

    /* ===========================
     Прочее
     ============================= */
    var badgeColors = ['first', 'second', 'third', 'fourth'];

    /**
     * Создание нового проекта
     */
    var createLabel = function () {
        var $input    = $('#label-input');
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

        $('#add-save-label').on('click', function () {
            createLabel();
            $.magnificPopup.close();
        });
    };

    /**
     * Отправка данных о дропнутой метке и удаление соответствующего элемента
     */
    var deleteLabel = function (labelKey) {
        $.post('/label/delete', {
            'id':    labelKey ,
            '_csrf': $csrfToken
        }).done(function () {
            $('[data-key='+ labelKey +']').remove(); // Удаление li элемента
            $tree.jstree(true).settings.core.data = {
                url: '/task/node',
                data: function (node) {
                    return { id: node.id };
                }
            };
        });
    };

    return {

        init: function () {
            this.events();
        },
        events: function () {
            $('.rm-label').on('click', function () {
                deleteLabel($(this).parent().parent().data('key'));
            });

            $('.config-label-wrap').on('click', function () {
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