<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

\frontend\assets\FrontendAsset::register($this);
$this->registerCssFile('@web/css/icons/font-awesome/css/font-awesome.min.css');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="shortcut icon" href="/images/favicon.png" type="image/png">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?= Html::csrfMetaTags() ?>
    <?php $this->registerJsFile('@web/plugins/modernizr/modernizr-2.6.2-respond-1.1.0.min.js',
        ['position' => \yii\web\View::POS_HEAD]) ?>
    <?php $this->registerCssFile('//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=cyrillic,latin',
        ['position' => \yii\web\View::POS_HEAD]) ?>
    <?php $this->registerCssFile('//fonts.googleapis.com/css?family=Roboto:400,300,500&subset=latin,cyrillic',
        ['position' => \yii\web\View::POS_HEAD]) ?>
</head>
<body class="fixed-topbar fixed-sidebar theme-sdtl color-default">

<?php $this->beginBody() ?>

    <!--[if lt IE 7]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
        your browser</a> to improve your experience.</p>
    <![endif]-->
    <section>
    <!-- BEGIN SIDEBAR -->
    <div class="sidebar">
    <div class="logopanel">
        <h1>
            <a href=""></a>
        </h1>
    </div>
    <div class="sidebar-inner">
    <div class="sidebar-top big-img">
        <div class="user-image">
            <img src="images/avatars/avatar1_big.png" class="img-responsive img-circle" alt="me">
        </div>
        <h4>Bryan Raynolds</h4>

        <div class="dropdown user-login">
            <button class="btn btn-xs dropdown-toggle btn-rounded" type="button" data-toggle="dropdown"
                    data-hover="dropdown" data-close-others="true" data-delay="300">
                <i class="online"></i><span>Available</span> <i class="fa fa-angle-down"></i>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a href="#"><i class="busy"></i>
                        <span>Busy</span></a>
                </li>
                <li>
                    <a href="#"><i class="turquoise"></i>
                        <span>Invisible</span></a>
                </li>
                <li>
                    <a href="#"><i class="away"></i>
                        <span>Away</span></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="menu-title">
        Navigation
        <div class="pull-right menu-settings">
            <ul class="dropdown-menu">
                <li>
                    <a href="#" id="reorder-menu" class="reorder-menu">Reorder menu</a>
                </li>
                <li>
                    <a href="#" id="remove-menu" class="remove-menu">Remove elements</a>
                </li>
                <li>
                    <a href="#" id="hide-top-sidebar" class="hide-top-sidebar">Hide user &amp; search</a>
                </li>
            </ul>
        </div>
    </div>
    <ul class="nav nav-sidebar">
        <li class="nav-active active"><a href="dashboard.html"><i class="icon-home"></i>
                <span data-translate="dashboard">Dashboard</span></a>
        </li>
        <li class="nav-parent">
            <a href="#"><i class="icon-puzzle"></i><span data-translate="builder">Builder</span>
                <span class="fa arrow"></span></a>
            <ul class="children collapse">
                <li>
                    <a target="_blank" href="../builder/admin-builder/index.html"> Admin</a>
                </li>
                <li>
                    <a href="../builder/page-builder/index.html"> Page</a>
                </li>
                <li>
                    <a href="ecommerce-pricing-table.html"> Pricing Table</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="../frontend/one-page.html" target="_blank"><i class="fa fa-laptop"></i>
                <span class="pull-right badge badge-primary hidden-st">New</span>
                <span data-translate="Frontend">Frontend</span></a>
        </li>
        <li class="nav-parent">
            <a href="#"><i class="icon-bulb"></i><span data-translate="Mailbox">Mailbox</span>
                <span class="fa arrow"></span></a>
            <ul class="children collapse">
                <li>
                    <a href="mailbox-emails.html"><span class="pull-right badge badge-danger">Hot</span> Email Templates</a>
                </li>
            </ul>
        </li>
        <li class="nav-parent">
            <a href=""><i class="icon-screen-desktop"></i><span data-translate="ui elements">UI Elements</span><span
                    class="fa arrow"></span></a>
            <ul class="children collapse">
                <li><a href="ui-buttons.html" data-translate="buttons"> Buttons</a>
                </li>
                <li><a href="ui-components.html" data-translate="components"> Components</a>
                </li>
                <li><a href="ui-tabs.html" data-translate="tabs"> Tabs</a>
                </li>
                <li><a href="ui-animations.html" data-translate="animations css3"> Animations CSS3</a>
                </li>
                <li><a href="ui-icons.html" data-translate="icons"> Icons</a>
                </li>
                <li><a href="ui-portlets.html" data-translate="portlets"> Portlets</a>
                </li>
                <li><a href="ui-nestable-list.html" data-translate="nestable list"> Nestable List</a>
                </li>
                <li><a href="ui-tree-view.html" data-translate="tree view"> Tree View</a>
                </li>
                <li><a href="ui-modals.html" data-translate="modals"> Modals</a>
                </li>
                <li><a href="ui-notifications.html" data-translate="notifications"> Notifications</a>
                </li>
                <li><a href="ui-typography.html" data-translate="typography"> Typography</a>
                </li>
                <li><a href="ui-helper.html" data-translate="helper"> Helper Classes</a>
                </li>
            </ul>
        </li>
        <li class="nav-parent">
            <a href=""><i class="icon-layers"></i><span data-translate="layouts">Layouts</span><span
                    class="fa arrow"></span></a>
            <ul class="children collapse">
                <li><a href="layouts-api.html" data-translate=""> Layout API</a>
                </li>
                <li><a href="layout-topbar-mega-menu.html" data-translate=""> Topbar Menu</a>
                </li>
                <li><a href="layout-topbar-mega-menu.html" data-translate=""> Topbar Mega Menu</a>
                </li>
                <li><a href="layout-topbar-mega-menu-dark.html" data-translate=""> Topbar Mega Dark</a>
                </li>
                <li><a href="layout-sidebar-top.html" data-translate=""> Sidebar on Top</a>
                </li>
                <li><a href="layout-sidebar-hover.html" data-translate=""> Sidebar on Hover</a>
                </li>
                <li><a href="layout-submenu-hover.html" data-translate=""> Sidebar Submenu Hover</a>
                </li>
                <li><a href="layout-sidebar-condensed.html" data-translate=""> Sidebar Condensed</a>
                </li>
                <li><a href="layout-sidebar-light.html" data-translate=""> Sidebar Light</a>
                </li>
                <li><a href="layout-right-sidebar.html" data-translate=""> Right Sidebar</a>
                </li>
                <li><a href="layout-boxed.html" data-translate=""> Boxed Layout</a>
                </li>
                <li><a href="layout-collapsed-sidebar.html" data-translate=""> Collapsed Sidebar</a>
                </li>
            </ul>
        </li>
        <li class="nav-parent">
            <a href=""><i class="icon-note"></i><span data-translate="forms">Forms </span><span class="fa arrow"></span></a>
            <ul class="children collapse">
                <li><a href="forms.html"> Forms Elements</a>
                </li>
                <li><a href="forms-validation.html"> Forms Validation</a>
                </li>
                <li><a href="forms-plugins.html"> Advanced Plugins</a>
                </li>
                <li>
                    <a href="forms-wizard.html"> <span class="pull-right badge badge-danger">low</span> <span
                            data-translate="form-wizard">Form Wizard</span>
                    </a>
                </li>
                <li><a href="forms-sliders.html" data-translate="sliders"> Sliders</a>
                </li>
                <li><a href="forms-editors.html" data-translate="text editors"> Text Editors</a>
                </li>
                <li><a href="forms-input-masks.html" data-translate="input masks"> Input Masks</a>
                </li>
            </ul>
        </li>
        <li class="nav-parent">
            <a href=""><i class="fa fa-table"></i><span data-translate="medias manager">Tables</span><span
                    class="fa arrow"></span></a>
            <ul class="children collapse">
                <li><a href="tables.html" data-translate="tables styling"> Tables Styling</a>
                </li>
                <li><a href="tables-dynamic.html" data-translate="tables dynamic"> Tables Dynamic</a>
                </li>
                <li><a href="tables-filter.html" data-translate="tables filter"> Tables Filter</a>
                </li>
                <li><a href="tables-editable.html" data-translate="tables editable"> Tables Editable</a>
                </li>
            </ul>
        </li>
        <li class="nav-parent">
            <a href=""><i class="icon-bar-chart"></i><span data-translate="charts">Charts </span><span
                    class="fa arrow"></span></a>
            <ul class="children collapse">
                <li><a href="charts.html" data-translate="image croping"> Charts</a>
                </li>
                <li><a href="charts-finance.html" data-translate="gallery sortable"> Financial Charts</a>
                </li>
            </ul>
        </li>
        <li class="nav-parent">
            <a href=""><i class="icon-picture"></i><span data-translate="medias manager">Medias</span><span
                    class="fa arrow"></span></a>
            <ul class="children collapse">
                <li><a href="medias-image-croping.html" data-translate="image croping"> Images Croping</a>
                </li>
                <li><a href="medias-gallery-sortable.html" data-translate="gallery sortable"> Gallery Sortable</a>
                </li>
                <li>
                    <a href="medias-hover-effects.html" data-translate="hover effects"> <span
                            class="pull-right badge badge-primary">12</span> Hover Effects</a>
                </li>
            </ul>
        </li>
        <li class="nav-parent">
            <a href=""><i class="icon-docs"></i><span data-translate="pages">Pages </span><span class="fa arrow"></span></a>
            <ul class="children collapse">
                <li><a href="page-timeline.html"> Timeline</a>
                </li>
                <li><a href="page-404.html"> Error 404</a>
                </li>
                <li><a href="page-500.html"> Error 500</a>
                </li>
                <li><a href="page-blank.html"> Blank Page</a>
                </li>
                <li><a href="page-contact.html"> Contact</a>
                </li>
            </ul>
        </li>
        <li class="nav-parent">
            <a href=""><i class="icon-user"></i><span data-translate="pages">User </span><span class="fa arrow"></span></a>
            <ul class="children collapse">
                <li>
                    <a href="user-profil.html"> <span class="pull-right badge badge-danger">Hot</span> Profil</a>
                </li>
                <li><a href="user-lockscreen.html"> Lockscreen</a>
                </li>
                <li><a href="user-login-v1.html"> Login / Register</a>
                </li>
                <li><a href="user-login-v2.html"> Login / Register v2</a>
                </li>
                <li><a href="user-session-timeout.html"> Session Timeout</a>
                </li>
            </ul>
        </li>
        <li class="nav-parent">
            <a href=""><i class="icon-basket"></i><span data-translate="pages">eCommerce </span><span
                    class="fa arrow"></span></a>
            <ul class="children collapse">
                <li><a href="ecommerce-cart.html"> Shopping Cart</a>
                </li>
                <li><a href="ecommerce-invoice.html"> Invoice</a>
                </li>
                <li><a href="ecommerce-pricing-table.html"><span class="pull-right badge badge-success">5</span> Pricing
                        Table</a>
                </li>
            </ul>
        </li>
        <li class="nav-parent">
            <a href=""><i class="icon-cup"></i><span>Extra </span><span class="fa arrow"></span></a>
            <ul class="children collapse">
                <li><a href="extra-fullcalendar.html"><span class="pull-right badge badge-primary">New</span>
                        Fullcalendar</a>
                </li>
                <li><a href="extra-widgets.html"> Widgets</a>
                </li>
                <li><a href="page-coming-soon.html"> Coming Soon</a>
                </li>
                <li><a href="extra-sliders.html"> Sliders</a>
                </li>
                <li><a href="maps-google.html"> Google Maps</a>
                </li>
                <li><a href="maps-vector.html"> Vector Maps</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- SIDEBAR WIDGET FOLDERS -->
    <div class="sidebar-widgets">
        <p class="menu-title widget-title">Folders <span class="pull-right"><a href="#" class="new-folder"> <i
                        class="icon-plus"></i></a></span>
        </p>
        <ul class="folders">
            <li>
                <a href="#"><i class="icon-doc c-primary"></i>My documents</a>
            </li>
            <li>
                <a href="#"><i class="icon-picture"></i>My images</a>
            </li>
            <li><a href="#"><i class="icon-lock"></i>Secure data</a>
            </li>
            <li class="add-folder">
                <input type="text" placeholder="Folder's name..." class="form-control input-sm">
            </li>
        </ul>
    </div>
    <div class="sidebar-footer clearfix">
        <a class="pull-left toggle_fullscreen" href="#" data-rel="tooltip" data-placement="top"
           data-original-title="Fullscreen">
            <i class="icon-size-fullscreen"></i>
        </a>
        <a class="pull-left" href="#" data-rel="tooltip" data-placement="top" data-original-title="Lockscreen">
            <i class="icon-lock"></i>
        </a>
        <a class="pull-left btn-effect" href="#" data-modal="modal-1" data-rel="tooltip" data-placement="top"
           data-original-title="Logout">
            <i class="icon-power"></i>
        </a>
    </div>
    </div>
    </div>
    <!-- END SIDEBAR -->

    <?= $content ?>

    <!-- BEGIN BUILDER -->
    <div class="builder hidden-sm hidden-xs" id="builder">
        <a class="builder-toggle"><i class="icon-wrench"></i></a>
        <div class="inner">
            <div class="builder-container">
                <a href="#" class="btn btn-sm btn-default" id="reset-style">reset default style</a>
                <h4>Layout options</h4>
                <div class="layout-option">
                    <span> Fixed Sidebar</span>
                    <label class="switch pull-right">
                        <input data-layout="sidebar" id="switch-sidebar" type="checkbox" class="switch-input" checked>
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                    </label>
                </div>
                <div class="layout-option">
                    <span> Sidebar on Hover</span>
                    <label class="switch pull-right">
                        <input data-layout="sidebar-hover" id="switch-sidebar-hover" type="checkbox" class="switch-input">
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                    </label>
                </div>
                <div class="layout-option">
                    <span>Fixed Topbar</span>
                    <label class="switch pull-right">
                        <input data-layout="topbar" id="switch-topbar" type="checkbox" class="switch-input" checked>
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                    </label>
                </div>
                <div class="layout-option">
                    <span> Sidebar on Top</span>
                    <label class="switch pull-right">
                        <input data-layout="sidebar-top" id="switch-sidebar-top" type="checkbox" class="switch-input">
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                    </label>
                </div>
                <h4 class="border-top">Color</h4>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="theme-color bg-dark" data-main="default" data-color="#2B2E33"></div>
                        <div class="theme-color background-primary" data-main="primary" data-color="#319DB5"></div>
                        <div class="theme-color bg-red" data-main="red" data-color="#C75757"></div>
                        <div class="theme-color bg-green" data-main="green" data-color="#1DA079"></div>
                        <div class="theme-color bg-orange" data-main="orange" data-color="#D28857"></div>
                        <div class="theme-color bg-purple" data-main="purple" data-color="#B179D7"></div>
                        <div class="theme-color bg-blue" data-main="blue" data-color="#4A89DC"></div>
                    </div>
                </div>
                <h4 class="border-top">Theme</h4>
                <div class="row row-sm">
                    <div class="col-xs-6">
                        <div class="theme clearfix sdtl" data-theme="sdtl">
                            <div class="header theme-left"></div>
                            <div class="header theme-right-light"></div>
                            <div class="theme-sidebar-dark"></div>
                            <div class="bg-light"></div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="theme clearfix sltd" data-theme="sltd">
                            <div class="header theme-left"></div>
                            <div class="header theme-right-dark"></div>
                            <div class="theme-sidebar-light"></div>
                            <div class="bg-light"></div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="theme clearfix sdtd" data-theme="sdtd">
                            <div class="header theme-left"></div>
                            <div class="header theme-right-dark"></div>
                            <div class="theme-sidebar-dark"></div>
                            <div class="bg-light"></div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="theme clearfix sltl" data-theme="sltl">
                            <div class="header theme-left"></div>
                            <div class="header theme-right-light"></div>
                            <div class="theme-sidebar-light"></div>
                            <div class="bg-light"></div>
                        </div>
                    </div>
                </div>
                <h4 class="border-top">Background</h4>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="bg-color bg-clean" data-bg="clean" data-color="#F8F8F8"></div>
                        <div class="bg-color bg-lighter" data-bg="lighter" data-color="#EFEFEF"></div>
                        <div class="bg-color bg-light-default" data-bg="light-default" data-color="#E9E9E9"></div>
                        <div class="bg-color bg-light-blue" data-bg="light-blue" data-color="#E2EBEF"></div>
                        <div class="bg-color bg-light-purple" data-bg="light-purple" data-color="#E9ECF5"></div>
                        <div class="bg-color bg-light-dark" data-bg="light-dark" data-color="#DCE1E4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END BUILDER -->
    </section>
