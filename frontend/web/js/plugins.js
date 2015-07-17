/****  Variables Initiation  ****/
var doc = document;

/* ==========================================================*/
/* MAIN PAGE                                                 */
/* ========================================================= */

function sendDateTime(ev) {
    var dateTime = ev.date.valueOf().toString();
    var id = $(ev.target).parent().parent().data('key');

    $.ajax({
        url: 'edit',
        dataType: 'json',
        method: 'post',
        data: {
            id: id,
            time: dateTime.slice(0, -3)
        },
        success: function() {
            alert('Данные обновлены');
        }
    });
}

/**
 * just calling modal window
 * @param url
 * @param id
 * @param show
 */
function modal(url, id, show) {
    if (!$(id + ' .modal-body .row').length) {
        $.get(url, function(html) {
            $(id + ' .modal-body').html(html);
            if (show) $(id).modal('show', {
                backdrop: 'static'
            });
        }).done(function() {
            $.pjax.reload({
                url: '/todo',
                container: '#pjax-wrapper'
            });
        });
    }
}

function sendRating(ev, val) {
    var id = $(ev.target).parent().parent().parent().parent().data('key');

    $.ajax({
        url: 'edit',
        dataType: 'json',
        method: 'post',
        data: {
            id: id,
            rate: val
        },
        success: function() {
            alert('Данные обновлены');
        }
    });
}

/**
 * generate noty notification
 * @param title
 * @param img
 * @param desc
 * @param link
 * @param linkDesc
 */
function generate(title, img, desc, link, linkDesc) {
    noty({
        text: '<div class="alert alert-dark media fade in bd-0" id="message-alert">' +
        '<div class="media-left">' +
        '<img src="' + img + '" ' +
        'class="dis-block">' +
        '</div><div class="media-body width-100p">' +
        '<h4 class="alert-title f-14">' + title + '</h4>' +
        '<p class="f-12 alert-message pull-left">' +
        '' + desc + '</p>' +
        '<p class="pull-right">' +
        '<a href="' + link + '" class="f-12">' + linkDesc + '</a>' +
        '</p></div></div>',
        layout: 'topRight',
        theme: 'made',
        maxVisible: 10,
        animation: {
            open: 'animated bounceIn',
            close: 'animated bounceOut',
            easing: 'swing',
            speed: 500
        },
        timeout: 8000
    });
}

jQuery(function($) {

    // pjax grid reloading on click by category
    $('.kv-sidenav li a').click(function() {
        $.pjax.reload({
            url: $(this).attr('href'),
            container: '#pjax-wrapper'
        });

        return false;
    });

    $('.kv-grid-table tbody tr td a').click(function() {
        if (confirm("Удалить эту задачу из списка?")) {
            $.pjax.reload({
                type: 'POST',
                push: false,
                history: false,
                url: $(this).attr('href'),
                container: '#pjax-wrapper'
            });
        }

        return false;
    });
});

