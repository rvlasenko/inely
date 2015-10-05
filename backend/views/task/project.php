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
    <h2 class="pt25 pb10 pl40 text-muted fw400 mn task-head"><?= Yii::t('backend', 'Inbox') ?></h2>
    <a href="#" class="t-option"><i class="fa fa-cogs"></i></a>

    <section>
        <div class="tray tray-center h1200 pn va-t">
            <div id="tree" class="fs14 pt5 pl5"></div>
            <div id="formAdd" hidden>
                <div class="bs-component">
                    <div class="col-md-9 col-sm-9 col-xs-9 pln prn">
                        <input type="text" id="inputStandard" class="form-control" placeholder="Начните набирать здесь..." autofocus>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 pln">
                        <input type="text" class="form-control br-l-n" id="datetimepicker1" placeholder="Назначить время">
                    </div>
                </div>

                <div class="bs-component">
                    <div class="col-md-3 col-sm-3 col-xs-3 pln mt10 w150">
                        <button type="button" class="btn br2 fw600 btn-dark btn-block" style="padding: 7px 10px;" disabled>Добавить задачу</button>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3 pln mt10 w100">
                        <button type="button" id="buttonCancel" class="btn br2 btn-danger btn-block" style="padding: 7px 10px;">Отмена</button>
                    </div>
                </div>
            </div>
            <div class="controller">
                <a href="#" class="action"><i class="fa fa-plus"></i><?= Yii::t('backend', 'Add Task') ?></a>

                <div class="completed"><a href="#"></a></div>
            </div>
        </div>
    </section>
</div>