<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace backend\assets;

use Yii;
use yii\web\AssetBundle;
use yii\web\View;

class TaskAsset extends AssetBundle
{
    public $basePath = '/';
    public $baseUrl  = '@backendUrl';

    public $css = [
        'http://fonts.googleapis.com/css?family=Open+Sans:400,600&subset=latin,cyrillic',

        'css/theme.css',
        'css/animate.css',
        'vendor/plugins/magnific/magnific-popup.css',
        'vendor/plugins/jstree/themes/neutron/style.css'
    ];

    public $js = [
        'vendor/plugins/jstree/jstree.min.js',
        'vendor/plugins/magnific/jquery.magnific-popup.min.js',

        'scripts/plugins.js',
        'scripts/modules/projectTree.js',
        'scripts/modules/taskTour.js',
        'scripts/modules/sideMenu.js',
        'scripts/modules/contentTree.js',
        'scripts/app.js'

    ];

    public $jsOptions = ['position' => View::POS_END];

    public $depends = [
        'yii\web\JqueryAsset',
        'common\assets\BootstrapAsset',
        'common\assets\FontAwesome'
    ];

    public function init()
    {
        parent::init();
        Yii::$app->assetManager->bundles['common\assets\BootstrapAsset'] = ['css' => []];
    }
}