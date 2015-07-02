<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="main-content">
<div class="topbar">
    <?php $this->beginContent('@app/views/layouts/templates/topbar.php'); $this->endContent(); ?>
</div>

<div class="page-content page-thin">
    <div class="task-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?=
            GridView::widget([
                'dataProvider'=> $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    'name',
                    'category',
                    //'author',
                    'is_done',
                    'priority',
                    'time',
                    //'is_done_date',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
                'toolbar' => [
                    [
                        'content' =>
                            Html::button('<i class="glyphicon glyphicon-plus"></i>', [
                                'type'=>'button',
                                'title'=>'Add Book',
                                'class'=>'btn btn-success'
                            ]) . ' '.
                            Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['grid-demo'], [
                                'class' => 'btn btn-default',
                                'title' => 'Reset Grid'
                            ]),
                    ],
                ],
                'responsive' => true,
                'hover' => true,
                'export' => false,
                'pjax' => true,
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
