<!-- BEGIN QUICKVIEW SIDEBAR -->
<div id="quickview-sidebar">
<div class="quickview-header">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#notes" data-toggle="tab">Notes</a>
        </li>
        <li><a href="#settings" data-toggle="tab" class="settings-tab">Settings</a>
        </li>
    </ul>
</div>
<div class="quickview">
<div class="tab-content">
<div class="tab-pane fade active in" id="notes">
    <div class="list-notes current withScroll">
        <div class="notes">
            <div class="row">
                <div class="col-md-12">
                    <div id="add-note">
                        <i class="fa fa-plus"></i>ADD A NEW NOTE
                    </div>
                </div>
            </div>
            <div id="notes-list">
                <div class="note-item media current fade in">
                    <button class="close">×</button>
                    <div>
                        <div>
                            <p class="note-name">Reset my account password</p>
                        </div>
                        <p class="note-desc hidden">Break security reasons.</p>
                        <p><small>Tuesday 6 May, 3:52 pm</small>
                        </p>
                    </div>
                </div>
                <div class="note-item media fade in">
                    <button class="close">×</button>
                    <div>
                        <div>
                            <p class="note-name">Call John</p>
                        </div>
                        <p class="note-desc hidden">He have my laptop!</p>
                        <p><small>Thursday 8 May, 2:28 pm</small>
                        </p>
                    </div>
                </div>
                <div class="note-item media fade in">
                    <button class="close">×</button>
                    <div>
                        <div>
                            <p class="note-name">Buy a car</p>
                        </div>
                        <p class="note-desc hidden">I'm done with the bus</p>
                        <p><small>Monday 12 May, 3:43 am</small>
                        </p>
                    </div>
                </div>
                <div class="note-item media fade in">
                    <button class="close">×</button>
                    <div>
                        <div>
                            <p class="note-name">Don't forget my notes</p>
                        </div>
                        <p class="note-desc hidden">I have to read them...</p>
                        <p><small>Wednesday 5 May, 6:15 pm</small>
                        </p>
                    </div>
                </div>
                <div class="note-item media current fade in">
                    <button class="close">×</button>
                    <div>
                        <div>
                            <p class="note-name">Reset my account password</p>
                        </div>
                        <p class="note-desc hidden">Break security reasons.</p>
                        <p><small>Tuesday 6 May, 3:52 pm</small>
                        </p>
                    </div>
                </div>
                <div class="note-item media fade in">
                    <button class="close">×</button>
                    <div>
                        <div>
                            <p class="note-name">Call John</p>
                        </div>
                        <p class="note-desc hidden">He have my laptop!</p>
                        <p><small>Thursday 8 May, 2:28 pm</small>
                        </p>
                    </div>
                </div>
                <div class="note-item media fade in">
                    <button class="close">×</button>
                    <div>
                        <div>
                            <p class="note-name">Buy a car</p>
                        </div>
                        <p class="note-desc hidden">I'm done with the bus</p>
                        <p><small>Monday 12 May, 3:43 am</small>
                        </p>
                    </div>
                </div>
                <div class="note-item media fade in">
                    <button class="close">×</button>
                    <div>
                        <div>
                            <p class="note-name">Don't forget my notes</p>
                        </div>
                        <p class="note-desc hidden">I have to read them...</p>
                        <p><small>Wednesday 5 May, 6:15 pm</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="detail-note note-hidden-sm">
        <div class="note-header clearfix">
            <div class="note-back">
                <i class="icon-action-undo"></i>
            </div>
            <div class="note-edit">Edit Note</div>
            <div class="note-subtitle">title on first line</div>
        </div>
        <div id="note-detail">
            <div class="note-write">
                <textarea class="form-control" placeholder="Type your note here"></textarea>
            </div>
        </div>
    </div>
