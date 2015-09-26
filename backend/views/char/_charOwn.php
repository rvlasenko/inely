<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author hirootkit
 */

use kato\DropZone;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$i18n = Yii::t("backend", "For the best view we recommend PNG format!");
$dictMessage = <<<MSG
    <i class="fa fa-cloud-upload"></i>
    <span class="main-text"><b>Drop Files</b> to upload</span>
    <br>
    <span class="sub-text">$i18n</span>
MSG;

?>

<?php $form = ActiveForm::begin([ 'action' => 'char/upload', 'options' => [ 'enctype' => 'multipart/form-data' ] ]) ?>
    <div class="mt10 char-t hidden">
        <div class="ovh text-black">
            <i class="icon-def-mascot intro-icon"></i>

            <div class="intro-title fs35 fw300 mb20"><?= Yii::t('backend', 'Try something interesting!') ?>
                <div class="intro-subtitle fs16 mt15 fw300 lh25">
                    <p><?= Yii::t('backend', 'In addition to the default characters you can download own. What could be better?') ?></p>

                    <p><?= Yii::t('backend', 'Unfortunately, in this version some features might become unstable. <a href="#" id="start">I\'ve Changed My Mind</a>') ?></p>
                </div>
            </div>
        </div>
        <div class="pl25 pr25 pb25 intro">
            <div class="ml10">
                <?= DropZone::widget([
                    'options'      => [
                        'url'                => '/char/upload',
                        'maxFilesize'        => 2,
                        'acceptedFiles'      => 'image/*',
                        'maxFiles'           => 1,
                        'addRemoveLinks'     => true,
                        'paramName'          => 'mascot_path',
                        'autoProcessQueue'   => false,
                        'dictDefaultMessage' => $dictMessage
                    ],
                    'clientEvents' => [
                        'success'     => "function(file) { alert('" . Yii::t('backend', 'Your character has been uploaded!') . "'); location.reload(); }",
                        'error'       => 'function(file) { alert("' . Yii::t('backend', 'No more files!') . '") }',
                        'addedfile'   => 'function(file) { $("#fin").prop("disabled", false) }',
                        'removedfile' => 'function(file) { $("#fin").prop("disabled", true) }'
                    ]
                ]) ?>
                <div class="next-button-container">
                    <?= Html::submitButton(Yii::t('backend', 'Finish'), [
                        'disabled' => 'true',
                        'id'       => 'fin',
                        'class'    => 'btn next-butt text-white btn-rounded btn-block'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end() ?>