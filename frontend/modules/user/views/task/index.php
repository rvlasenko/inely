<?php

    use yii\helpers\Html;
    use yii\helpers\ArrayHelper;
    use kartik\grid\GridView;
    use kartik\editable\Editable;
    use kartik\datetime\DateTimePicker;
    use frontend\modules\user\models\Task;

    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title = 'Ваши задачи';
?>

<div class="main-content">
<div class="topbar">
    <?php $this->beginContent('@app/views/layouts/templates/topbar.php'); $this->endContent(); ?>
</div>

<div class="page-content page-thin">
    <div class="task-index">

        <?php
            $gridColumns = [
                /*[
                    'class' => '\kartik\grid\EditableColumn',
                    'attribute' => 'is_done',
                    'editableOptions' => [
                        'header' => 'вашу задачу',
                        'inputType' => \kartik\editable\Editable::INPUT_CHECKBOX,
                        'buttonsTemplate' => '{submit}',
                        'inlineSettings' => [
                            'options' => [
                                'class' => ''
                            ],
                        ],
                    ],
                ],*/
                /*
                     * ArrayHelper::map(
                        Task::find()
                            ->limit(10)
                            ->where(['author' => \Yii::$app->user->id])
                            ->asArray()
                            ->all(), 'id', 'name'
                    ),
                     */
                [
                    'class' => 'kartik\grid\BooleanColumn',
                    'attribute' => 'is_done',
                    'vAlign' => 'middle',
                    //'filterType' => GridView::FILTER_SELECT2,
                    /*'filter' => \kartik\select2\Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'is_done',
                    ]),*/
                    'value' => function($model) {
                        return ($model->is_done == null) ? false : true;
                    },
                ],
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'name',
                    'width' => '600px',
                    //'filterType' => GridView::FILTER_SELECT2,
                    /*'filter' => ArrayHelper::map(
                        Task::find()
                            ->orderBy('name')
                            ->limit(10)
                            ->where(['author' => \Yii::$app->user->id])
                            ->asArray()
                            ->all(), 'id', 'name'
                    ),
                    'filterWidgetOptions' => [
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ],
                    'filterInputOptions' => [
                        'placeholder' => 'Введите логин'
                    ],*/
                    'editableOptions' => [
                        'placement' => 'top',
                        'header' => 'вашу задачу',
                        'inputType' => Editable::INPUT_HTML5_INPUT,
                        'size' => 'md',
                    ],
                ],
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'category',
                    'pageSummary' => true,
                    'editableOptions'=> function ($model, $key, $index, $widget) {
                        return [
                            'header' => 'цвет значка',
                            'size' => 'md',
                            'afterInput' => function ($form, $widget) use ($model, $index) {
                                return $form->field($model, "category")->widget(\kartik\color\ColorInput::classname(), [
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
                                                "white", "black", "grey", "silver", "gold", "brown",
                                            ],
                                            [
                                                "red", "orange", "yellow", "indigo", "maroon", "pink"
                                            ],
                                            [
                                                "blue", "green", "violet", "cyan", "magenta", "purple",
                                            ],
                                        ]
                                    ],
                                ]);
                            }
                        ];
                    }
                ],
                [
                    'class' => '\kartik\grid\EditableColumn',
                    'attribute' => 'priority',
                    'editableOptions' => [
                        /*'asPopover' => false,
                        'inlineSettings' => [
                            'templateBefore' => Editable::INLINE_BEFORE_2,
                            'templateAfter' =>  Editable::INLINE_AFTER_2,
                            'options' => [
                                'class' => ''
                             ],
                        ],*/
                        'placement' => 'top',
                        'displayValueConfig'=>[
                            1 => 'One Star',
                            2 => 'Two Stars',
                            3 => 'Three Stars',
                            4 => 'Four Stars',
                            5 => 'Five Stars',
                        ],
                        'attribute' => 'priority',
                        'header' => 'рейтинг',
                        'size' => 'sm',
                        'inputType' => Editable::INPUT_RATING,
                        'editableValueOptions' => [
                            'class' => 'text-success'
                        ],
                    ],
                ],
                [
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
                            'convertFormat' => true,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'todayHighlight' => true,
                                'format' => 'dd-M hh:ii',
                                //'pickerPosition' => 'bottom-right'
                            ],
                            'type' => DateTimePicker::TYPE_INPUT,
                            'size' => 'md',
                        ],
                    ],
                ],
                //'time',
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
                'resizableColumns' => true,
                'hover' => true,
                'export' => false,
                'pjax' => true,
                'rowOptions' => function ($model) {
                    return [
                        'class' => $model->is_done ? GridView::TYPE_SUCCESS : GridView::TYPE_DANGER,
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
            <span>Copyright <span class="copyright">©</span>2015</span>
            <span>devv</span>.
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
















