/**** LIST WIDGET ****/

$(document).ready(function () {
    handleTodoList();
});

function handleTodoList() {

    var item = '';

    if ($('.todo-list').length) {
        var number_items = $(".todo-list li").length;
        var dt = new Date();
        var currentDay = dt.getDate();
        var monthNames = ["января", "февраля", "марта", "апреля", "мая",
            "июня", "июля", "августа", "сентября", "октобря", "ноября", "декабря"];
        var currentMonth = monthNames[dt.getMonth()];

        /* Context Menu */
        var todoMenuContext = '<div id="context-menu" class="dropdown clearfix">' +
            '<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">' +
            '<li><a href="#" data-priority="high"><i class="fa fa-circle-o c-red"></i> Высокий приоритет</a></li>' +
            '<li><a href="#" data-priority="medium"><i class="fa fa-circle-o c-orange"></i> Средний приоритет</a></li>' +
            '<li><a href="#" data-priority="low"><i class="fa fa-circle-o c-yellow"></i> Низкий приоритет</a></li>' +
            '<li><a href="#" data-priority="none"><i class="fa fa-circle-o c-gray"></i> Нет</a></li>' +
            '</ul>' +
            '</div>';
        $('.main-content').append(todoMenuContext);
        var $contextMenu = $("#context-menu");
        $('.todo-list').on('mousedown', 'li', function () {
            $(this).contextmenu({
                target: '#context-menu',
                onItem: function (context, e) {
                    var current_priority = $(e.target).data("priority");
                    context.removeAttr("class").addClass(current_priority);
                }
            });
        });

        /* Editable Task & Date */
        $('.todo-list .todo-task').editable({
            type: 'text',
            mode: 'inline'
        });
        /*$('.due-date-span').editable({
            type: 'combodate',
            format: 'MM-DD',
            placement: 'bottom',
            viewformat: 'DD.MM',
            template: 'D / MMMM',
            language: 'ru'
        });*/
        $('.due-date-span').editable({
            type: 'date',
            clear: false,
            mode: 'inline',
            datepicker: { weekStart: 0, startView: 0, minViewMode: 0, autoclose: false },
            placement: 'right',
            format: 'dd MM',
            language: 'ru'
        });
        /* Sortable Task */
        $(".todo-list").sortable({
            cancel: ".done",
            axis: "y",
            cursor: "move",
            forcePlaceholderSize: true
        });

        /* Done / Undone Task */
        $(".todo-list").on("ifChecked", ".span-check input", function() {
            var parent = $(this).parents("li:first");
            $(parent).removeClass('bounceInDown').addClass("done");
            $(parent).data("task-order", $(parent).index()).insertAfter($(".todo-list li:last"));
            $('.todo-task', parent).editable("disable");
            $('.completed-date', parent).text('Сделано: ' + currentDay + ' ' + currentMonth);
            $('.due-date-span', parent).editable("disable");
        });
        $(".todo-list").on("ifUnchecked", ".span-check input", function() {
            var parent = $(this).parents("li:first");
            $(parent).removeClass("done");
            if ($(parent).data("task-order")) {
                console.log($(parent).data("task-order"));
                $(parent).insertAfter($(".todo-list li:eq(" + ($(parent).data("task-order") - 1) + ")"));
            }
            else {
                $(".todo-list").prepend($(parent));
            }
            $('.todo-task', parent).editable("enable");
            $('.due-date-span', parent).editable("enable");
            $('.completed-date', parent).text("");
        });

        /* Add Task */
        $(document).on("click", ".add-task", function() {
            item = '';
            number_items++;
            item = '<li class="new-task animated bounceInDown">' +
            '<span class="span-check">' +
            '<input id="task-' + number_items + '" type="checkbox" data-checkbox="icheckbox_square-blue"/>' +
            '<label for="task-' + number_items + '"></label>' +
            '</span>' +
            '<span class="todo-task editable editable-click">Новая задача</span>' +
            '<div class="todo-date clearfix">' +
            '<div class="completed-date"></div>' +
            '<div class="due-date">До ' + currentDay + ' ' + currentMonth + '</div>' +
            '</div>' +
            '<span class="todo-options pull-right">' +
            '<a href="#" class="todo-delete" data-rel="tooltip" data-original-title="Remove task">' +
            '<i class="fa fa-times"></i></a>' +
            '</span>' +
            '<div class="todo-tags pull-right">' +
            '<div class="label label-system">Без категории</div>' +
            '</div>' +
            '</li>';
            $(this).parent().parent().parent().find(".todo-list").append(item);
            $('.todo-list .todo-task').editable({
                type: 'text',
                mode: 'inline'
            });
            window.setTimeout(function () {
                $(".todo-list li").removeClass("animated");
            }, 500);
            $('[data-rel="tooltip"]').tooltip();
            $(this).parent().parent().parent().find(".todo-list").iCheck({
                checkboxClass: 'icheckbox_square-blue'
            });

        });

        /* Remove Task */
        $(document).on("click", ".todo-delete", function () {
            var parent = $(this).parents("li:first");
            $(parent).hide(250);
        });

    }
}