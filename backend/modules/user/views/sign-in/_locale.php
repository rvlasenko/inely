<?php

use yii\helpers\Html;

$items    = Yii::$app->params[ 'availableLocales' ];
$i        = 0;
$numItems = count($items);

foreach ($items as $key => $language) {
    echo Html::a($language, [ '/site/set', 'locale' => $key ]);
    if (++$i !== $numItems) echo Html::tag('span', ' | ', [ 'class' => 'text-white' ]);
}