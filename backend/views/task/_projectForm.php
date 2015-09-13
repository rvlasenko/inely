<?php

use yii\helpers\Html;

// Define random id for the checkbox button, because it depends on the label
$checkboxId = rand(1, 100);

// Also we converting MySQL timestamp to language date(time) format

?>

<tr class="message <?= $model->isDone ? 'done' : 'undone' ?> pr <?= $model->priority ?>">
    <td class="text-center w90">
        <label class="option block mn">
            <input type="checkbox" class="checkbox" id="checkbox<?= $checkboxId ?>" data-task-id="<?= $model->id ?>" />
            <label for="checkbox<?= $checkboxId ?>"></label>
        </label>
    </td>
    <td class="fw600">
        <span class="badge badge-info mr10 fs11"><?= isset($model->tasks_cat->tagName) ?: false ?></span>
        <span><?= $model->name ?></span>
    </td>
    <td class="text-left w90">
        <?= Html::tag('i', null, [ 'class' => 'fa fa-ellipsis-v fs18 pull-right cursor mfp-r pt2' ]) ?>
        <span><?= $model->isDone ? false : Yii::$app->formatter->asDatetime($model->time, 'd MMM'); ?></span>
    </td>
</tr>