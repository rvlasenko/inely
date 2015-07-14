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
                generate('{$type['title']}', '{$type['img']}', '{$body}',
                    '{$type['link']}', '{$type['linkDesc']}');
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
