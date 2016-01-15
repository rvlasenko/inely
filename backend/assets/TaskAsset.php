<?php

namespace backend\assets;

use Yii;
use yii\web\AssetBundle;
use yii\web\View;

class TaskAsset extends AssetBundle
{
    public $basePath = '/';
    public $baseUrl  = '@backendUrl';

    public $css = [
        'http://fonts.googleapis.com/css?family=Open+Sans:300,400,600&subset=latin,cyrillic',

        'css/effect.css',
        'css/style.css',
        'fonts/entypo-icon/entypo-icon.css',

        'vendor/skin-select/skin-select.css',
        'vendor/gage/jquery.easy-pie-chart.css',
        'vendor/tip/tooltipster.css',
        'vendor/slidebars/slidebars.css',
        'vendor/magnific/magnific-popup.css',
        'vendor/summernote/summernote.css',
        'vendor/select2/css/select2.css'
    ];

    public $js = [
        'scripts/load.min.js',
        'scripts/app.js',

        // Древовидные списки
        'vendor/jstree/jstree.min.js',
        // Обработка горячих клавиш
        'vendor/mousetrap/mousetrap.min.js',
        // Экскурсия по веб-сайту
        'vendor/bootstrap-tour/bootstrap-tour.min.js',
        'vendor/skin-select/skin-select.js',
        // Отображение даты и цифровых часов
        'vendor/clock/jquery.clock.js',
        // Всплывающие подсказки
        'vendor/tip/jquery.tooltipster.min.js',
        // Полоса загрузки
        'vendor/pace/pace.min.js',
        // Парсинг, валидация, управление временем
        'vendor/moment/moment.min.js',
        'vendor/moment/locale/ru.min.js',
        // Виджет выбора даты/времени
        'vendor/bootstrap-datetimepicker/datetimepicker.min.js',
        'vendor/gage/jquery.easypiechart.min.js',
        'vendor/slidebars/slidebars.min.js',
        'vendor/summernote/summernote.min.js',
        'vendor/magnific/jquery.magnific-popup.min.js',
        'vendor/noty/packaged/jquery.noty.packaged.min.js',
        'vendor/select2/js/select2.min.js',

        'scripts/preload/classie.js',
        'scripts/preload/pathLoader.js',
        'scripts/preload/main.js'
    ];

    public $jsOptions = ['position' => View::POS_END];

    public $depends = [
        'yii\web\YiiAsset',
        'common\assets\BootstrapAsset',
        'common\assets\FontAwesome'
    ];
}