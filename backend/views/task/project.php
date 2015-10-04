<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

?>

<div id="taskWrap">
    <h2 class="pt25 pb10 pl40 text-info fw400 mn task-head"><?= Yii::t('backend', 'Inbox') ?></h2>
    <a href="#" class="t-option"><i class="fa fa-cogs"></i></a>

    <section>
        <div class="tray tray-center h1200 pn va-t">
            <div id="tree" class="fs14 pt5 pl5"></div>
            <div class="controller">
                <a href="#" class="action"><i class="fa fa-plus"></i><?= Yii::t('backend', 'Add Task') ?></a>

                <div class="completed"><a href="#"></a></div>
            </div>
        </div>
    </section>
</div>