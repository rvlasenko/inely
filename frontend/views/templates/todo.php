<?php
    use yii\helpers\Html;
?>

<div class="panel">
    <div class="panel-header">
        <h3>
            <i class="icon-list"></i>
            <strong>Todo</strong> List
        </h3>
    </div>
    <div class="panel-content p-t-0 p-b-0 widget-news">
        <div class="withScroll _mCS_23 _mCS_7 _mCS_21 mCustomScrollbar _mCS_31" data-height="422" style="height: 400px;">
            <div class="mCustomScrollBox mCS-light" id="mCSB_31" style="position:relative; height:100%;
                overflow:hidden; max-width:100%;">
                <div class="mCSB_container" style="position: relative; top: 0;">
                <div class="panel-content">
                    <ul class="todo-list">
                        <?php foreach ($tasks as $task): ?>
                            <li class="<?= Html::encode($task->priority) ?>">
                            <span class="span-check">
                                <input id="task-1" type="checkbox" data-checkbox="icheckbox_square-blue"
                                    <?= Html::encode($task->is_done) ? 'checked' : null ?>>
                                <label for="task-1"></label>
                            </span>
                                <span class="todo-task">
                                    <?= Html::encode($task->name) ?>
                                </span>
                                <div class="todo-date clearfix">
                                    <div class="completed-date"></div>
                                    <div class="due-date">Выполнить до
                                        <span class="due-date-span">
                                            <?= Html::encode($task->time) ?>
                                        </span>
                                    </div>
                                </div>
                            <span class="todo-options pull-right">
                                <a href="#" class="todo-delete">
                                    <i class="fa fa-times"></i>
                                </a>
                            </span>
                                <div class="todo-tags pull-right">
                                    <div class="label label-success">
                                        <?= Html::encode($task->tasks_cat->name) ?>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="clearfix m-t-10">
                        <div class="pull-right">
                            <button type="button" class="btn btn-sm btn-dark add-task">Добавить задачу</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mCSB_scrollTools" style="position: absolute; display: block; opacity: 0;">
                <div class="mCSB_draggerContainer">
                    <div class="mCSB_dragger" style="position: absolute; height: 368px; top: 0px;"
                         oncontextmenu="return false;">
                        <div class="mCSB_dragger_bar" style="position: relative; line-height: 368px;"></div>
                    </div>
                    <div class="mCSB_draggerRail"></div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>