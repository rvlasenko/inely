<div id="skin-select">
    <div id="logo">
        <h1>Inely
            <span>v1.0</span>
        </h1>
    </div>

    <a id="toggle">
        <span class="entypo-menu"></span>
    </a>

    <div class="dark">
        <form action="#">
            <span>
                <input type="text" class="search rounded searchText" placeholder="Быстрый поиск..." spellcheck="false" autocomplete="off" />
            </span>
        </form>
    </div>

    <div class="search-hover">
        <form id="demo-2">
            <input type="search" class="searchText" placeholder="Быстрый поиск..." />
        </form>
    </div>

    <div class="skin-part">
        <div id="tree-wrap">
            <div class="side-bar">
                <ul class="topnav menu-left-nest">
                    <li>
                        <a href="#" style="border-left: 0 solid !important;" class="title-menu-left">
                            <span class="widget-menu"></span>
                        </a>
                    </li>

                    <li>
                        <a class="tooltip-tip ajax-load inboxGroup" href="#">
                            <i class="entypo-archive"></i>
                            <span>Входящие</span>
                            <div class="noft-blue-number counter inbox"></div>
                        </a>
                    </li>

                    <li>
                        <a class="tooltip-tip ajax-load todayGroup" href="#">
                            <i class="entypo-light-up"></i>
                            <span>Сегодня</span>
                            <div class="noft-blue-number counter today"></div>
                        </a>
                    </li>

                    <li>
                        <a class="tooltip-tip ajax-load nextGroup" href="#">
                            <i class="entypo-calendar"></i>
                            <span>Следующие 7 дней</span>
                            <div class="noft-blue-number counter next7days"></div>
                        </a>
                    </li>
                </ul>
                <ul class="topnav menu-left-nest">
                    <li>
                        <a href="#" style="border-left: 0 solid !important;" class="title-menu-left projectTitle">
                            <span class="design-kit"></span>
                            <i data-toggle="tooltip" class="entypo-plus-circled pull-right config-wrap"></i>
                        </a>
                    </li>

                    <?= $this->render('//project/projectList', ['dataProvider' => $dataProvider]) ?>
                </ul>
                <ul class="topnav menu-left-nest">
                    <li>
                        <a href="#" style="border-left: 0 solid !important;" class="title-menu-left">
                            <span class="component"></span>
                        </a>
                    </li>

                    <li>
                        <a class="tooltip-tip ajax-load" href="#">
                            <i class="icon-preview"></i>
                            <span>Icons</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>