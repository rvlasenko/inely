<nav role="navigation" class="navbar navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <div id="logo-mobile" class="visible-xs">
                <h1>Inely
                    <span>1.0</span>
                </h1>
            </div>
        </div>

        <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="#" class="profile">
                        <i data-placement="bottom" title="Профиль" style="font-size:20px;font-style: normal;" class="entypo-user tooltitle"></i>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i data-placement="bottom" title="Помощь" style="font-size:20px;font-style: normal;" class="entypo-info-circled tooltitle"></i>
                    </a>
                </li>
                <li>
                    <a href="/logout" data-method="post">
                        <i data-placement="bottom" title="Выход" style="font-size:20px;font-style: normal;" class="entypo-key tooltitle"></i>
                    </a>
                </li>
            </ul>
            <div id="nt-title-container" class="navbar-left running-text visible-lg">
                <ul class="date-top">
                    <li class="entypo-calendar" style="margin-right:5px"></li>
                    <li id="Date"></li>
                </ul>

                <ul id="digital-clock" class="digital">
                    <li class="entypo-clock" style="margin-right:5px;"></li>
                    <li class="hour"></li>
                    <li>:</li>
                    <li class="min"></li>
                    <li>:</li>
                    <li class="sec"></li>
                </ul>
            </div>

            <ul style="margin-right:0;" class="nav navbar-nav navbar-right">
                <li>
                    <a href="#" class="profile">
                        <img alt="Avatar" class="admin-pic img-circle" src="<?= Yii::$app->user->identity->userProfile->getAvatar() ?>">
                        <?= Yii::$app->user->identity->username ?>
                    </a>
                </li>
                <li>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="entypo-cog"></span>&#160;&#160;Смена фона
                    </a>
                    <ul role="menu" class="dropdown-setting dropdown-menu">
                        <li class="theme-bg">
                            <div data-key="1"></div>
                            <div data-key="2"></div>
                            <div data-key="5"></div>
                            <div data-key="6"></div>
                            <div data-key="9"></div>
                            <div data-key="10"></div>
                            <div data-key="11"></div>
                            <div data-key="12"></div>
                            <div data-key="13"></div>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>