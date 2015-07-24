$(function () {

    $(document).on("click", ".panel-header .panel-maximize", function (event) {
        var panel = $(this).parents(".panel:first");
    });

    $(document).on("click", ".theme-color", function (event) {
        var color = $(this).data('color');
        $('#listdiv').mCustomScrollbar({
            scrollButtons: {
                enable: false
            },
            autoHideScrollbar: false,
            scrollInertia: 150,
            theme: "light-thin",
            set_height: 440,
            advanced: {
                updateOnContentResize: true
            }
        });
    });

    $('*[data-jquery-clock]').each(function () {
        var t = $(this);
        var seconds = new Date().getSeconds(),
            hours = new Date().getHours(),
            mins = new Date().getMinutes(),
            sdegree = seconds * 6,
            hdegree = hours * 30 + (mins / 2),
            mdegree = mins * 6;
        var updateWatch = function () {
            sdegree += 6;
            if (sdegree % 360 == 0)
                mdegree += 6;

            hdegree += (0.1 / 12);
            var srotate = "rotate(" + sdegree + "deg)",
                hrotate = "rotate(" + hdegree + "deg)",
                mrotate = "rotate(" + mdegree + "deg)";
            $(".jquery-clock-sec", t).css({
                "-moz-transform": srotate,
                "-webkit-transform": srotate,
                '-ms-transform': srotate
            });
            $(".jquery-clock-hour", t).css({
                "-moz-transform": hrotate,
                "-webkit-transform": hrotate,
                '-ms-transform': hrotate
            });
            $(".jquery-clock-min", t).css({
                "-moz-transform": mrotate,
                "-webkit-transform": mrotate,
                '-ms-transform': mrotate
            });
        };
        updateWatch();
        setInterval(function () {
            $(".jquery-clock-sec, .jquery-clock-hour, .jquery-clock-min").addClass('jquery-clock-transitions');
            updateWatch();
        }, 1000);
        $(window).focus(function () {
            $(".jquery-clock-sec, .jquery-clock-hour, .jquery-clock-min").addClass('jquery-clock-transitions');
        });
        $(window).blur(function () {
            $(".jquery-clock-sec, .jquery-clock-hour, .jquery-clock-min").removeClass('jquery-clock-transitions');
        });
    });
    // panel-stat-chart, visitors-chart
    var widgetMapHeight = $('.widget-map').height();
    var pstatHeadHeight = $('.panel-stat-chart').parent().find('.panel-header').height() + 12;
    var pstatBodyHeight = $('.panel-stat-chart').parent().find('.panel-body').height() + 15;
    var pstatheight = widgetMapHeight - pstatHeadHeight - pstatBodyHeight + 30;
    $('.panel-stat-chart').css('height', pstatheight);
    var clockHeight = $('.jquery-clock ').height();
    var widgetProgressHeight = $('.widget-progress-bar').height();
    $('.widget-progress-bar').css('margin-top', widgetMapHeight - clockHeight - widgetProgressHeight - 3);

    /* Progress Bar Widget */
    if ($('.widget-progress-bar').length) {
        $(window).load(function () {
            setTimeout(function () {
                $('.widget-progress-bar .stat1').progressbar();
            }, 900);
            setTimeout(function () {
                $('.widget-progress-bar .stat2').progressbar();
            }, 1200);
            setTimeout(function () {
                $('.widget-progress-bar .stat3').progressbar();
            }, 1500);
            setTimeout(function () {
                $('.widget-progress-bar .stat4').progressbar();
            }, 1800);
        });
    }
    ;
});
