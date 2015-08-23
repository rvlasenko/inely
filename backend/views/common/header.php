<?php use yii\helpers\Html; ?>

<header class="navbar bg-light">
    <div class="navbar-branding">
        <span id="toggle_sidemenu_l" class="glyphicons glyphicons-show_lines"></span>
    </div>
    <ul class="nav navbar-nav navbar-left">
        <li class="hidden-xs">
            <a class="request-fullscreen toggle-active" href="#">
                <span class="glyphicons glyphicons-imac fs18"></span>
            </a>
        </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle pl10 pr10" data-toggle="dropdown" href="#" aria-expanded="true">
                <span class="glyphicons glyphicons-spray fs18"></span>
            </a>
            <ul class="dropdown-menu col dropdown-hover dropdown-persist pn pb5 bg-white animated animated-shorter zoomIn" role="menu">
                <li class="bg-light p8">
                    <span class="fw600 pl5 lh30">Header color</span>
                    <span class="label label-warning label-sm pull-right lh20 h-20 mt5 mr5"><a href="#" id="clearLocalStorage">Clear LocalStorage</a></span>
                </li>

                <div id="skin-toolbox" class="toolbox-open p10">
                    <form id="toolbox-header-skin">
                        <div class="skin-toolbox-swatches">
                            <div class="checkbox-custom animated animated-short fadeIn col-sm-6 checkbox-disabled fill mb5">
                                <input type="radio" name="headerSkin" id="headerSkin8" checked="" value="bg-light">
                                <label for="headerSkin8">Light</label>
                            </div>
                            <div class="checkbox-custom animated animated-short fadeIn col-sm-6 fill checkbox-primary mb5">
                                <input type="radio" name="headerSkin" id="headerSkin1" value="bg-primary">
                                <label for="headerSkin1">Primary</label>
                            </div>
                            <div class="checkbox-custom animated animated-short fadeIn col-sm-6 fill checkbox-info mb5">
                                <input type="radio" name="headerSkin" id="headerSkin3" value="bg-info">
                                <label for="headerSkin3">Info</label>
                            </div>
                            <div class="checkbox-custom animated animated-short fadeIn col-sm-6 fill checkbox-warning mb5">
                                <input type="radio" name="headerSkin" id="headerSkin4" value="bg-warning">
                                <label for="headerSkin4">Warning</label>
                            </div>
                            <div class="checkbox-custom animated animated-short fadeIn col-sm-6 fill checkbox-alert mb5">
                                <input type="radio" name="headerSkin" id="headerSkin6" value="bg-alert">
                                <label for="headerSkin6">Alert</label>
                            </div>
                            <div class="checkbox-custom animated animated-short fadeIn col-sm-6 fill checkbox-system mb5">
                                <input type="radio" name="headerSkin" id="headerSkin7" value="bg-system">
                                <label for="headerSkin7">System</label>
                            </div>
                            <div class="checkbox-custom animated animated-short fadeIn col-sm-6 fill checkbox-success mb5">
                                <input type="radio" name="headerSkin" id="headerSkin2" value="bg-success">
                                <label for="headerSkin2">Success</label>
                            </div>
                            <div class="checkbox-custom animated animated-short fadeIn col-sm-6 fill mb5">
                                <input type="radio" name="headerSkin" id="headerSkin9" value="bg-dark">
                                <label for="headerSkin9">Dark</label>
                            </div>
                        </div>
                    </form>
                </div>

            </ul>
        </li>
        <li class="dropdown dropdown-item-slide">
            <a class="dropdown-toggle pl10 pr10" data-toggle="dropdown" href="#">
                <span class="glyphicons glyphicons-bell fs18"></span>
            </a>
            <ul class="dropdown-menu noty dropdown-hover dropdown-persist pn bg-white animated animated-shorter zoomIn" role="menu">
                <li class="bg-light p8">
                    <span class="fw600 pl5 lh30"> Notifications</span>
                    <span class="label label-warning label-sm pull-right lh20 h-20 mt5 mr5">12</span>
                </li>
                <li class="p10 br-t item-1">
                    <div class="media">
                        <a class="media-left" href="#">
                            <img src="images/avatars/4.jpg" class="mw40" alt="holder-img"> </a>

                        <div class="media-body va-m">
                            <h5 class="media-heading mv5">Article
                                <small class="text-muted">- 08/16/22</small>
                            </h5>
                            Last Updated 36 days ago by
                            <a class="text-system" href="#"> Max </a>
                        </div>
                    </div>
                </li>
                <li class="p10 br-t item-2">
                    <div class="media">
                        <a class="media-left" href="#">
                            <img src="images/avatars/4.jpg" class="mw40" alt="holder-img"> </a>

                        <div class="media-body va-m">
                            <h5 class="media-heading mv5">Article
                                <small class="text-muted">- 08/16/22</small>
                            </h5>
                            Last Updated 36 days ago by
                            <a class="text-system" href="#"> Max </a>
                        </div>
                    </div>
                </li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <span class="flag-xs flag-en"></span>
                <span class="fw600"> EN </span>
            </a>
            <ul class="dropdown-menu animated animated-shorter zoomIn" role="menu">
                <li><a href="#" class="animated animated-short fadeIn fw600">
                        <span class="flag-xs flag-ru mr10"></span> Russian </a></li>
                <li><a href="#" class="animated animated-short fadeIn fw600">
                        <span class="flag-xs flag-en mr10"></span> English </a></li>
            </ul>
        </li>
        <li class="ph10 pv20 hidden-xs"><i class="fa fa-circle text-tp fs8"></i></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown">
                <img src="images/avatars/4.jpg" alt="avatar" class="mw30 br64 mr15">
                <span><?= Yii::$app->user->identity->username ?></span>
                <span class="caret caret-tp hidden-xs"></span>
            </a>
            <ul class="dropdown-menu dropdown-persist pn user bg-white" role="menu">
                <li class="of-h">
                    <?= Html::a('<span class="fa fa-user pr5"></span> My Profile
                        <span class="pull-right lh20 h-20 label label-warning label-sm">2</span>', [ '' ], [
                        'class' => 'fw600 p12 animated animated-short fadeInDown'
                    ]) ?>
                </li>
                <li class="br-t of-h">
                    <?= Html::a('<span class="fa fa-gear pr5"></span> Account Settings', [ '' ], [
                        'class' => 'fw600 p12 animated animated-short fadeInDown'
                    ]) ?>
                </li>
                <li class="br-t of-h">
                    <?= Html::a('<span class="fa fa-power-off pr5"></span>Logout', [ '/logout' ], [
                        'class' => 'fw600 p12 animated animated-short fadeInDown', 'data-method' => 'post'
                    ]) ?>
                </li>
            </ul>
        </li>
    </ul>

</header>