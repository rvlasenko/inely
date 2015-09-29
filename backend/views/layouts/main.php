<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author hirootkit
 *
 * @var $this    yii\web\View
 * @var $content string
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('backend', 'Your dashboard');
$this->registerAssetBundle('yii\web\YiiAsset', $this::POS_END);
$tableLayout   = Yii::$app->controller->route == 'task/index' ? 'table-layout' : false;
$curController = Yii::$app->controller->id;

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>

    <meta http-equiv="content-type" content="text/html" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <title><?= Html::encode($this->title) ?></title>

    <?= Html::csrfMetaTags() ?>
    <link rel="icon" href="favicon.png">

    <?php $this->head() ?>
</head>

<?php $this->beginBody() ?>

<body class="<?= $curController ?>-page boxed-layout sb-l-c">

<?= $this->render('header') ?>

<!-- Start: Main -->
<main role="main">

    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">
        <!-- Begin: Content -->
        <section id="content" class="animated fadeIn <?= $tableLayout ?>">
            <?php if (Yii::$app->session->hasFlash('alert')): ?>

                <div class="alert alert-primary alert-dismissable mb30">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h3 class="mt5"><?= ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'title') ?></h3>

                    <p><?= ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body') ?></p>
                </div>

            <?php endif ?>
            <?= $content ?>
        </section>
        <!-- End: Content -->

        <?= $this->render('footer') ?>
    </section>
    <!-- End: Content-Wrapper -->
</main>
<!-- End: Main -->

<?php $this->endBody() ?>

<!-- Page Javascript -->
<script type="text/javascript">
    $(document).ready(function () {
        "use strict";
        // Init Theme Core
        Core.init({ sbm: "sb-l-c" });
        $('.skillbar').each(function () {
            jQuery(this).find('.skillbar-bar').animate({
                width: jQuery(this).attr('data-percent')
            }, 2500);
        });
        // Chart for user activity and perfomance
        $('.ct-chart').highcharts({
            title:   { text: null },
            credits: false,
            chart:   {
                marginTop:       0,
                plotBorderWidth: 0
            },
            xAxis:   {
                categories: [ 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun' ]
            },
            yAxis:   {
                labels: { enabled: false },
                title:  { text: null }
            },
            legend:  { enabled: false },
            series:  [
                {
                    name: 'All visits',
                    data: [ 29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6 ]
                }, {
                    name: 'XP earned',
                    data: [ 4, 6, 5, 9, 11, 14, 1 ]
                }
            ]
        });
        // Remove first line
        $('.highcharts-grid path:first-child').remove();
        // Init plugins for ".task-widget"
        // plugins: Custom Functions + jQuery Sortable
        //
        var taskWidget = $('div.task-widget');
        var taskItems = taskWidget.find('li.task-item');
        var currentItems = taskWidget.find('ul.task-current');
        var completedItems = taskWidget.find('ul.task-completed');
        // Init jQuery Sortable on Task Widget
        taskWidget.sortable({
            items:       taskItems, // only init sortable on list items (not labels)
            axis:        'y',
            connectWith: ".task-list",
            update:      function (event, ui) {
                var Item = ui.item;
                var ParentList = Item.parent();
                // If item is already checked move it to "current items list"
                if (ParentList.hasClass('task-current')) {
                    Item.removeClass('item-checked').find('input[type="checkbox"]').prop('checked', false);
                }
                if (ParentList.hasClass('task-completed')) {
                    Item.addClass('item-checked').find('input[type="checkbox"]').prop('checked', true);
                }
            }
        });
        // Custom Functions to handle/assign list filter behavior
        taskItems.on('click', function (e) {
            e.preventDefault();
            var This = $(this);
            if ($(e.target).hasClass('fa-remove')) {
                This.remove();
                return;
            }
            // If item is already checked move it to "current items list"
            if (This.hasClass('item-checked')) {
                This.removeClass('item-checked').appendTo(currentItems).find('input[type="checkbox"]').prop('checked', false);
            }
            // Otherwise move it to the "completed items list"
            else {
                This.addClass('item-checked').appendTo(completedItems).find('input[type="checkbox"]').prop('checked', true);
            }
        });
        // Init plugins for ".calendar-widget" FullCalendar
        $('#calendar-widget').fullCalendar({
            contentHeight: 397,
            editable:      true,
            firstDay:      1,
            events:        [
                {
                    title:     'Sony Meeting',
                    start:     '2015-09-1',
                    end:       '2015-09-3',
                    className: 'fc-event-success'
                }, {
                    title:     'Conference',
                    start:     '2015-09-13',
                    end:       '2015-09-15',
                    className: 'fc-event-primary'
                }, {
                    title:     'Lunch Testing',
                    start:     '2015-09-23',
                    end:       '2015-09-25',
                    className: 'fc-event-danger'
                }
            ],
            eventRender:   function (event, element) {
                // create event tooltip using bootstrap tooltips
                $(element).attr("data-original-title", event.title);
                $(element).tooltip({
                    container: 'body',
                    delay:     {
                        "show": 100,
                        "hide": 200
                    }
                });
                // create a tooltip auto close timer
                $(element).on('show.bs.tooltip', function () {
                    var autoClose = setTimeout(function () {
                        $('.tooltip').fadeOut();
                    }, 3500);
                });
            }
        });
        // Init Summernote Plugin
        $('.summernote').summernote({
            height:   255, //set editable area's height
            focus:    false, //set focus editable area after Initialize summernote
            oninit:   function () {},
            onChange: function (contents, $editable) {},
            toolbar:  [
                [
                    'style', [ 'style' ]
                ], [
                    'font', [
                        'bold', 'italic', 'underline'
                    ]
                ], [
                    'color', [ 'color' ]
                ], [
                    'para', [
                        'ul', 'ol', 'paragraph'
                    ]
                ], [
                    'insert', [ 'hr' ]
                ], [
                    'view', [ 'codeview' ]
                ]
            ]
        });
        // Init Admin Panels on widgets inside the ".admin-panels" container
        $('.admin-panels').adminpanel({
            grid:         '.admin-grid',
            draggable:    true,
            preserveGrid: true,
            mobile:       false,
            onFinish:     function () {
                $('.admin-panels').addClass('animated fadeIn').removeClass('fade-onload');
            },
            onSave:       function () { $(window).trigger('resize'); }
        });
    });
</script>
</body>
</html>
<?php $this->endPage() ?>