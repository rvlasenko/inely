<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 *
 * @var $this yii\web\View
 */

$this->registerJs('
    function submitCharForm() { if (confirm("' . $i18n . '")) $("#charPredefined").submit(); }

    $("#roboClick").click(function () {
        $("#robo").prop("checked", true);

        submitCharForm();
        return false;
    });

    $("#eveClick").click(function () {
        $("#eve").prop("checked", true);

        submitCharForm();
        return false;
    });
')

?>

<?= $this->render('_charPredefined') ?>

<?= $this->render('_charOwn') ?>