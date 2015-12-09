<?= \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'summary'      => false,
    'emptyText'    => 'У вас нет активных проектов',
    'options'      => ['class' => 'jstree-neutron'],
    'itemView'     => function ($model, $key) {
        return $this->render('_projectView', ['model' => $model, 'key' => $key]);
    }
]);