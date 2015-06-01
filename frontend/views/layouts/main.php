<?php
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use kartik\alert\AlertBlock;

/* @var $this \yii\web\View */
/* @var $content string */

if (!Yii::$app->user->isGuest)
    $this->beginContent('@frontend/views/layouts/_base.php');
else
    $this->beginContent('@frontend/views/layouts/_landing.php');
?>

<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>

<?php if (Yii::$app->session->hasFlash('alert')): ?>
<?= AlertBlock::widget([
        'useSessionFlash' => false,
        'type' => AlertBlock::TYPE_GROWL,
        'alertSettings' => [
            'alert' => [
                'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
            ],
            'settings' => [
                'type' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
            ]
        ]
    ]);
?>
<?php endif; ?>

<?= $content ?>

<?php
    $this->endContent();
?>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="loader">Загрузка...</div>
            </div>
        </div>
    </div>
</div>