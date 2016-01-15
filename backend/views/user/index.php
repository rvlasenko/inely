<?php

use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $userProfile common\models\UserProfile */
/* @var $userModel backend\models\UserForm */
/* @var $form yii\bootstrap\ActiveForm */

?>

<div class="panel panel-info">
    <div class="panel-heading">
        <span class="panel-title">Профиль <?= Yii::$app->user->identity->username ?></span>
    </div>
    <div class="panel-body">
        <div class="media clearfix">
            <div class="media-left pr30">
                <a href="#">
                    <span class="chart" style="position:relative;" data-percent="40">
                        <img class="media-object mw150" src="<?= Yii::$app->user->identity->userProfile->getAvatar() ?>" alt="...">
                    </span>
                </a>
            </div>
            <div class="media-body va-m">
                <h2 class="media-heading text-primary fs22"><?= $this->params['firstName'] ?>
                    <small> - новичок</small>
                </h2>
                <p class="lead">12 выполненных задач и 2 значка!</p>

                <div class="badges">
                    <div class="badges">
                        <div class="achievement">
                            <img alt="Badge" src="/images/badges/badge.started.png" title="Новичок" width="50">
                            <div class="achievement-rank">Новичок</div>
                            <div class="achievement-date">01-22-2013</div>
                        </div>
                        <div class="achievement">
                            <img alt="Badge" src="/images/badges/badge.turkey.png" title="3 подряд" width="50">
                            <div class="achievement-rank">3 подряд</div>
                            <div class="achievement-date">01-22-2013</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="divider nav-pad-top"></div>
        <div class="user-profile-form">
            <?php $form = ActiveForm::begin(['id' => 'user-settings']) ?>

            <?= $form->field($userProfile, 'firstname', [
                'options' => ['class' => 'col-md-6']
            ])->textInput(['maxlength' => 30]) ?>

            <?= $form->field($userProfile, 'lastname', [
                'options' => ['class' => 'col-md-6']
            ])->textInput(['maxlength' => 40]) ?>

            <?php ActiveForm::end() ?>

            <?php $form = ActiveForm::begin(['id' => 'account-settings']) ?>

            <?= $form->field($userModel, 'email', [
                'options' => ['class' => 'col-md-12']
            ]) ?>

            <?php ActiveForm::end() ?>
        </div>
    </div>
    <div class="panel-footer text-right">
        <button class="btn btn-primary btn-sm ph15" id="send-profile" type="submit">Готово</button>
    </div>
</div>