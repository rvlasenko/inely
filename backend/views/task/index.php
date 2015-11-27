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
<?= $this->render('//task/left-sidebar', ['dataProvider' => $dataProvider]) ?>

<section id="content_wrapper">
    <section id="content" class="animated fadeIn table-layout">
        <!--            --><?php //if (Yii::$app->session->hasFlash('alert')): ?>
        <!---->
        <!--                <div class="alert alert-primary alert-dismissable mb30">-->
        <!--                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>-->
        <!--                    <h3 class="mt5">--><?//= ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'title') ?><!--</h3>-->
        <!---->
        <!--                    <p>--><?//= ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body') ?><!--</p>-->
        <!--                </div>-->
        <!---->
        <!--            --><?php //endif ?>
        <section class="list-tabs va-t nano">
            <div class="tray tray-center pn va-t nano-content">
                <header class="pn pl25 pt20">
                    <ol class="breadcrumb fw400 mn pln task-head">
                        <i class="fa fa-bars fs18 pr10" id="toggle_sidemenu_l"></i>
                        <li class="crumb-active"><span>Входящие</span></li>
                        <li class="crumb-link">Обзор</li>
                    </ol>
                    <div class="btn-group t-option">
                        <button type="button" class="dropdown assign hidden mr10" title="Пригласить">
                            <i class="fa fa-user-plus"></i>
                        </button>
                        <button type="button" class="dropdown mr10" data-toggle="dropdown" aria-expanded="true" title="Действия с задачами">
                            <i class="fa fa-cog"></i>
                        </button>
                        <button type="button" class="dropdown" id="toggle_sidemenu_r" title="Инспектор задач">
                            <i class="fa fa-info-circle"></i>
                        </button>
                        <ul class="dropdown-menu" role="menu" style="margin: 2px -14em 0;">
                            <li><a href="#" id="pr"><?= Yii::t('backend', 'Sort by priority') ?></a></li>
                            <li><a href="#" id="nm"><?= Yii::t('backend', 'Sort by name') ?></a></li>
                            <li><a href="#" id="dt"><?= Yii::t('backend', 'Sort by date') ?></a></li>
                            <li class="divider"></li>
                            <li><a href="#" id="rm" data-effect="mfp-zoomIn"><?= Yii::t('backend', 'Delete completed tasks') ?></a></li>
                        </ul>
                    </div>
                </header>
                <svg class="svgBox source" viewBox="0 0 32 32" hidden>
                    <polygon points="30,5.077 26,2 11.5,22.5 4.5,15.5 1,19 12,30"></polygon>
                </svg>
                <div id="tree" class="fs14 pt10"></div>
                <div class="controller mt15 mb20">
                    <i class="fa fa-clock-o fs18 pull-right mr45 option-disabled history in" title="Показать завершенные задачи"></i>
                    <a href="#" class="action">
                        <svg class="svgIcon" viewBox="0 0 32 32">
                            <polygon points="28,14 18,14 18,4 14,4 14,14 4,14 4,18 14,18 14,28 18,28 18,18 28,18"></polygon>
                        </svg>
                        <span class="pl15">Добавить задачу</span>
                    </a>

                    <div class="completed"><a href="#"></a></div>
                </div>
            </div>
        </section>
    </section>
</section>

<?= $this->render('//task/right-sidebar') ?>

<?= $this->render('//project/assign') ?>

<div id="modal-text" class="popup-basic text-center p25 fs14 mfp-with-anim mfp-hide">
    Вы действительно хотите удалить все завершенные задачи в этом списке?
    <div class="mt20">
        <button type="button" class="btn btn-rounded btn-dark del">Удалить</button>
        <button type="button" class="btn ml10 btn-rounded btn-default cancel">Нет, не нужно</button>
    </div>
</div>

<div id="modal-del-pr" class="popup-basic text-center p25 fs14 mfp-with-anim mfp-hide">
    Вы действительно хотите удалить этот проект?
    <div class="mt20">
        <button type="button" class="btn btn-rounded btn-dark del">Удалить</button>
        <button type="button" class="btn ml10 btn-rounded btn-default cancel">Нет, не нужно</button>
    </div>
</div>