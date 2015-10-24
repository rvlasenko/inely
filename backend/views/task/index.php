<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 * @var $this    yii\web\View
 */

\backend\assets\TaskAsset::register($this);

?>

<section class="list-tabs">
    <header class="pn pl20" id="topbar">
        <ol class="breadcrumb fw400 mn pln task-head">
            <i class="fa fa-bars fs18 pr10" id="toggle_sidemenu_l"></i>
            <li class="crumb-active"><a href="#">Входящие</a></li>
            <li class="crumb-link">Обзор</li>
        </ol>
        <div class="btn-group t-option">
            <button type="button" class="dropdown mr10" data-toggle="dropdown" aria-expanded="true">
                <i class="fa fa-cog"></i>
            </button>
            <button type="button" class="dropdown" id="toggle_sidemenu_r">
                <i class="fa fa-info-circle"></i>
            </button>
            <ul class="dropdown-menu" role="menu" style="margin: 2px -<?= Yii::t('backend', '9') ?>em 0;">
                <li><a href="#" id="pr"><?= Yii::t('backend', 'Sort by priority') ?></a></li>
                <li><a href="#" id="nm"><?= Yii::t('backend', 'Sort by name') ?></a></li>
                <li><a href="#" id="dt"><?= Yii::t('backend', 'Sort by date') ?></a></li>
                <li class="divider"></li>
                <li><a href="#" id="ex"><?= Yii::t('backend', 'Export as a template') ?></a></li>
                <li><a href="#" id="im"><?= Yii::t('backend', 'Import from template') ?></a></li>
                <li class="divider"></li>
                <li><a href="#" id="rm"><?= Yii::t('backend', 'Delete completed tasks') ?></a></li>
            </ul>
        </div>
    </header>

    <div class="tray tray-center h1200 pn va-t">
        <div id="tree" class="fs14 pt10 pl10"></div>
        <div id="formEdit" class="e-form" hidden>
            <div class="bs-component">
                <div class="col-md-9 col-sm-9 col-xs-9 pln">
                    <input type="text" class="form-control" id="editInput" placeholder="Начните набирать здесь...">
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3 pln prn">
                    <label for="eventDate" class="field prepend-icon">
                        <input type="text" class="form-control" id="editEvent" placeholder="Назначить дату">
                        <label class="field-icon">
                            <i class="fa fa-calendar"></i>
                        </label>
                    </label>
                </div>
            </div>

            <div class="bs-component">
                <div class="col-md-3 col-sm-3 col-xs-3 pln mt10 w150">
                    <button type="button" class="buttonRename btn br2 fw600 btn-dark btn-block" style="padding: 7px 10px;">Сохранить</button>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3 pln mt10 w100">
                    <button type="button" class="buttonCancelEdit btn br2 btn-danger btn-block" style="padding: 7px 10px;">Отмена</button>
                </div>
            </div>
        </div>
        <div id="formAdd" class="a-form" hidden>
            <div class="bs-component mh30">
                <div class="form-group form-material col-md-12 mt15 mb15 pln prn">
                    <input type="text" class="form-control input-lg empty" id="taskInput" placeholder="Write here something cool">
                </div>
            </div>
        </div>
        <!--<div id="formAdd" class="a-form" hidden>
            <div class="bs-component">
                <div class="col-md-8 col-sm-9 col-xs-9 pln">
                    <input type="text" class="form-control" id="taskInput" placeholder="Начните набирать здесь...">
                </div>
                <div class="col-md-4 col-sm-3 col-xs-3 pln prn">
                    <label for="eventDate" class="field prepend-icon">
                        <input type="text" class="form-control" id="eventDate" placeholder="Назначить дату">
                        <label class="field-icon">
                            <i class="fa fa-calendar"></i>
                        </label>
                    </label>
                </div>
            </div>

            <div class="bs-component">
                <div class="col-md-3 col-sm-3 col-xs-3 pln mt10 w150">
                    <button type="button" class="buttonAdd btn br2 fw600 btn-dark btn-block" style="padding: 7px 10px;">Добавить задачу</button>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3 pln mt10 w100">
                    <button type="button" class="buttonCancel btn br2 btn-danger btn-block" style="padding: 7px 10px;">Отмена</button>
                </div>
            </div>
        </div>-->
        <div class="controller">
            <a href="#" class="action"><i class="fa fa-plus"></i><?= Yii::t('backend', 'Add Task') ?></a>

            <div class="completed"><a href="#"></a></div>
        </div>
    </div>
</section>