<div class="header-left">
    <div class="topnav">
        <a class="menutoggle" href="#" data-toggle="sidebar-collapsed">
            <span class="menu__handle">
                <span data-translate="menu-title">Menu</span>
            </span>
        </a>
        <ul class="nav nav-icons">
            <li>
                <a class="pull-left toggle_fullscreen" href="#" data-placement="top" data-original-title="Fullscreen">
                    <i class="fa fa-desktop"></i>
                </a>
            </li>
            <li>
                <a class="pull-left btn-effect" href="/logout" data-method="post" data-modal="modal-1" data-placement="top" data-original-title="Logout">
                    <i class="fa fa-power-off"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="header-right">
    <ul class="header-menu nav navbar-nav">
        <li class="dropdown" id="language-header">
            <a href="#" data-toggle="dropdown" data-close-others="true">
                <i class="fa fa-globe"></i>
                <span data-translate="Language">Language</span>
            </a>
            <ul class="dropdown-menu lang" id="switch-lang">
                <li>
                    <a href="#" data-lang="ru">
                        <img src="images/flags/Russia.png" alt="flag-english">
                        <span>Russian</span>
                    </a>
                </li>
                <li>
                    <a href="#" data-lang="en">
                        <img src="images/flags/USA.png" alt="flag-english">
                        <span>English</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="dropdown" id="notifications-header">
            <a href="#" data-toggle="dropdown" data-close-others="true">
                <i class="fa fa-bolt"></i>
                <span class="badge badge-success badge-header">0</span>
            </a>
            <ul class="dropdown-menu">
                <li class="dropdown-header clearfix">
                    <p class="pull-left">Ваша производительность</p>
                </li>
                <li>
                    <div class="ct-chart ct-major-fifth"></div>
                    <div class="separator"></div>
                    <p>
                        <strong>4</strong>
                        завершенные задачи
                    </p>
                    <div class="separator"></div>
                    <p>Завершено за последние 7 дней:</p>
                    <div class="ct-bar-chart ct-major-fifth"></div>
                </li>
                <li class="dropdown-footer clearfix">
                    <a href="#" class="pull-left">
                        <i class="fa fa-cog"></i>
                        Настройка ОО и целей
                    </a>
                </li>
            </ul>
        </li>

        <li class="dropdown" id="notifications-header">
            <a href="#" data-toggle="dropdown" data-close-others="true">
                <i class="fa fa-bell-o"></i>
                <span class="badge badge-danger badge-header">2</span>
            </a>
            <ul class="dropdown-menu">
                <li class="dropdown-header clearfix">
                    <p class="pull-left">2 Pending Notifications</p>
                </li>
                <li>
                    <ul class="dropdown-menu-list withScroll" data-height="220">
                        <li>
                            <a href="#">
                                <i class="fa fa-star p-r-10 f-18 c-orange"></i>Steve have rated your photo
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown-footer clearfix">
                    <a href="#" class="pull-left">See all notifications</a>
                </li>
            </ul>
        </li>


        <li class="dropdown" id="user-header">
            <a href="#">
                <img src="images/avatars/user1.png" alt="user image">
                <span class="username">Hi, <?= \Yii::$app->user->id ?></span>
            </a>
        </li>

        <li id="quickview-toggle">
            <a href="#">
                <i class="fa fa-file-text-o"></i>
            </a>
        </li>
    </ul>
</div>