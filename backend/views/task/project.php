<?php

/**
 * This file is part of the Inely project.
 *
 * (c) Inely <http://github.com/inely>
 *
 * @author rootkit
 */

use yii\helpers\Html;
use yii\widgets\ListView;

?>

<div id="taskWrap">
    <h2 class="p20 pl25 text-info fw400 mn task-head"><?= Yii::t('backend', 'Inbox') ?></h2>

    <div class="panel mbn">
        <!-- message toolbar header -->
        <!--        <div class="panel-menu task br-n">-->
        <!--            <div class="row">-->
        <!--                <div class="hidden-sm col-md-3"></div>-->
        <!--                <div class="col-xs-6 col-md-6 pull-right text-right">-->
        <!--                    <button type="button" class="btn btn-danger light visible-xs-inline-block mr10">Compose</button>-->
        <!--                </div>-->
        <!--                <div class="col-xs-6 col-md-6 pull-left text-left">-->
        <!--                    <div class="btn-group">-->
        <!--                        <button class="btn btn-sm btn-success mr10 mt2 br3"><i class="fa mr5 fa-check"></i>Complete</button>-->
        <!--                        <button class="btn btn-sm btn-system mt2 mr10 br3"><i class="fa mr5 fa-clock-o"></i>Postpone</button>-->
        <!--                        <div class="btn-group">-->
        <!--                            <button type="button" class="btn btn-sm mt2 mr10 br3 btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">More Actions...-->
        <!--                                <span class="caret ml5"></span>-->
        <!--                            </button>-->
        <!--                            <ul class="dropdown-menu animated animated-shorter zoomIn" role="menu">-->
        <!--                                <li><a href="#"><i class="fa mr5 fa-clone"></i>Duplicate Task</a></li>-->
        <!--                                <li><a href="#"><i class="fa mr5 pr3 fa-trash"></i>Delete Task</a></li>-->
        <!--                                <li class="divider"></li>-->
        <!--                                <li><a href="#"><i class="fa mr5 pr3 text-danger fa-flag"></i>Set Priority High</a></li>-->
        <!--                                <li><a href="#"><i class="fa mr5 pr3 text-warning fa-flag"></i>Set Priority Medium</a></li>-->
        <!--                                <li><a href="#"><i class="fa mr5 pr3 text-success fa-flag"></i>Set Priority Low</a></li>-->
        <!--                                <li><a href="#"><i class="fa mr5 pr3 fa-flag-o"></i>Set No Priority</a></li>-->
        <!--                            </ul>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->

    </div>
    <!-- /content -->

    <section>
        <div class="tray tray-center h1200 pn va-t">
            <div class="panel bsh2">
                <table id="message-table" class="table tc-checkbox-1 admin-form theme-warning">
                    <tbody id="project">
                    <?= ListView::widget([
                        'dataProvider' => $dataProviderProject,
                        'summary'      => false,
                        'itemView'     => function ($model) {
                            return $this->render('_projectForm', [ 'model' => $model ]);
                        },
                        'emptyText'    => Html::tag('tr', null, [ 'class' => 'message' ]) . Html::tag('td', Yii::t('backend', 'You have no incomplete tasks in this list. Woohoo!'))
                    ]) ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>