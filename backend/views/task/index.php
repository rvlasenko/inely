<?php

use common\components\widgets\TaskWidget;

$this->registerCssFile('tools/dock/dockmodal.css');
$this->registerCssFile('tools/forms/admin-forms.css');
$this->registerJsFile('js/cbpFWTabs.js');
$this->registerJs('
(function() {
    [].slice.call(document.querySelectorAll(".tabs")).forEach(function(el) {
        new CBPFWTabs(el);
    });
})();');

?>

<!-- begin: .tray-left -->
<aside class="tray tray-left va-t tray250">
    <!-- Quick Compose Button -->
    <button id="quick-compose" type="button" class="btn btn-danger light btn-block fw600 hint--bottom hint--bounce" data-hint="Alt+Q">Quick Task</button>

    <!-- Menu -->
    <div class="list-group list-group-links"><div class="list-group-header"></div></div>

    <div class="list-group list-group-links" id="sideInfo">
        <div class="list-group-header">Home<span class="pull-right">(3 tasks)</span></div>
        <a href="#" class="list-group-item pt15 prn">Due today<span class="badge badge-info fs11">0</span></a>
        <a href="#" class="list-group-item prn">Due tommorrow<span class="badge badge-info fs11">0</span></a>

        <a href="#" class="list-group-item pt15 prn">Completed<span class="badge badge-success fs11">0</span></a>
    </div>
</aside>
<!-- end: .tray-left -->

<section class="list-tabs">
    <div class="tabs tabs-style-bar">
        <nav>
            <ul>
                <?= TaskWidget::widget([ 'model' => $model, 'layout' => 'navTabs' ]) ?>
            </ul>
        </nav>
        <div class="content-wrap">
            <!-- message toolbar header -->
            <div class="panel-menu br-n">
                <div class="row">
                    <div class="hidden-sm col-md-3"></div>
                    <div class="col-xs-6 col-md-6 pull-right text-right">
                        <button type="button" class="btn btn-danger light visible-xs-inline-block mr10">Compose</button>
                        <div class="btn-group mr10">
                            <button type="button" class="btn btn-default light hidden-xs"><i class="fa fa-folder"></i><i class="fa fa-plus text-success"></i></button>
                            <button type="button" class="btn btn-default light hidden-xs"><i class="fa fa-folder"></i><i class="fa fa-times text-danger"></i></button>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-6 pull-left text-left">
                        <div class="btn-group mr10">
                            <button class="btn btn-sm btn-success mr10 mt5 br3"><i class="fa mr5 fa-check"></i>Complete</button>
                            <button class="btn btn-sm btn-system mt5 mr10 br3"><i class="fa mr5 fa-clock-o"></i>Postpone</button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm mt5 mr10 br3 btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">More Actions...
                                    <span class="caret ml5"></span>
                                </button>
                                <ul class="dropdown-menu animated animated-shorter zoomIn" role="menu">
                                    <li><a href="#"><i class="fa mr5 fa-clone"></i>Duplicate Task</a></li>
                                    <li><a href="#"><i class="fa mr5 pr3 fa-trash"></i>Delete Task</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#"><i class="fa mr5 pr3 text-danger fa-circle"></i>Set Priority High</a></li>
                                    <li><a href="#"><i class="fa mr5 pr3 text-warning fa-circle"></i>Set Priority Medium</a></li>
                                    <li><a href="#"><i class="fa mr5 pr3 text-success fa-circle"></i>Set Priority Low</a></li>
                                    <li><a href="#"><i class="fa mr5 pr3 fa-circle-o"></i>Set No Priority</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section id="section-bar">
                <!-- begin: .tray-center -->
                <div class="tray tray-center h1200 pn va-t bg-light">
                    <div class="panel">
                        <!-- message listings table -->
                        <table id="message-table" class="table tc-checkbox-1 admin-form theme-warning br-t">
                            <tbody id="secAll"></tbody>
                        </table>
                    </div>
                </div>
                <!-- end: .tray-center -->
            </section>
            <?= TaskWidget::widget([ 'model' => $model, 'layout' => 'sectionsOwn' ]) ?>
        </div><!-- /content -->
    </div><!-- /tabs -->
</section>

<?= $this->render('create') ?>

<div class="quick-list-form">
    <form>
        <input type="text" class="form-control" id="inputName" placeholder="Name of your list" autofocus>
    </form>
</div>

<?php
$main = <<<SCRIPT

    // Open compose task by clicking on Alt+Q
    function keyDown(e) {
        if (e.keyCode == 18) alt = true;
        else if (e.keyCode == 81 && alt) $('#quick-compose').click();
    }

    // User holds the alt key
    function keyUp(e) {
        if (e.keyCode == 17) ctrl = alt;
    }

    $('ul.panel-tabs li:nth-child(2n+1)').addClass('active');
    $('ul.panel-tabs li:first-child').removeClass('active');
    $('.list-tabs').css('padding-top', '3px').css('display', 'block');

    $('#secAll').load('/task/list');

    $(document).on('click', '.message', function() {
        var taskCheck = $(this).find('input[type=checkbox]');

        $(this).toggleClass('highlight');
        taskCheck.prop('checked', taskCheck.is(':checked') ? false : true);
    });

    $('.user-list').click(function () {
        var thisId = $(this);
        var tableBody = $('tbody').filter(function () {
            return $(this).data("key") == thisId.attr('id');
        });

        $.ajax({
            type   : "POST",
            async  : true,
            dataType: 'html',
            url    : "/task/list",
            data   : { list: $(this).attr('id') },
            success: function (data) {
                tableBody.html(data);
            }
        });
    });

    $(document).ajaxStart(function () {
        NProgress.start();
        setTimeout(function () {
            NProgress.done();
            $('.fade').removeClass('out');
        }, 400);
    });

SCRIPT;

$this->registerJs($main, $this::POS_END);
?>