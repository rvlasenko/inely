<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

?>

<div id="taskWrap">
    <h2 class="pt25 pb10 pl40 fw400 mn task-head"><?= Yii::t('backend', 'Inbox') ?></h2>
        <div class="btn-group t-option">
            <button type="button" class="dropdown" data-toggle="dropdown" aria-expanded="true">
                <i class="fa fa-cogs"></i>
            </button>
            <ul class="dropdown-menu" role="menu" style="margin: 2px -<?= Yii::t('backend', '9') ?>em 0;">
                <li><a href="#" id="pr"><?= Yii::t('backend', 'Sort by priority') ?></a></li>
                <li><a href="#" id="nm"><?= Yii::t('backend', 'Sort by name') ?></a></li>
                <li class="divider"></li>
                <li><a href="#" id="ex"><?= Yii::t('backend', 'Export as a template') ?></a></li>
                <li><a href="#" id="im"><?= Yii::t('backend', 'Import from template') ?></a></li>
                <li class="divider"></li>
                <li><a href="#" id="rm"><?= Yii::t('backend', 'Delete completed tasks') ?></a></li>
            </ul>
        </div>

    <div class="tray tray-center h1200 pn va-t">
        <div id="tree" class="fs14 pt5 pl5"></div>
        <div id="formAdd" class="a-form" hidden>
            <div class="bs-component">
                <div class="col-md-9 col-sm-9 col-xs-9 pln">
                    <input type="text" class="inputStandard form-control" placeholder="Начните набирать здесь...">
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3 pln">
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
                    <button type="button" class="buttonAdd buttonRename btn br2 fw600 btn-dark btn-block" style="padding: 7px 10px;">Добавить задачу</button>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3 pln mt10 w100">
                    <button type="button" class="buttonCancel btn br2 btn-danger btn-block" style="padding: 7px 10px;">Отмена</button>
                </div>
            </div>
        </div>
        <div class="controller">
            <a href="#" class="action"><i class="fa fa-plus"></i><?= Yii::t('backend', 'Add Task') ?></a>

            <div class="completed"><a href="#"></a></div>
        </div>
    </div>
</div>