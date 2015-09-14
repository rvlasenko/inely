<?php

/**
 * This file is part of the Inely project.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author rootkit
 *
 * @var $this    yii\web\View
 */

$this->registerJs('
    function submitCharForm() { if (confirm("' . $i18n . '")) $("#charPredefined").submit(); }

    // User select character
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