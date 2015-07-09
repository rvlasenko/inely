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
        $('.kv-toggle span').click(function() {
            event.preventDefault(); // cancel the event
            $('.opened').toggle();
            $('.closed').toggle();
            $(this).children('a').toggle();
            $(this).parent('a').parent('li').toggleClass('active');
            return false;
        });
    });
</script>

<?=
    SideNav::widget([
        'type' => SideNav::TYPE_DEFAULT,
        'heading' => 'Категории',
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
                    'attribute' => 'is_done',
                    'format' => 'raw',
                    'filterType' => GridView::FILTER_CHECKBOX_X,
                    'value' => function($model) {
                        return CheckboxX::widget([
                            'name' => 'checked',
                            'value' => $model->is_done,
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
                    'width' => '550px',
                    'editableOptions' => [
                        'placement' => 'right',
                        'header' => 'вашу задачу',
                        'inputType' => Editable::INPUT_TEXT,
                        'size' => 'md',
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
                'hover' => true,
                'export' => false,
                'pjax' => true,
                'rowOptions' => function ($model) {
                    return [
                        'style' => $model->is_done ? 'opacity: .5' : true
                    ];
                },
                'pjaxSettings' => [
                    'neverTimeout' => true,
                    'loadingCssClass' => false
                ],
                'panel' => [
                    'heading' => '<i class="fa fa-inbox"></i> <span>Список задач</span>',
                    'type' => GridView::TYPE_PRIMARY,
                    'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], [
                        'class' => 'btn btn-success btn-square']),
                    'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', ['index'], [
                        'class' => 'btn btn-info btn-square']),
                    'footer' => false
                ],
            ]);
        ?>

    </div>
<div class="footer">
    <div class="copyright">
        <p class="pull-left sm-pull-reset">
            <span>Copyright <span class="copyright">&copy;</span>2015</span>
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
















