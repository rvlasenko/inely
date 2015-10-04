<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author hirootkit <admiralexo@gmail.com>
 * @var $this    yii\web\View
 */

\backend\assets\TaskAsset::register($this);

?>

    <!-- begin: .tray-left -->
    <aside class="tray tray-left va-t tray250">
        <?= $this->render('aside', ['dataProvider' => $dataProvider, 'countOf' => $countOf]) ?>
    </aside>
    <!-- end: .tray-left -->

    <section class="list-tabs">
        <?= $this->render('project') ?>
    </section>

<?= $this->render('create') ?>