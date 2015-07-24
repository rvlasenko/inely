<?php
    use yii\helpers\ArrayHelper;

    /* @var $this \yii\web\View */
    /* @var $content string */
?>

<?php if (Yii::$app->session->hasFlash('alert')): ?>
    <?php
    $body = ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body');
    $type = ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options');
    $flash = <<<FLASH
        $(document).ready(function() {
            setTimeout(function() {
                generate('{$type['title']}', '{$type['img']}', '{$body}',
                    '{$type['link']}', '{$type['linkDesc']}');
            }, 1500);
        });
FLASH;
    $this->registerJs($flash)
    ?>

<?php endif ?>

<?php \yii\widgets\Pjax::begin() ?>
<div class="row">
    <div class="col-md-12">
        <?php if ($dataProvider->count > 0): ?>
            <ul class="timeline">
                <?php foreach ($dataProvider->getModels() as $model): ?>
                    <?php if (!isset($date) || $date != Yii::$app->formatter->asDate($model->created_at)): ?>
                        <!-- timeline time label -->
                        <li class="time-label">
                            <span class="bg-blue">
                                <?= Yii::$app->formatter->asDate($model->created_at) ?>
                            </span>
                        </li>
                        <?php $date = Yii::$app->formatter->asDate($model->created_at) ?>
                    <?php endif; ?>
                    <li>
                        <?php
                        try {
                            $viewFile = sprintf('%s/%s', $model->category, $model->event);
                            echo $this->render($viewFile, ['model' => $model]);
                        } catch (\yii\base\InvalidParamException $e) {
                            echo $this->render('_item', ['model' => $model]);
                        }
                        ?>
                    </li>
                <?php endforeach; ?>
                <li>
                    <i class="fa fa-clock-o">
                    </i>
                </li>
            </ul>
        <?php else: ?>
            <?php echo Yii::t('backend', 'No events found') ?>
        <?php endif; ?>
    </div>
    <div class="col-md-12 text-center">
        <?php echo \yii\widgets\LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'options' => ['class' => 'pagination']
        ]) ?>
    </div>
</div>
<?php \yii\widgets\Pjax::end() ?>
