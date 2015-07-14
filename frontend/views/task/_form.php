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

    /*$this->registerJs("
    $('.form-group button').click(function() {
        $.pjax.reload({
            url: '/task/create',
            container: '#task-wrap'
        });
        return false;
    });
    ");*/
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

    <?php /*$form->field($model, 'time', [
        'options' => ['class' => 'col-md-12']
    ])->widget(DateTimePicker::className(), [
        //'name' => 'datetime',
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
            'startDate' => '01-Mar-2015 12:00 AM'
        ]
    ])*/ ?>

    <?php /*$form->field($model, 'priority', [
        'options' => ['class' => 'col-md-6']
    ])->widget(StarRating::className(), [
        'model' => $model,
        'name' => 'priority',
        'pluginOptions' => [
            'size' => 'sm',
            'step' => 1,
            'stars' => 4,
            'min' => 0,
            'max' => 4
        ]
    ]) */?>

    <div class="col-md-12">
        <?= Html::submitButton('Записать!', [
            'class' => 'btn btn-success btn-square'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end() ?>

</div>
