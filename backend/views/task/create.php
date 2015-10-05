<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 *
 */

use yii\helpers\ArrayHelper;

//$data = ArrayHelper::map(TaskCat::find()->where([ 'userId' => Yii::$app->user->id ])->all(), 'id', 'name');
?>

<div class="quick-compose-form">

    <form method="post">

        <textarea class="form-control" name="Task[name]" id="task-name" placeholder="What you want to do?" autofocus></textarea>
        <input type="text" class="form-control" name="Task[list]" placeholder="Tag for the task">
        <input type="text" class="form-control" name="Task[list]" placeholder="Group">

    </form>

</div>