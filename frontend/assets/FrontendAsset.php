<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
        'css/theme.css',
        'css/ui.css',
        'plugins/animation-css/animate.min.css',
        'plugins/mcustom-scrollbar/mcustom_scrollbar.min.css',
        //'plugins/slick/slick.css',
        'plugins/fullcalendar/fullcalendar.min.css',
        'plugins/chartist-js-develop/dist/chartist.min.css',
    ];

    public $js = [
        //'plugins/jquery/jquery-migrate-1.2.1.min.js',
        //'plugins/jquery-ui/jquery-ui-1.11.2.min.js',
        'plugins/gsap/main-gsap.min.js',
        'plugins/jquery-cookies/jquery.cookies.min.js',
        //'plugins/jquery-block-ui/jquery.blockUI.min.js',
        'plugins/mcustom-scrollbar/jquery.mCustomScrollbar.concat.min.js',
        'plugins/retina/retina.min.js',
        'plugins/bootstrap-progressbar/bootstrap-progressbar.min.js',
        //'plugins/jquery-translator/jqueryTranslator.min.js',
        'plugins/noty/jquery.noty.packaged.js',
        'plugins/countup/countUp.min.js',
        'plugins/fullcalendar/lib/moment.min.js',
        'plugins/fullcalendar/lang/ru.js',
        'plugins/fullcalendar/fullcalendar.min.js',
        'plugins/chartist-js-develop/dist/chartist.min.js',
        //'js/widgets/todo_list.js',
        'js/builder.js',
        //'js/sidebar_hover.js',
        'js/application.js',
        'js/plugins.js',
        'js/widgets/notes.js',
        //'js/widgets/widget_weather.js',
        'js/pages/dashboard.js',
        //'js/pages/translation.js',
    ];

    public $jsOptions = [
        'position' => View::POS_END
    ];

    public $depends = [
        'frontend\assets\BowerAsset',
        'common\assets\FontAwesome',
        'yii\jui\JuiAsset'
    ];
}
