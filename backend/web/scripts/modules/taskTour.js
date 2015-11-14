var taskTour = (function() {
    'use strict';

    var handleTour = function () {
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
        setTimeout(function () { tour.restart(); }, 3000);
    };

    return {

        init: function () {
            handleTour();
        }

    };
})();