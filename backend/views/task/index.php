<?php

/* @var $this yii\web\View */

\backend\assets\TaskAsset::register($this);
$this->title = 'Входящие ~ Inely';

?>

<?= $this->render('navigation') ?>

<?= $this->render('left-side', [
    'projectProvider' => $projectProvider,
    'labelProvider'   => $labelProvider
]) ?>

<div class="wrap-fluid">
    <div class="container-fluid paper-wrap bevel tlbr">
        <div class="row">
            <div id="paper-top">
                <div class="col-sm-3">
                    <h2 class="tittle-content-header">
                        <span class="crumb-active">Входящие</span>
                    </h2>
                </div>
                <div class="col-sm-7">
                    <div class="devider-vertical visible-lg"></div>
                    <div class="tittle-middle-header">

                        <div class="alert">
                            <span class="tittle-alert entypo-info-circled"></span>
                            &nbsp;Привет, <strong><?= $this->params['firstName'] ?></strong>!
                        </div>

                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="devider-vertical visible-lg"></div>
                    <div class="btn-group btn-wigdet pull-right visible-lg">
                        <button data-toggle="dropdown" class="btn dropdown-toggle" type="button">
                            Действия
                            <span class="caret"></span>
                            <span class="sr-only">Toggle</span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li>
                                <a href="#" id="pr"><span class="entypo-chart-line margin-iconic"></span>Сорт. по приоритету</a>
                            </li>
                            <li>
                                <a href="#" id="nm"><span class="entypo-language margin-iconic"></span>Сорт. по названию</a>
                            </li>
                            <li>
                                <a href="#" id="dt"><span class="entypo-calendar margin-iconic"></span>Сорт. по дате</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#" id="rm" data-effect="mfp-zoomIn"><span class="entypo-trash margin-iconic"></span>Удалить завершенные</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-wrap">
            <div class="row">
                <div id="tree"></div>
            </div>

            <div class="controller mt15 mb20">
                <i class="entypo-clock fs20 pull-right mr45 option-disabled history in" title="Показать завершенные задачи"></i>
                <a href="#" class="action">
                    <svg class="svgIcon" viewBox="0 0 32 32">
                        <polygon points="28,14 18,14 18,4 14,4 14,14 4,14 4,18 14,18 14,28 18,28 18,18 28,18"></polygon>
                    </svg>
                    <span class="pl15">Добавить задачу</span>
                </a>
            </div>

            <svg class="svgBox source" viewBox="0 0 32 32" hidden>
                <polygon points="30,5.077 26,2 11.5,22.5 4.5,15.5 1,19 12,30"></polygon>
            </svg>

            <div class="footer-space"></div>
            <div id="footer">
                <div class="devider-footer-left"></div>
                <div class="time">
                    <p id="spanDate"></p>
                    <p id="clock"></p>
                </div>
                <div class="copyright">Make with Love
                    <span class="entypo-heart"></span>
                    <a href="/">hirootkit</a> All Rights Reserved
                </div>
                <div class="devider-footer"></div>
            </div>

        </div>
    </div>

<div class="modals" hidden>
    <?= $this->render('modals') ?>
</div>