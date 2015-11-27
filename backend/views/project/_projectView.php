<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

?>

<li class="jstree-node jstree-leaf" data-key="<?= $key ?>">
    <a class="jstree-anchor <?= $model->badgeColor ?> <?= empty($model->assignedTo) ? 'private' : 'shared' ?>" href="#">
        <i class="jstree-icon jstree-checkbox"></i>
        <span class="text"><?= $model->listName ?></span>
    </a>
</li>