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
                        <a class="tooltip-tip ajax-load inboxGroup active" title="Входящие" href="#">
                            <i class="entypo-archive"></i>
                            <span>Входящие</span>

                            <div class="noft-blue-number counter inbox"></div>
                        </a>
                    </li>

                    <?= $this->render('//layouts/_assignedToMe') ?>

                    <li>
                        <a class="tooltip-tip ajax-load todayGroup" title="Сегодня" href="#">
                            <i class="entypo-light-up"></i>
                            <span>Сегодня</span>

                            <div class="noft-blue-number counter today"></div>
                        </a>
                    </li>

                    <li>
                        <a class="tooltip-tip ajax-load nextGroup" title="Следующие 7 дней" href="#">
                            <i class="entypo-calendar"></i>
                            <span>Следующие 7 дней</span>

                            <div class="noft-blue-number counter week"></div>
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

                    <?= \yii\widgets\ListView::widget([
                        'dataProvider' => $projectProvider,
                        'summary'      => false,
                        'emptyText'    => 'У вас нет активных проектов',
                        'options'      => ['class' => 'jstree-neutron'],
                        'itemView'     => function ($model, $key) {
                            return $this->render('//layouts/_project', ['model' => $model, 'key' => $key]);
                        }
                    ]) ?>
                </ul>
                <ul class="topnav menu-left-nest">
                    <li>
                        <a href="#" style="border-left: 0 solid !important;" class="title-menu-left">
                            <span class="component"></span>
                            <i data-toggle="tooltip" class="entypo-plus-circled pull-right config-label-wrap"></i>
                        </a>
                    </li>

                    <?= \yii\widgets\ListView::widget([
                        'dataProvider' => $labelProvider,
                        'summary'      => false,
                        'emptyText'    => 'У вас нет контекстных меток',
                        'options'      => ['class' => 'jstree-label'],
                        'itemView'     => function ($model, $key) {
                            return $this->render('//layouts/_label', ['model' => $model, 'key' => $key]);
                        }
                    ]) ?>
                </ul>
            </div>
        </div>
    </div>
</div>
