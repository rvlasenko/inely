<?php

    use yii\helpers\Html;
    use kartik\grid\GridView;
    use kartik\editable\Editable;

    /* @var $this yii\web\View */
    /* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="main-content">
<div class="topbar">
    <?php $this->beginContent('@app/views/layouts/templates/topbar.php'); $this->endContent(); ?>
</div>

<div class="page-content page-thin">
    <div class="task-index">

        <?php
            $gridColumns = [
            // the name column configuration
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                //'name',
                [
                    'class' => 'kartik\grid\EditableColumn',
                    'attribute' => 'name',
                    'editableOptions' => [
                        'header' => 'вашу задачу',
                        'inputType' => \kartik\editable\Editable::INPUT_HTML5_INPUT,
                        'size' => 'md',
                        'placement' => 'top'
                    ],
                    'hAlign' => 'bottom',
                    'vAlign' => 'middle',
                    'width' => '700px',
                ],
                'category',
                //'author',
                'is_done',
                'priority',
                'time',
                //'is_done_date',*/
            ];
        ?>

        <?=
            GridView::widget([
                'dataProvider'=> $dataProvider,
                'columns' => $gridColumns,
                'responsive' => true,
                'resizableColumns' => true,
                'persistResize' => true,
                'resizeStorageKey' => Yii::$app->user->id . '-' . date("m"),
                'hover' => true,
                'export' => false,
                'pjax' => true,
                'pjaxSettings' => [
                    'neverTimeout' => true,
                    'loadingCssClass' => false
                ],
                'panel' => [
                    'heading' => '<i class="fa fa-inbox"></i> <span>Countries</span>',
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
