</div>
<div class="tab-pane fade" id="settings">
    <div class="settings">
        <div class="title">ACCOUNT SETTINGS</div>
        <div class="setting">
            <span> Show Personal Statut</span>
            <label class="switch pull-right">
                <input type="checkbox" class="switch-input" checked>
                <span class="switch-label" data-on="On" data-off="Off"></span>
                <span class="switch-handle"></span>
            </label>
            <p class="setting-info">Lorem ipsum dolor sit amet consectetuer.</p>
        </div>
        <div class="setting">
            <span> Show my Picture</span>
            <label class="switch pull-right">
                <input type="checkbox" class="switch-input" checked>
                <span class="switch-label" data-on="On" data-off="Off"></span>
                <span class="switch-handle"></span>
            </label>
            <p class="setting-info">Lorem ipsum dolor sit amet consectetuer.</p>
        </div>
        <div class="setting">
            <span> Show my Location</span>
            <label class="switch pull-right">
                <input type="checkbox" class="switch-input">
                <span class="switch-label" data-on="On" data-off="Off"></span>
                <span class="switch-handle"></span>
            </label>
            <p class="setting-info">Lorem ipsum dolor sit amet consectetuer.</p>
        </div>
        <div class="title">CHAT</div>
        <div class="setting">
            <span> Show User Image</span>
            <label class="switch pull-right">
                <input type="checkbox" class="switch-input" checked>
                <span class="switch-label" data-on="On" data-off="Off"></span>
                <span class="switch-handle"></span>
            </label>
        </div>
        <div class="setting">
            <span> Show Fullname</span>
            <label class="switch pull-right">
                <input type="checkbox" class="switch-input" checked>
                <span class="switch-label" data-on="On" data-off="Off"></span>
                <span class="switch-handle"></span>
            </label>
        </div>
        <div class="setting">
            <span> Show Location</span>
            <label class="switch pull-right">
                <input type="checkbox" class="switch-input">
                <span class="switch-label" data-on="On" data-off="Off"></span>
                <span class="switch-handle"></span>
            </label>
        </div>
        <div class="setting">
            <span> Show Unread Count</span>
            <label class="switch pull-right">
                <input type="checkbox" class="switch-input" checked>
                <span class="switch-label" data-on="On" data-off="Off"></span>
                <span class="switch-handle"></span>
            </label>
        </div>
        <div class="m-t-30" style="width:100%">
            <canvas id="setting-chart" height="300"></canvas>
        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- END QUICKVIEW SIDEBAR -->
<!-- BEGIN PRELOADER -->
<div class="loader-overlay">
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>
<!-- END PRELOADER -->
<a href="#" class="scrollup"><i class="fa fa-angle-up"></i></a>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
