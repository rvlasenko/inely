<?php

/**
 * Рендеринг всех категорий в виде проектов.
 * Если поле userId равно null, значит категория публична.
 * @return string
 */

?>

<a href='#' class='list-group-item user-project'>
    <?= $model->listName ?><span class='fa fa-dot-circle-o fs18 pull-right text-alert'></span>
</a>