<?php use kato\DropZone; use yii\helpers\Html; use yii\widgets\ActiveForm; ?>
<?php $this->registerJs('
    function submitCharForm() { if (confirm("' . $i18n . '")) $("#charPredefined").submit(); }

    // User select character
    $("#roboClick").click(function () {
        $("#robo").prop("checked", true);

        submitCharForm();
        return false
    });

    $("#eveClick").click(function () {
        $("#eve").prop("checked", true);

        submitCharForm();
        return false
    });
') ?>

<?php $form = ActiveForm::begin([ 'action' => 'char/char', 'id' => 'charPredefined' ]) ?>
    <div class="mt10 char-f">
    <div class="ovh text-black">
        <i class="icon-def-mascot intro-icon"></i>

        <div class="intro-title fs35 fw300 mb20"><?= Yii::t('backend', 'Hi! Nice to see you here.') ?>
            <div class="intro-subtitle fs16 mt15 fw300 lh25">
                <p><?= Yii::t('backend', 'My name is Robo. I\'m glad that you decided to visit Inely, and I would be happy to help you get started. I hope you will enjoy it!') ?></p>
                <p><?= Yii::t('backend', 'Please, choose someone who you like and we will continue. Be a little bit responsible :) <a href="#" id="own">Maybe you want own character?</a>') ?></p>
            </div>
        </div>
    </div>
    <div class="pl25 pr25 pb25 intro">
        <div class="ml10">
            <section id="grid" class="grid clearfix">
                <a href="#" id="roboClick" data-path-hover="m 180,34.57627 -180,0 L 0,0 180,0 z">
                    <figure>
                        <input type="radio" id="robo" class="hidden" name="mascot[]" value="Robo">
                        <img src="images/mascots/robo/present/500mm.png" />
                        <svg viewBox="0 0 180 320" preserveAspectRatio="none"><path d="M 180,160 0,218 0,0 180,0 z"/></svg>
                        <figcaption>
                            <h2><?= Yii::t('backend', 'Robo') ?></h2>
                            <p><?= Yii::t('backend', 'Robo was designed to be a friendly robot. He likes to achieve goals, play games, and helping people.') ?></p>
                            <button><?= Yii::t('backend', 'Befriend!') ?></button>
                        </figcaption>
                    </figure>
                </a>
                <a href="#" id="eveClick" data-path-hover="m 180,34.57627 -180,0 L 0,0 180,0 z">
                    <figure>
                        <input type="radio" id="eve" class="hidden" name="mascot[]" value="Eve">
                        <img src="images/mascots/eva/present/500mm.png" style="width: auto;" />
                        <svg viewBox="0 0 180 320" preserveAspectRatio="none"><path d="M 180,160 0,218 0,0 180,0 z"/></svg>
                        <figcaption>
                            <h2><?= Yii::t('backend', 'Eve') ?></h2>
                            <p><?= Yii::t('backend', 'EVE is one of several robots who are sent to Earth. She has a scanner she likes to fly and likes draw. After meeting you, she making a top priority to protect you.') ?></p>
                            <button><?= Yii::t('backend', 'Befriend!') ?></button>
                        </figcaption>
                    </figure>
                </a>
                <a href="#" data-path-hover="m 180,34.57627 -180,0 L 0,0 180,0 z">
                    <figure>
                        <img src="http://tympanus.net/Tutorials/ShapeHoverEffectSVG/img/3.png" />
                        <svg viewBox="0 0 180 320" preserveAspectRatio="none"><path d="M 180,160 0,218 0,0 180,0 z"/></svg>
                        <figcaption>
                            <h2><?= Yii::t('backend', 'Coming Soon...') ?></h2>
                        </figcaption>
                    </figure>
                </a>
                <a href="#" data-path-hover="m 180,34.57627 -180,0 L 0,0 180,0 z">
                    <figure>
                        <img src="http://tympanus.net/Tutorials/ShapeHoverEffectSVG/img/7.png" />
                        <svg viewBox="0 0 180 320" preserveAspectRatio="none"><path d="M 180,160 0,218 0,0 180,0 z"/></svg>
                        <figcaption>
                            <h2><?= Yii::t('backend', 'Coming Soon...') ?></h2>
                        </figcaption>
                    </figure>
                </a>
            </section>
        </div>
    </div>
</div>
<?php ActiveForm::end() ?>

<?php $form = ActiveForm::begin([ 'action' => 'char/upload', 'options' => [ 'enctype' => 'multipart/form-data' ] ]) ?>
    <div class="mt10 char-t hidden">
        <div class="ovh text-black">
            <i class="icon-def-mascot intro-icon"></i>

            <div class="intro-title fs35 fw300 mb20"><?= Yii::t('backend', 'Try something interesting!') ?>
                <div class="intro-subtitle fs16 mt15 fw300 lh25">
                    <p><?= Yii::t('backend', 'In addition to the default characters you can download own. What could be better?') ?></p>
                    <p><?= Yii::t('backend', 'Unfortunately, in this version some features might become unstable. <a href="#" id="start">Changed My Mind</a>') ?></p>
                </div>
            </div>
        </div>
        <div class="pl25 pr25 pb25 intro">
            <div class="ml10">
                <?= DropZone::widget([
                    'options' => [
                        'url' => '/char/upload',
                        'maxFilesize' => 2,
                        'acceptedFiles' => 'image/*',
                        'maxFiles' => 1,
                        'addRemoveLinks' => true,
                        'paramName' => 'mascot_path',
                        'autoProcessQueue' => false,
                        'dictDefaultMessage' => '<i class="fa fa-cloud-upload"></i><span class="main-text"><b>Drop Files</b> to upload</span><br><span class="sub-text">' . Yii::t("backend", "For the best view we recommend PNG format!") . '</span>'
                    ],
                    'clientEvents' => [
                        'success' => "function(file) { alert('" . Yii::t('backend', 'Your character has been uploaded!') . "') }",
                        'error' => 'function(file) { alert("' . Yii::t('backend', 'No more files!') . '") }',
                        'addedfile' => 'function(file) { $("#fin").prop("disabled", false) }',
                        'removedfile' => 'function(file) { $("#fin").prop("disabled", true) }'
                    ]
                ]) ?>
                <div class="next-button-container">
                    <?= Html::submitButton(Yii::t('backend', 'Finish'), [
                        'disabled' => 'true', 'id' => 'fin',
                        'class' => 'btn next-butt text-white btn-rounded btn-block'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end() ?>