<?php
    use yii\helpers\Html;

    /* @var $this \yii\web\View */
    /* @var $content string */

    frontend\assets\FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
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
<body class="theme-sdtl color-default fixed-sidebar sidebar-collapsed">

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
    <div class="menu-title">Navigation</div>
        <ul class="nav sub-nav sidebar-menu" style="">
            <li>
                <a href="admin_plugins-panels.html">
                    <span class="glyphicons glyphicons-book"></span> Admin Panels </a>
            </li>
            <li>
                <a href="admin_plugins-modals.html">
                    <span class="glyphicons glyphicons-show_big_thumbnails"></span> Admin Modals </a>
            </li>
            <li>
                <a href="admin_plugins-dock.html">
                    <span class="glyphicons glyphicons-sampler"></span> Admin Dock </a>
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
                        <input data-layout="topbar" id="switch-topbar" type="checkbox" class="switch-input">
                        <span class="switch-label" data-on="On" data-off="Off"></span>
                        <span class="switch-handle"></span>
                    </label>
                </div>
                <h4 class="border-top">Color</h4>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="theme-color bg-dark active" data-main="default" data-color="#2B2E33"></div>
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
                        <div class="theme clearfix sdtd" data-theme="sdtd">
                            <div class="header theme-left"></div>
                            <div class="header theme-right-dark"></div>
                            <div class="theme-sidebar-dark"></div>
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
                    <i class="fa fa-angle-double-left"></i>
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
