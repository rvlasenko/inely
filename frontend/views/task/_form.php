<?php

    use frontend\models\TaskCat;
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    use yii\widgets\ActiveForm;
    use yii\helpers\ArrayHelper;
    use kartik\select2\Select2;
    use kartik\datetime\DateTimePicker;

    /* @var $this yii\web\View */
    /* @var $model frontend\models\Task */
    /* @var $form yii\widgets\ActiveForm */

    $data = ArrayHelper::map(TaskCat::find()
        ->where(['userId' => Yii::$app->user->id])
        ->all(), 'id', 'name');
?>

<div class="row">

    <?php Pjax::begin(['id' => 'task-wrap', 'enablePushState' => false]) ?>
    <?php $form = ActiveForm::begin([
        'id' => 'task-form',
        'action' => '/task/create',
        //'enableAjaxValidation' => true,
        //'enableClientValidation' => false,
        'options' => [
            'data-pjax' => true
        ]
    ]) ?>

    <?= $form->field($model, 'name', [
        'options' => ['class' => 'col-md-6']
    ])->textInput([
        'maxlength' => true,
        'placeholder' => 'Что вы хотите выполнить?'
    ]) ?>

    <?= $form->field($model, 'category', [
        'options' => ['class' => 'col-md-6']
    ])->widget(Select2::classname(), [
        'data' => $data,
        'options' => [
            'placeholder' => 'Ваша категория'
        ],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ]) ?>

    <?= $form->field($model, 'time', [
        'options' => ['class' => 'col-md-12']
    ])->widget(DateTimePicker::className(), [
        'language' => 'ru',
        'pickerButton' => [
            'icon' => 'time'
        ],
        'options' => [
            'placeholder' => 'Не забыть до..'
        ],
        'pluginOptions' => [
            'autoclose' => true,
            'todayBtn' => true,
            'todayHighlight' => true,
            'minuteStep' => 10,
            'format' => 'dd MM yyyy hh:ii',
            'weekStart' => 1,
            'orientation' => 'bottom right'
        ]
    ]) ?>

    <div class="col-md-12">
        <?= Html::submitButton('Записать!', [
            'class' => 'btn btn-success btn-square'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end() ?>

</div>
