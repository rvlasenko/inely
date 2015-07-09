<?php
    use yii\helpers\ArrayHelper;

    /* @var $this \yii\web\View */
    /* @var $content string */

    if (!Yii::$app->user->isGuest)
        $this->beginContent('@frontend/views/layouts/_base.php');
    else
        $this->beginContent('@frontend/views/layouts/_landing.php');
?>

<?php if (Yii::$app->session->hasFlash('alert')): ?>
<?php
    $body = ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body');
    $type = ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options');
    $flash = <<<FLASH
        $(document).ready(function() {
            setTimeout(function() {
                generate({$type['title']}, {$type['img']}, {$body},
                    {$type['link']}, {$type['linkDesc']});
            }, 1500);
        });
FLASH;
    $this->registerJs($flash);
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
                <div class="loader"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-slideleft" id="modal-slideleft" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="c-primary m-b-30">Are you sure you want to proceed?</h2>
                        <button type="button" class="btn btn-primary btn-embossed btn-block" data-dismiss="modal">Yes, I'm sure</button>
                        <button type="button" data-dismiss="modal" class="btn btn-white btn-block">Oops, I prefer not!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>