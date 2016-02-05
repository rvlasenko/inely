/**
 * @author hirootkit <admiralexo@gmail.com>
 */

var taskTour = (function() {
    'use strict';

    var tourCompleted = localStorage.getItem('tour');

    var handleTour = function () {
        var tour = new Tour({
            backdrop: false,
            storage: false,
            steps: [{
                element: '.projectTitle',
                content: 'Начните с добавления проекта, над которым будет работать Ваша команда или Вы сами.',
                placement: 'right'
            }, {
                element: '.action',
                content: 'Добавляйте задачи вместе с командой.',
                placement: 'bottom'
            }, {
                element: '.btn-wigdet',
                content: 'Назначайте задачу ответственному участнику.',
                placement: 'bottom'
            }],
            onEnd: function () {
                localStorage.setItem('tour', true);
            }
        });

        // Инициализация тура по сайту и его запуск
        if (tourCompleted === null) {
            setTimeout(function () {
                tour.init();
                tour.restart();
            }, 3000);
        }
    };

    return {

        init: function () {
            handleTour();
        }

    };
})();