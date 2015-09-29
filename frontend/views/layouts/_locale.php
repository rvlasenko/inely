<?php

use yii\helpers\Html;

$locales = Yii::$app->params['availableLocales'];
$val     = 0;

foreach ($locales as $key => $language) {
    echo Html::a($language, ['/site/set', 'locale' => $key]);
    if (++$val !== count($locales)) echo Html::tag('span', ' / ', ['class' => 'text-white']);
}