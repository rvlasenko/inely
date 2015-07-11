<?php

    use yii\helpers\Html;
    use kartik\grid\GridView;
    use kartik\editable\Editable;
    use kartik\color\ColorInput;

    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="task-cat-index">

<p>
    <?= Html::a('Create Task Cat', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<?php
    $gridColumns = [
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'name',
            'width' => '125px',
            'editableOptions' => [
                'header' => 'название',
                'size' => 'sm',
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
                        'class' => 'editable-cat'
                    ]
                ]
            ],
        ],
        [
            'attribute' => 'badgeColor',
            'format' => 'raw',
            'value' => function($model) {
                return ColorInput::widget([
                    'model' => $model,
                    'name' => 'color',
                    'value' => $model->badgeColor,
                    'options' => [
                        'placeholder' => 'Ваш цвет..'
                    ]
                ]);
            }
        ],
    ];
?>

<?=
    GridView::widget([
        'dataProvider'=> $dataProvider,
        'columns' => $gridColumns,
        'responsive' => true,
        'responsiveWrap' => true,
        'resizableColumns' => false,
        'hover' => true,
        'export' => false,
        'pjax' => true,
        'pjaxSettings' => [
            'neverTimeout' => true,
            'loadingCssClass' => false
        ],
    ]);
?>

</div>
