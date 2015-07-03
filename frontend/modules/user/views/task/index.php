<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\editable\Editable;

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

        <?php
            $gridColumns = [
            // the name column configuration
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                'name',
                'category',
                //'author',
                'is_done',
                'priority',
                'time',
                //'is_done_date',

            ];
        ?>

        <?=
            GridView::widget([
                'dataProvider'=> $dataProvider,
                'columns' => $gridColumns,
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
















