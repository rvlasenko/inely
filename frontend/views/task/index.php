<?php

    use yii\helpers\Html;
    use kartik\checkbox\CheckboxX;
    use kartik\grid\GridView;
    use kartik\editable\Editable;
    use kartik\datetime\DateTimePicker;
    use kartik\rating\StarRating;
    use kartik\sidenav\SideNav;
    use frontend\models\Task;

    $this->title = 'Ваши задачи';
    $date = new DateTime();
?>

<div class="main-content">

<script>
    jQuery(function($) {
        $('a.edit').click(function() {
            if (!$('.modal-body .row').length) {
                $.get('/cat', function(html) {
                    $('.modal-body').html(html);
                    $('modal-slideleft').modal('show', {
                        backdrop: 'static'
                    });
                });
            }
        });
        $('.kv-sidenav li a').click(function() {
            $.pjax.reload({
                url: $(this).attr('href'),
                container: '#pjax-wrapper'
            });

            return false;
        });
    });
</script>

<?=
    SideNav::widget([
        'type' => SideNav::TYPE_DEFAULT,
        'heading' => Html::a('<i class="pull-right fa fa-cog"></i>Категории', ['#'], [
            'class' => 'edit',
            'data' => [
                'toggle' => 'modal',
                'target' => '#modal-slideleft'
            ]
        ]),
        'encodeLabels' => false,
        'indItem' => false,
        'items' => Task::getItems()
    ]);
?>

<div class="topbar">
    <?php $this->beginContent('@app/views/layouts/templates/topbar.php'); $this->endContent(); ?>
</div>

<div class="page-content page-thin">
    <div class="task-index">

        <?php
            $gridColumns = [
                [
                    'attribute' => 'isDone',
                    'format' => 'raw',
                    'width' => '65px',
                    'filterType' => GridView::FILTER_CHECKBOX_X,
                    'value' => function($model) {
                        return CheckboxX::widget([
                            'name' => 'checked',
                            'value' => $model->isDone,
                            'pluginOptions' => [
                                'threeState' => false,
                                'size' => 'md',
                                'iconChecked' => Html::tag('i', '', ['class' => 'glyphicon glyphicon-ok']),
                            ],
                        ]);
                    }
                ],
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'name',
                    'width' => '500px',
                    'editableOptions' => [
                        'asPopover' => false,
                        'buttonsTemplate' => '{submit}',
                        'inputType' => Editable::INPUT_TEXT,
                        'inlineSettings' => [
                            'closeButton' => Html::button(
                                Html::tag('i', '', ['class' => 'glyphicon glyphicon-remove']), [
                                    'class' => 'btn btn-sm btn-danger kv-editable-close',
                                    'title' => 'Применить',
                                    'type' => 'button'
                                ]),
                            'options' => [
                                'class' => null
                            ]
                        ]
                    ],
                ],
                [
                    'attribute' => 'time',
                    'format' => 'raw',
                    'value' => function($model) {
                        return DateTimePicker::widget([
                            'model' => $model,
                            'name' => 'datetime',
                            'language' => 'ru',
                            'removeButton' => false,
                            'size' => 'sm',
                            //'convertFormat' => true,
                            'options' => [
                                'placeholder' => 'Дата...'
                            ],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'todayHighlight' => true,
                                'format' => 'dd.mm hh:ii',
                                'startDate' => '01-Mar-2015 12:00 AM',
                            ]
                        ]);
                    }
                ],
                /*[
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'time',
                    'editableOptions' => [
                        'inputType' => \kartik\editable\Editable::INPUT_DATETIME,
                        //'name' => 'time',
                        'placement' => 'left',
                        'header' => 'дату',
                        'options' => [
                            'language' => 'ru',
                            'removeButton' => false,
                            //'convertFormat' => true,
                            'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
                            'size' => 'md',
                            'value' => function($model) {
                                return $model->time;
                            },
                            'pluginOptions' => [
                                'autoclose' => true,
                                'todayHighlight' => true,
                                'format' => 'dd.mm hh:ii',
                            ],
                        ],
                    ],
                ],*/
                [
                    'attribute' => 'priority',
                    'format' => 'raw',
                    'filterType' => GridView::FILTER_STAR,
                    'filterWidgetOptions' => [
                        'pluginOptions' => [
                            'size' => 'xs',
                            'step' => 1,
                            'stars' => 4,
                            'min' => 0,
                            'max' => 4
                        ],
                    ],
                    'value' => function ($model) {
                        return StarRating::widget([
                            'model' => $model,
                            'name' => 'priority',
                            'value' => $model->priority,
                            'pluginOptions' => [
                                'size' => 'xs',
                                'step' => 1,
                                'stars' => 4,
                                'min' => 0,
                                'max' => 4
                            ],
                        ]);
                    }
                ],
            ];
        ?>

        <?=
            GridView::widget([
                'dataProvider'=> $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'responsive' => true,
                'responsiveWrap' => true,
                'resizableColumns' => false,
                'filterRowOptions'=> [
                    'class' => 'kartik-sheet-style'
                ],
                'hover' => true,
                'export' => false,
                'pjax' => true,
                'pjaxSettings' => [
                    'neverTimeout' => true,
                    'loadingCssClass' => false,
                    'options' => [
                        'id' => 'pjax-wrapper',
                        'enablePushState' => false,
                    ]
                ],
                'rowOptions' => function ($model) {
                    return [
                        'style' => $model->isDone ? 'opacity: .5' : true
                    ];
                },
                'panel' => [
                    'heading' => '<i class="fa fa-inbox"></i> <span>Список задач</span>',
                    'type' => GridView::TYPE_PRIMARY,
                    'before' => Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-plus']) . 'Новая задача', ['create'],
                        ['class' => 'btn btn-success btn-square']),
                    'after' => Html::a(Html::tag('i', '', ['class' => 'glyphicon glyphicon-repeat']) . 'Сбросить таблицу', ['index'],
                        ['class' => 'btn btn-info btn-square']),
                    'footer' => false
                ],
                'toolbar' => [
                    '{toggleData}',
                ],
                'toggleDataOptions' => [
                    'all' => [
                        'icon' => 'resize-full',
                        'label' => 'Все записи',
                        'class' => 'btn btn-info btn-square',
                    ],
                    'page' => [
                        'icon' => 'resize-small',
                        'label' => 'Страница',
                        'class' => 'btn btn-info btn-square',
                    ],
                ],
            ]);
        ?>

    </div>
    <div class="footer">
        <div class="copyright">
            <p class="pull-left sm-pull-reset">
                <span>Copyright <span class="copyright"> &copy; </span><?= $date->format('Y') ?></span>
                <span>rootkit</span>.
                <span>All rights reserved.</span>
            </p>

            <p class="pull-right sm-pull-reset">
                <span>
                    <a href="#" class="m-r-10">Support</a> |
                    <a href="#" class="m-l-10 m-r-10">Terms of use</a> |
                    <a href="#" class="m-l-10">Privacy Policy</a>
                </span>
            </p>
        </div>
    </div>
</div>
</div>