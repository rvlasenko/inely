<?php use yii\helpers\Html; ?>

<header class="navbar bg-light">
    <ul class="nav panel-tabs-border panel-tabs panel-tabs-left">
        <li class="active"><a href="/">Dashboard</a></li>
        <li class=""><a href="/calendar">Calendar</a></li>
        <li class=""><a href="/todo">Tasks</a></li>
        <li class=""><a href="/support">Support</a></li>
    </ul>

    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown dropdown-item-slide">
            <a class="dropdown-toggle pl10 pr10" data-toggle="dropdown" href="#">
                <span class="fa fa fa-bell fs21"></span>
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
        <li class="ph10 pv20 hidden-xs"><i class="fa fa-circle text-tp fs8"></i></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown">
                <img src="images/avatars/4.jpg" alt="avatar" class="mw30 br64 mr15">
                <span><?= Yii::$app->user->identity->username ?></span>
                <span class="caret caret-tp hidden-xs"></span>
            </a>
            <ul class="dropdown-menu dropdown-persist pn user bg-white animated animated-shorter zoomIn" role="menu">
                <li class="of-h">
                    <?= Html::a('<span class="fa fa-user fs15 pr5"></span> My Profile', [ '' ], [
                        'class' => 'p12 animated animated-short fadeInDown'
                    ]) ?>
                </li>
                <li class="br-t of-h">
                    <?= Html::a('<span class="fa fa-gear fs15 pr5"></span> Account Settings', [ '' ], [
                        'class' => 'p12 animated animated-short fadeInDown'
                    ]) ?>
                </li>
                <li class="br-t of-h">
                    <?= Html::a('<span class="fa fa-trash-o fs15 pr5"></span> Clear Storage', [ '/' ], [
                        'class' => 'p12 animated animated-short fadeInDown',
                        'id' => 'clearLocalStorage'
                    ]) ?>
                </li>
                <li class="br-t of-h">
                    <?= Html::a('<span class="fa fa-power-off fs15 pr5"></span>Logout', [ '/logout' ], [
                        'class' => 'p12 animated animated-short fadeInDown', 'data-method' => 'post'
                    ]) ?>
                </li>
            </ul>
        </li>
    </ul>

</header>