<?php

use yii\helpers\Html;
use yii\grid\ActionColumn;
use kartik\checkbox\CheckboxX;
use kartik\grid\GridView;
use kartik\editable\Editable;
use kartik\datetime\DateTimePicker;
use kartik\rating\StarRating;
use kartik\sidenav\SideNav;
use backend\models\Task;

$this->title = 'Ваши задачи';
$this->registerJs("modal('/task/create', '#modal-add', false)");
$this->registerJs("modal('/todo/cat', '#modal-slideleft', false)");
?>

<div class="main-content">

    <?= SideNav::widget([
        'type' => SideNav::TYPE_DEFAULT,
        'heading' => Html::a('<i class="pull-right fa fa-cog"></i>Категории', [ '#' ], [
            'class' => 'edit',
            'data' => [
                'toggle' => 'modal',
                'target' => '#modal-slideleft'
            ]
        ]),
        'encodeLabels' => false,
        'indItem' => false,
        'items' => Task::getItems()
    ]) ?>

        <div class="task-index">

            <?php
            $gridColumns = [
                [
                    'attribute' => 'isDone',
                    'format' => 'raw',
                    'width' => '65px',
                    'filterType' => GridView::FILTER_CHECKBOX_X,
                    'value' => function ($model) {
                        return CheckboxX::widget([
                            'name' => 'checked',
                            'value' => $model->isDone,
                            'pluginOptions' => [
                                'threeState' => false,
                                'size' => 'md',
                                'iconChecked' => Html::tag('i', '', [ 'class' => 'glyphicon glyphicon-ok' ])
                            ],
                        ]);
                    }
                ],
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'name',
                    'editableOptions' => [
                        'asPopover' => false,
                        'buttonsTemplate' => '{submit}',
                        'inputType' => Editable::INPUT_TEXT,
                        'inlineSettings' => [
                            'closeButton' => Html::button(Html::tag('i', '', [ 'class' => 'glyphicon glyphicon-remove' ]), [
                                'class' => 'btn btn-sm btn-danger kv-editable-close',
                                'title' => 'Применить',
                                'type' => 'button'
                            ]),
                            'options' => [ 'class' => null ]
                        ]
                    ],
                ],
                [
                    'attribute' => 'time',
                    'format' => 'raw',
                    'width' => '280px',
                    'value' => function ($model) {
                        $formatter = new IntlDateFormatter('ru_RU', IntlDateFormatter::FULL, IntlDateFormatter::FULL, 'UTC');
                        $formatter->setPattern('dd MMMM yyyy H:mm');
                        $format   = new DateTime();
                        $dateTime = $formatter->format($format->setTimestamp((int)$model->time));

                        return DateTimePicker::widget([
                            'name' => 'datetime',
                            'value' => $dateTime,
                            'language' => 'ru',
                            'removeButton' => false,
                            'convertFormat' => true,
                            'pickerButton' => [ 'icon' => 'time' ],
                            'options' => [
                                'placeholder' => 'Не забыть до..',
                                'style' => 'min-width: 155px'
                            ],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'todayBtn' => true,
                                'todayHighlight' => true,
                                'minuteStep' => 10,
                                'format' => 'dd MMMM yyyy H:mm',
                                'weekStart' => 1,
                                'startDate' => '2015-01-01',
                            ],
                            'pluginEvents' => [
                                'changeDate' => "function(ev) {
                                    sendDateTime(ev);
                                }"
                            ]
                        ]);
                    }
                ],
                [
                    'attribute' => 'priority',
                    'format' => 'raw',
                    'width' => '130px',
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
                            'pluginEvents' => [
                                'rating.change' => "function(ev, val) {
                                    sendRating(ev, val);
                                }"
                            ]
                        ]);
                    }
                ],
                [
                    'class' => ActionColumn::className(),
                    'template' => '{delete}',
                    'header' => 'Действия',
                    'options' => [ 'style' => 'width: 90px' ]
                ]
            ];
            ?>

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'responsive' => true,
                'responsiveWrap' => true,
                'resizableColumns' => false,
                'hover' => true,
                'export' => false,
                'pjax' => true,
                'pjaxSettings' => [
                    'neverTimeout' => true,
                    'loadingCssClass' => false,
                    'options' => [ 'id' => 'pjax-wrapper' ]
                ],
                'rowOptions' => function ($model) {
                    return [ 'style' => $model->isDone ? 'opacity: .5' : true ];
                },
                'panel' => [
                    'heading' => Html::tag('i', null, [ 'class' => 'fa fa-inbox' ]) . Html::tag('span', 'Список задач'),
                    'type' => GridView::TYPE_PRIMARY,
                    'footer' => false,
                    'before' => Html::a('<i class="glyphicon glyphicon-plus"></i>Новая задача', null, [
                            'class' => 'btn btn-success btn-square add',
                            'data' => [
                                'toggle' => 'modal',
                                'target' => '#modal-add'
                            ]
                        ]),
                    'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i>Сбросить параметры', [ 'index' ], [
                            'class' => 'btn btn-info btn-square'
                        ])
                ],
                'toolbar' => [ '{toggleData}' ],
                'toggleDataOptions' => [
                    'all' => [
                        'icon' => 'resize-full',
                        'label' => 'Все записи',
                        'class' => 'btn btn-info btn-square'
                    ],
                    'page' => [
                        'icon' => 'resize-small',
                        'label' => 'Страница',
                        'class' => 'btn btn-info btn-square'
                    ]
                ]
            ]);
            ?>
        </div>
    </div>