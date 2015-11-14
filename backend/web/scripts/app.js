/**
 * @author hirootkit <admiralexo@gmail.com>
 *
 * This file is reserved for changes made by the use.
 * Always seperate your work from the theme. It makes
 * modifications, and future theme updates much easier
 */

// Модуль представляет из себя переменную, которой присвоено значение самовызывающейся анонимной функции
// Функция возвращает объект, предоставляющий публичный API для работы с модулем

var App = (function() {
    'use strict';

    var onTheTaskPage = $("body.task-page").length;

    // Объект, содержащий публичное API
    return {
        init: function() {
            if (onTheTaskPage) {
                // Инициализируем модули на странице
                contentTree.init();
                projectTree.init();
                //taskTour.init();
                sideMenu.init();
            }
        }
    };
})();

// Инициализируем глобальный модуль
App.init();