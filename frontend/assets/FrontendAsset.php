<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
        'css/theme.css',
        'css/ui.css',
        'css/icons/font-awesome/css/font-awesome.min.css',
        'css/icons/glyphicons-pro/glyphicons-pro.css',
        'plugins/animation-css/animate.min.css',
        'plugins/mcustom-scrollbar/mcustom_scrollbar.min.css',
        'plugins/select2/select2.css',
        'plugins/slick/slick.css',
        'plugins/fullcalendar/fullcalendar.min.css',
        'plugins/icheck/skins/all.css',
        'plugins/bootstrap-editable/css/jasny-bootstrap.min.css',
        'plugins/bootstrap-editable/css/bootstrap-editable.css',
    ];

    public $js = [
        'plugins/jquery/jquery-migrate-1.2.1.min.js',
        'plugins/jquery-ui/jquery-ui-1.11.2.min.js',
        'plugins/gsap/main-gsap.min.js',
        'plugins/jquery-cookies/jquery.cookies.min.js',
        'js/landing/bootstrap.min.js',
        'plugins/jquery-block-ui/jquery.blockUI.min.js',
        'plugins/mcustom-scrollbar/jquery.mCustomScrollbar.concat.min.js',
        'plugins/bootstrap-dropdown/bootstrap-hover-dropdown.min.js',
        'plugins/retina/retina.min.js',
        'plugins/icheck/icheck.min.js',
        'plugins/bootstrap-progressbar/bootstrap-progressbar.min.js',
        'plugins/bootstrap-editable/js/bootstrap-editable.min.js',
        'plugins/bootstrap-context-menu/bootstrap-contextmenu.min.js',
        'plugins/multidatepicker/multidatespicker.min.js',
        'plugins/jquery-translator/jqueryTranslator.min.js',
        'plugins/noty/jquery.noty.packaged.js',
        'plugins/countup/countUp.min.js',
        'plugins/fullcalendar/lib/moment.min.js',
        'plugins/fullcalendar/lang/ru.js',
        'plugins/fullcalendar/fullcalendar.min.js',
        'js/widgets/todo_list.js',
        'js/builder.js',
        'js/sidebar_hover.js',
        'js/application.js',
        'js/plugins.js',
        'js/widgets/notes.js',
        'js/widgets/widget_weather.js',
        'js/pages/dashboard.js',
        'js/pages/translation.js',
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_END
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\assets\Html5shiv',
    ];
}
