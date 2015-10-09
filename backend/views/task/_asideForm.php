<?php

/**
 * Рендеринг всех категорий в виде проектов.
 * Если поле userId равно null, значит категория публична.
 * @return string
 */

?>

<a href='#' class='list-group-item user-project'>
    <span class="fa fa-dot-circle-o fs16 mr5 text-alert"></span>
    <?= $model->listName ?>
    <span class="badge ml5 badge-alert fs11"><?= $countOfLists[$model->id] ?></span>
</a>