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
    $(document).ready(function() {
        /*$('.kv-toggle').click(function (event) {
            event.preventDefault(); // cancel the event
            $(this).children('.opened').toggle();
            $(this).children('.closed').toggle();
            $(this).parent().children('ul').toggle();
            $(this).parent().toggleClass('active');
            return false;
        });*/
        /*$('.kv-toggle span').click(function() {
            event.preventDefault(); // cancel the event
            $('.opened').toggle();
            $('.closed').toggle();
            $(this).children('a').toggle();
            $(this).parent('a').parent('li').toggleClass('active');
            return false;
        });*/
    });
</script>

<?=
    SideNav::widget([
        'type' => SideNav::TYPE_DEFAULT,
        'heading' => '
            <a href="#" data-toggle="modal" data-target="#modal-slideleft">
                <i class="pull-right fa fa-cog"></i>
            </a>Категории',
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
                                'iconChecked' => '<i class="glyphicon glyphicon-ok"></i>',
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
                            'closeButton' => '
                                <button type="button"
                                class="btn btn-sm btn-danger kv-editable-close"
                                title="Применить"><i class="glyphicon glyphicon-remove"></i>
                                </button>',
                            'options' => [
                                'class' => false
                            ]
                        ]
                    ],
                ],
                /*[
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'category',
                    'pageSummary' => true,
                    'editableOptions'=> function ($model, $key, $index, $widget) {
                        return [
                            'header' => 'цвет значка',
                            'size' => 'md',
                            'afterInput' => function ($form, $widget) use ($model, $index) {
                                return $form->field($model->tasks_cat, "badge_color")->widget(\kartik\color\ColorInput::classname(), [
                                    'showDefaultPalette' => false,
                                    'options' => [
                                        'id' => "color-{$index}"
                                    ],
                                    'pluginOptions' => [
                                        'showPalette' => true,
                                        'showPaletteOnly' => true,
                                        'showSelectionPalette' => true,
                                        'showAlpha' => false,
                                        'allowEmpty' => false,
                                        'preferredFormat' => 'name',
                                        'palette' => [
                                            [
                                                "#FFFFFF", "#001F3F", "#0074D9", "#7FDBFF", "#39CCCC", "#3D9970",
                                            ],
                                            [
                                                "#2ECC40", "#01FF70", "#FFDC00", "#FF851B", "#FF4136", "#85144b"
                                            ],
                                            [
                                                "#F012BE", "#B10DC9", "#111111", "#AAAAAA",
                                            ],
                                        ]
                                    ],
                                ]);
                            }
                        ];
                    }
                ],*/
                [
                    'attribute' => 'time',
                    'format' => 'raw',
                    'value' => function ($model) {
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
                //'is_done_date',*/
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
                'rowOptions' => function ($model) {
                    return [
                        'style' => $model->isDone ? 'opacity: .5' : true
                    ];
                },
                'pjaxSettings' => [
                    'neverTimeout' => true,
                    'loadingCssClass' => false
                ],
                'panel' => [
                    'heading' => '<i class="fa fa-inbox"></i> <span>Список задач</span>',
                    'type' => GridView::TYPE_PRIMARY,
                    'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Новая задача', ['create'],
                        ['class' => 'btn btn-success btn-square']),
                    'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Сбросить таблицу', ['index'],
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
