$('document').ready(function() {

    /**
     * Performance chart
     * @type {Morris.Line}
     */
    var chart = new Chartist.Line('.ct-chart', {
        labels: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'],
        series: [{
            name: 'ОО',
            data: [5, 7, 3, 4]
        }]
    }, {
        width: 330,
        height: 150
    });

    new Chartist.Bar('.ct-bar-chart', {
        labels: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'],
        series: [
            [5, 4, 3, 7, 0, 0, 0]
        ]
    }, {
        seriesBarDistance: 30,
        axisY: {
            showGrid: false
        },
        reverseData: true,
        horizontalBars: true,
        width: 330,
        height: 180
    });

    /**
     * idk what is that
     * @type {*|jQuery}
     */
    var $tooltip = $('<div class="tooltip tooltip-hidden"></div>').appendTo($('.ct-chart'));

    /**
     * tooltip on hover chartist point
     */
    $(document).on('mouseenter', '.ct-point', function () {
        var seriesName = $(this).closest('.ct-series').attr('ct:series-name'),
            value = $(this).attr('ct:value');

        $tooltip.text(seriesName + ': ' + value);
        $tooltip.removeClass('tooltip-hidden');
    });

    $(document).on('mouseleave', '.ct-point', function () {
        $tooltip.addClass('tooltip-hidden');
    });

    $(document).on('mousemove', '.ct-point', function (event) {
        console.log(event);
        $tooltip.css({
            left: (event.offsetX || event.originalEvent.layerX) - $tooltip.width() / 2,
            top: (event.offsetY || event.originalEvent.layerY) - $tooltip.height() - 20
        });
    });

    if ($('body').hasClass('sidebar-hover')) sidebarHover();

    /**
     * clock event tooltip
     */
    $('span.tooltip-item').click(function () {
        generate('Предстоящее событие',
            'images/ballicons 2/svg/watch.svg',
            '15:43<br><br>Отправить письмо Бобу', '', '');
    });

    /**
     * calendar form date picker
     */
    $("#eventDate").datepicker({
        numberOfMonths: 1,
        prevText: '<i class="fa fa-chevron-left"></i>',
        nextText: '<i class="fa fa-chevron-right"></i>',
        showButtonPanel: false,
        beforeShow: function (input, inst) {
            var newclass = 'admin-form';
            var themeClass = $(this).parents('.admin-form').attr('class');
            var smartpikr = inst.dpDiv.parent();
            if (!smartpikr.hasClass(themeClass)) {
                inst.dpDiv.wrap('<div class="' + themeClass + '"></div>');
            }
        }

    });

// Init FullCalendar external events
    $('#external-events .fc-event').each(function () {
        // store data so the calendar knows to render an event upon drop
        $(this).data('event', {
            title: $.trim($(this).text()), // use the element's text as the event title
            stick: true, // maintain when user navigates (see docs on the renderEvent method)
            className: 'fc-event-' + $(this).attr('data-event') // add a contextual class name from data attr
        });

        // make the event draggable using jQuery UI
        $(this).draggable({
            zIndex: 999,
            revert: true, // will cause the event to go back to its
            revertDuration: 0 //  original position after the drag
        });

    });

    var Calendar = $('#calendar');

// Init FullCalendar Plugin
    Calendar.fullCalendar({
        height: 450,
        header: {
            left: 'prev,next',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        editable: true,
        viewRender: function (view) {
            // Update mini calendar title
            var titleContainer = $('.fc-title-clone');
            if (!titleContainer.length) {
                return;
            }
            titleContainer.html(view.title);
        },
        droppable: true, // this allows things to be dropped onto the calendar
        drop: function () {
            // is the "remove after drop" checkbox checked?
            if (!$(this).hasClass('event-recurring')) {
                $(this).remove();
            }
        },
        eventRender: function (event, element) {
            // create event tooltip using bootstrap tooltips
            $(element).attr("data-original-title", event.title);
            $(element).tooltip({
                container: 'body',
                delay: {
                    "show": 100,
                    "hide": 200
                }
            });
            // create a tooltip auto close timer
            $(element).on('show.bs.tooltip', function () {
                var autoClose = setTimeout(function () {
                    $('.tooltip').fadeOut();
                }, 3500);
            });
        }
    });

});

/* ==========================================================*/
/* PLUGINS                                                   */
/* ========================================================= */

/**** Sortable Portlets ****/
function sortablePortlets(){
    if ($('.portlets').length && $.fn.sortable) {
        $( ".portlets" ).sortable({
            connectWith: ".portlets",
            handle: ".panel-header",
            items:'div.panel',
            placeholder: "panel-placeholder",
            opacity: 0.5,
            dropOnEmpty: true,
            forcePlaceholderSize: true,
            receive: function(event, ui) {
                $("body").trigger("resize");
            }
        });
    }
}

var oldIndex;
if ($('.sortable').length && $.fn.sortable) {
    $(".sortable").sortable({
        handle: ".panel-header",
        start: function(event, ui) {
            oldIndex = ui.item.index();
            ui.placeholder.height(ui.item.height() - 20);
        },
        stop: function(event, ui) {
            var newIndex = ui.item.index();

            var movingForward = newIndex > oldIndex;
            var nextIndex = newIndex + (movingForward ? -1 : 1);

            var items = $('.sortable > div');

            // Find the element to move
            var itemToMove = items.get(nextIndex);
            if (itemToMove) {

                // Find the element at the index where we want to move the itemToMove
                var newLocation = $(items.get(oldIndex));

                // Decide if it goes before or after
                if (movingForward) {
                    $(itemToMove).insertBefore(newLocation);
                } else {
                    $(itemToMove).insertAfter(newLocation);
                }
            }
        }
    });
}

/****  Show Popover  ****/
function popover() {
    if ($('[rel="popover"]').length && $.fn.popover) {
        $('[rel="popover"]').popover({
            trigger: "hover"
        });
        $('[rel="popover_dark"]').popover({
            template: '<div class="popover popover-dark"><div class="arrow"></div><h3 class="popover-title popover-title"></h3><div class="popover-content popover-content"></div></div>',
            trigger: "hover"
        });
    }
}

/* Manage Slider */
function sliderIOS(){
    if ($('.slide-ios').length && $.fn.slider) {
        $('.slide-ios').each(function () {
            $(this).sliderIOS();
        });
    }
}

/* Manage Range Slider */
function rangeSlider(){
    if ($('.range-slider').length && $.fn.ionRangeSlider) {
        $('.range-slider').each(function () {
            $(this).ionRangeSlider({
                min: $(this).data('min') ? $(this).data('min') : 0,
                max: $(this).data('max') ? $(this).data('max') : 5000,
                hideMinMax: $(this).data('hideMinMax') ? $(this).data('hideMinMax') : false,
                hideFromTo: $(this).data('hideFromTo') ? $(this).data('hideFromTo') : false,
                to: $(this).data('to') ? $(this).data('to') : '',
                step: $(this).data('step') ? $(this).data('step') : '',
                type: $(this).data('type') ? $(this).data('type') : 'double',
                prefix: $(this).data('prefix') ? $(this).data('prefix') : '',
                postfix: $(this).data('postfix') ? $(this).data('postfix') : '',
                maxPostfix: $(this).data('maxPostfix') ? $(this).data('maxPostfix') : '',
                hasGrid: $(this).data('hasGrid') ? $(this).data('hasGrid') : false
            });
        });
    }
}

function inputSelect(){

    if($.fn.select2){
        setTimeout(function () {
            $('select').each(function(){
                function format(state) {
                    var state_id = state.id;
                    if (!state_id)  return state.text; // optgroup
                    var res = state_id.split("-");
                    if(res[0] == 'image') {
                        if(res[2]) return "<img class='flag' src='images/flags/" + res[1].toLowerCase() + "-" + res[2].toLowerCase() +".png' style='width:27px;padding-right:10px;margin-top: -3px;'/>" + state.text;
                        else return "<img class='flag' src='images/flags/" + res[1].toLowerCase() + ".png' style='width:27px;padding-right:10px;margin-top: -3px;'/>" + state.text;
                    }
                    else {
                        return state.text;
                    }
                }
                $(this).select2({
                    formatResult: format,
                    formatSelection: format,
                    placeholder: $(this).data('placeholder') ?  $(this).data('placeholder') : '',
                    allowClear: $(this).data('allowclear') ? $(this).data('allowclear') : true,
                    minimumInputLength: $(this).data('minimumInputLength') ? $(this).data('minimumInputLength') : -1,
                    minimumResultsForSearch: $(this).data('search') ? 1 : -1,
                    dropdownCssClass: $(this).data('style') ? 'form-white' : ''
                });
            });

        }, 200);
    }
}

function inputTags(){
    $('.select-tags').each(function(){
        $(this).tagsinput({
            tagClass: 'label label-primary'
        });
    });

}

/****  Summernote Editor  ****/
function editorSummernote(){
    if ($('.summernote').length && $.fn.summernote) {
        $('.summernote').each(function () {
            $(this).summernote({
                height: 300,
                airMode : $(this).data('airmode') ? $(this).data('airmode') : false,
                airPopover: [
                    ["style", ["style"]],
                    ['color', ['color']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']]
                ],
                toolbar: [
                    ["style", ["style"]],
                    ["style", ["bold", "italic", "underline", "clear"]],
                    ["fontsize", ["fontsize"]],
                    ["color", ["color"]],
                    ["para", ["ul", "ol", "paragraph"]],
                    ["height", ["height"]],
                    ["table", ["table"]]
                ]
            });
        });
    }
}

/****  Animated Panels  ****/
function liveTile() {

    if ($('.live-tile').length && $.fn.liveTile) {
        $('.live-tile').each(function () {
            $(this).liveTile("destroy", true); /* To get new size if resize event */
            tile_height = $(this).data("height") ? $(this).data("height") : $(this).find('.panel-body').height() + 52;
            $(this).height(tile_height);
            $(this).liveTile({
                speed: $(this).data("speed") ? $(this).data("speed") : 500, // Start after load or not
                mode: $(this).data("animation-easing") ? $(this).data("animation-easing") : 'carousel', // Animation type: carousel, slide, fade, flip, none
                playOnHover: $(this).data("play-hover") ? $(this).data("play-hover") : false, // Play live tile on hover
                repeatCount: $(this).data("repeat-count") ? $(this).data("repeat-count") : -1, // Repeat or not (-1 is infinite
                delay: $(this).data("delay") ? $(this).data("delay") : 0, // Time between two animations
                startNow: $(this).data("start-now") ? $(this).data("start-now") : true //Start after load or not
            });
        });
    }
}

function animateNumber(){
    $('.countup').each(function(){
        from     = $(this).data("from") ? $(this).data("from") : 0;
        to       = $(this).data("to") ? $(this).data("to") : 100;
        duration = $(this).data("duration") ? $(this).data("duration") : 2;
        delay    = $(this).data("delay") ? $(this).data("delay") : 1000;
        decimals = $(this).data("decimals") ? $(this).data("decimals") : 0;
        var options = {useEasing : true, useGrouping : true,  separator : ',', prefix : $(this).data("prefix") ? $(this).data("  prefix") : '', suffix : $(this).data("suffix") ? $(this).data("suffix") : ''
        }
        var numAnim = new countUp($(this).get(0),from, to, decimals, duration, options);
        setTimeout(function(){
            numAnim.start();
        },delay);
    });
}

/****  Initiation of Main Functions  ****/
$(document).ready(function () {

    sortablePortlets();
    popover();
    sliderIOS();
    rangeSlider();
    inputSelect();
    inputTags();
    editorSummernote();
    liveTile();
    animateNumber();

});