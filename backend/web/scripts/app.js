/**
 * @author hirootkit <admiralexo@gmail.com>
 */

/* ===========================
 Инициализируем модули
 ============================= */
// Перед этим необходимо завести right sidebar
head.js("vendor/slidebars/slidebars.min.js");
// и плагин для иерархии
head.js("vendor/jstree/jstree.min.js");

head.js("scripts/modules/contentTree.js", function () { contentTree.init(); });
head.js("scripts/modules/projectTree.js", function () { projectTree.init(); });
//head.js("scripts/modules/taskTour.js", function () { taskTour.init(); });

/* ===========================
 Инициализируем библиотеки
 ============================= */
// Эффект слайдинга
head.js("vendor/skin-select/skin-select.js");

// Отображение даты
head.js("vendor/clock/date.js");

// Цифровые часы
head.js("vendor/clock/jquery.clock.js", function() {

    $('#digital-clock').clock();

});

// Новостной стикер
head.js("vendor/newsticker/jquery.newsTicker.min.js");

// Всплывающие подсказки
head.js("vendor/tip/jquery.tooltipster.min.js", function() {

    $('.tooltitle').tooltip({
        position: 'bottom'
    });

    $('.tooltip-tip').tooltipster({
        position: 'right',
        animation: 'slide',
        theme: '.tooltipster-shadow',
        delay: 1,
        offsetX: '-12px',
        onlyOne: true
    });

});

// Полоса загрузки
head.js("vendor/pace/pace.min.js", function() {

    paceOptions = {
        ajax: false,
        document: false
    };

});
//-------------------------------------------------------------

//NICE SCROLL
/*
 head.js("assets/js/nano/jquery.nanoscroller.js", function() {

 $(".nano").nanoScroller({
 //stop: true
 scroll: 'top',
 scrollTop: 0,
 sliderMinHeight: 40,
 preventPageScrolling: true
 //alwaysVisible: false

 });

 });*/



//-------------------------------------------------------------

/*
 head.js("vendor/gage/raphael.2.1.0.min.js", "vendor/gage/justgage.js", function() {

 var g1;
 window.onload = function() {
 var g1 = new JustGage({
 id: "g1",
 value: getRandomInt(0, 1000),
 min: 0,
 max: 1000,
 relativeGaugeSize: true,
 gaugeColor: "rgba(0,0,0,0.4)",
 levelColors: "#0DB8DF",
 labelFontColor : "#ffffff",
 titleFontColor: "#ffffff",
 valueFontColor :"#ffffff",
 label: "VISITORS",
 gaugeWidthScale: 0.2,
 donut: true
 });
 };



 });*/