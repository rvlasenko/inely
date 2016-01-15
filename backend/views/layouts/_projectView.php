<li data-key="<?= $key ?>">
    <a class="jstree-anchor <?= $model->badgeColor ?> <?= empty($model->sharedWith) ? 'private' : 'shared' ?>" href="#">
        <i class="jstree-icon jstree-checkbox"></i>
        <span class="text"><?= $model->listName ?></span>
    </a>
</li>