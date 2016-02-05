if ($('body').hasClass('task')) {
    head.js('scripts/task/content.js',  function() { content.init(); });
    head.js('scripts/task/project.js',  function() { project.init(); });
    head.js('scripts/task/label.js',    function() { label.init();   });
    head.js('scripts/task/taskTour.js', function() { taskTour.init(); });
    head.js('scripts/user/settings.js', function() { settings.init(); });
}

// Подключаем библиотеки и настраиваем BDD‐тестирование
//head.js('https://js.cx/test/libs.js', function() {
    // Спецификации находятся здесь
//    head.js('scripts/tests/spec.js');
//});