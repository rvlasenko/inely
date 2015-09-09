<?php

use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Task */
/* @var $form yii\widgets\ActiveForm */

//$data = ArrayHelper::map(TaskCat::find()->where([ 'userId' => Yii::$app->user->id ])->all(), 'id', 'name');
?>

<div class="quick-compose-form">

    <?php Pjax::begin([ 'enablePushState' => false ]) ?>
    <?php ActiveForm::begin([ 'id' => 'form-compose', 'action' => 'task/create', 'options' => [ 'data-pjax' => true ] ]) ?>

        <textarea class="form-control" name="Task[name]" placeholder="What you want to do?" required autofocus></textarea>
        <input type="text" class="form-control" name="Task[list]" placeholder="Tag for the task">
        <input type="text" class="form-control" name="Task[list]" placeholder="Group">

    <?php ActiveForm::end() ?>
    <?php Pjax::end() ?>

</div>


<?php
    $dockModal = <<<SCRIPT

    // On button click display quick compose message form
    $('#quick-compose').on('click', function () {
        $('.quick-compose-form').dockmodal({
            minimizedWidth: 260,
            width         : 390,
            height        : 340,
            title         : 'Compose Message',
            initialState  : 'docked',
            buttons       : [
                {
                    html       : 'Add',
                    buttonClass: 'btn btn-primary btn-sm',
                    click      : function (e, dialog) {
                        dialog.dockmodal('close');

                        // after dialog closes submit the form and reload content
                        $('#form-compose').submit();
                        setTimeout(function () {
                        $('#secAll').load('/task/list');
//                            $.get('/task/list', function (html) {
//                                $('#secAll').html(html);
//                            });
                        }, 400);
                    }
                }
            ]
        });
    });

    $('#quick-list').on('click', function () {
        $('.quick-list-form').dockmodal({
            height      : 200,
            title       : 'Compose Message',
            initialState: 'docked',
            buttons     : [
                {
                    html       : 'Add',
                    buttonClass: 'btn btn-primary btn-sm',
                    click      : function (e, dialog) {
                        dialog.dockmodal('close');

                        setTimeout(function () { msgCallback(); }, 500);
                    }
                }
            ]
        });
    });

SCRIPT;

$this->registerJs($dockModal, $this::POS_END);
?>
