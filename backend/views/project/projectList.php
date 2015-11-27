<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

echo \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'summary'      => false,
    'emptyText'    => '',
    'itemView'     => function ($model, $key) {
        return $this->render('_projectView', ['model' => $model, 'key' => $key]);
    }
]);