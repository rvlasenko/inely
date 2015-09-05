<?php

$this->registerCssFile('tools/dock/dockmodal.css');
$this->registerCssFile('tools/forms/admin-forms.css');
$this->registerJs("
    function keyDown(e) {
        if (e.keyCode == 18) alt = true;
        else if (e.keyCode == 81 && alt) $('#quick-compose').click();
    }

    function keyUp(e) {
        if (e.keyCode == 17) ctrl = alt;
    }

    $('ul.panel-tabs li:first-child').removeClass('active');
    $('ul.panel-tabs li:nth-child(4)').addClass('active');

    // Init jQuery Sortable on Task Widget
    //$('#task-list').sortable({ axis : 'y' });

    // On button click display quick compose message form
    $('#quick-compose').on('click', function () {
        $('.quick-compose-form').dockmodal({
            minimizedWidth: 260,
            width         : 390,
            height        : 340,
            title         : 'Compose Message',
            initialState  : 'docked',
            buttons       : [{
                html       : 'Send',
                buttonClass: 'btn btn-primary btn-sm',
                click      : function (e, dialog) {
                    dialog.dockmodal('close');

                    // after dialog closes fire a success notification
                    setTimeout(function () { msgCallback(); }, 500);
                }
            }]
        });
    });

    $('#quick-tag').on('click', function () {
        $('.quick-tag-form').dockmodal({
            height      : 200,
            title       : 'Compose Message',
            initialState: 'docked',
            buttons     : [{
                html       : 'Add',
                buttonClass: 'btn btn-primary btn-sm',
                click      : function (e, dialog) {
                    dialog.dockmodal('close');

                    setTimeout(function () { msgCallback(); }, 500);
                }
            }]
        });
    });

    $('#quick-list').on('click', function () {
        $('.quick-list-form').dockmodal({
            height      : 200,
            title       : 'Compose Message',
            initialState: 'docked',
            buttons     : [{
                html       : 'Add',
                buttonClass: 'btn btn-primary btn-sm',
                click      : function (e, dialog) {
                    dialog.dockmodal('close');

                    setTimeout(function () { msgCallback(); }, 500);
                }
            }]
        });
    });

    // on task click, toggle highlighted class
    $('#message-table tbody tr').on('click', function () {
        var taskCheck = $(this).children(':first-child').children('label').children('input[type=checkbox]');

        $(this).toggleClass('highlight');
        taskCheck.prop('checked', taskCheck.is(':checked') ? false : true);
    });", $this::POS_END);
?>
<script>

</script>
<!-- begin: .tray-left -->
<aside class="tray tray-left va-t tray270">

    <!-- Quick Compose Button -->
    <button id="quick-compose" type="button" class="btn btn-danger light btn-block fw600 hint--bottom hint--bounce" data-hint="Alt+Q">Quick Task</button>

    <!-- Tags Menu -->
    <div class="list-group list-group-links mt20">
        <div class="list-group-header"># Tags<a href="#" id="quick-tag"><i class="tabs-right pr10 pt5 fa fa-plus"></i></a></div>
        <a href="#" class="list-group-item">Clients<span class="fa fa-circle text-dark"></span></a>
        <a href="#" class="list-group-item">Contractors<span class="fa fa-circle text-dark"></span></a>
        <a href="#" class="list-group-item">Employees<span class="fa fa-circle text-dark"></span></a>
        <a href="#" class="list-group-item">Suppliers<span class="fa fa-circle text-dark"></span></a>
    </div>

    <!-- Folders Menu -->
    <div class="list-group list-group-links">
        <div class="list-group-header">@ Lists<a href="#" id="quick-list"><i class="tabs-right pr10 pt5 fa fa-plus"></i></a></div>
        <a href="#" class="list-group-item">Clients<span class="fa fa-circle text-info"></span></a>
        <a href="#" class="list-group-item">Contractors<span class="fa fa-circle text-info"></span></a>
        <a href="#" class="list-group-item">Employees<span class="fa fa-circle text-info"></span></a>
        <a href="#" class="list-group-item">Suppliers<span class="fa fa-circle text-info"></span></a>
    </div>

</aside>
<!-- end: .tray-left -->

<!-- begin: .tray-center -->
<div class="tray tray-center pn va-t bg-light">

    <div class="panel">

        <!-- message menu header -->
        <div class="panel-menu br-n hidden">
            <div class="row table-layout">

                <!-- toolbar right btn group -->
                <div class="col-xs-12 col-md-9 text-right prn">
                    <button type="button" class="btn btn-danger light visible-xs-inline-block mr10">Compose</button>
	                <span class="hidden-xs va-m text-muted mr15"> Showing
                        <strong>15</strong> of <strong>253</strong>
	                </span>
                    <div class="btn-group mr10">
                        <button type="button" class="btn btn-default light hidden-xs"><i class="fa fa-star"></i></button>
                        <button type="button" class="btn btn-default light hidden-xs"><i class="fa fa-calendar"></i></button>
                        <button type="button" class="btn btn-default light"><i class="fa fa-trash"></i></button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default light"><i class="fa fa-chevron-left"></i></button>
                        <button type="button" class="btn btn-default light"><i class="fa fa-chevron-right"></i></button>
                    </div>
                </div>

            </div>
        </div>

        <!-- message toolbar header -->
        <div class="panel-menu br-n">
            <div class="row">
                <div class="hidden-xs hidden-sm col-md-3"></div>
                <div class="col-xs-12 col-md-9 text-right">
                    <button type="button" class="btn btn-danger light visible-xs-inline-block mr10">Compose</button>
                    <span class="hidden-xs va-m text-muted mr15"> Showing
                        <strong>15</strong> of <strong>253</strong>
                    </span>
                    <div class="btn-group mr10">
                        <button type="button" class="btn btn-default light hidden-xs"><i class="fa fa-star"></i></button>
                        <button type="button" class="btn btn-default light hidden-xs"><i class="fa fa-calendar"></i></button>
                        <button type="button" class="btn btn-default light"><i class="fa fa-trash"></i></button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default light"><i class="fa fa-chevron-left"></i></button>
                        <button type="button" class="btn btn-default light"><i class="fa fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- message listings table -->
        <table id="message-table" class="table tc-checkbox-1 admin-form theme-warning br-t">
            <thead>
            <tr>
                <th class="text-center hidden-xs">Select</th>
                <th class="hidden-xs">Star</th>
                <th>Subject</th>
                <th class="text-center">Date</th>
            </tr>
            </thead>
            <tbody id="task-list">
            <tr class="message unread pr low">
                <td class="hidden-xs">
                    <label class="option block mn">
                        <input type="checkbox" name="mobileos" value="FR">
                        <span class="checkbox mn"></span>
                    </label>
                </td>
                <td class="hidden-xs">
	                  <span class="rating block mn pull-left">
                        <input class="rating-input" type="radio" name="custom">
                        <label class="rating-star"><i class="fa fa-star va-m"></i></label>
	                  </span>
                </td>
                <td>
                    <span class="badge badge-dark mr10 fs11">#Clients</span>
                    <span class="badge badge-info mr10 fs11">@Social</span>
                    Lorem ipsum dolor sit amet, adipiscing eli
                </td>
                <td class="text-right pr15 fw600">March 11</td>
            </tr>
            <tr class="message read pr medium">
                <td class="hidden-xs">
                    <label class="option block mn">
                        <input type="checkbox" name="mobileos" value="FR">
                        <span class="checkbox mn"></span>
                    </label>
                </td>
                <td class="hidden-xs">
                    <span class="rating block mn pull-left">
                        <input class="rating-input" id="r1" type="radio" name="custom">
                        <label class="rating-star" for="r1"><i class="fa fa-star va-m"></i></label>
                    </span>
                </td>
                <td>
                    <span class="badge badge-dark mr10 fs11">#Project</span>
                    <span class="badge badge-info mr10 fs11">@Suppliers</span>
                    Lorem ipsum dolor sit amet, adipiscing eli
                </td>
                <td class="text-right pr15">March 11</td>
            </tr>
            </tbody>
        </table>

    </div>

</div>
<!-- end: .tray-center -->

<div class="quick-compose-form">
    <form>
        <input type="text" class="form-control" id="inputName" placeholder="What you want to do?" autofocus>
        <input type="text" class="form-control" id="inputTag" placeholder="Tag for the task">
        <input type="text" class="form-control" id="inputGroup" placeholder="Group">
    </form>
</div>

<div class="quick-tag-form">
    <form>
        <input type="text" class="form-control" id="inputName" placeholder="Name of your tag" autofocus>
    </form>
</div>

<div class="quick-list-form">
    <form>
        <input type="text" class="form-control" id="inputName" placeholder="Name of your list" autofocus>
    </form>
</div>