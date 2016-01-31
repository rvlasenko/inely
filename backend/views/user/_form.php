<?php

use yii\bootstrap\ActiveForm;
use kato\DropZone;
use yii\helpers\Html;

/* @var $form yii\bootstrap\ActiveForm */
/* @var $userProfile common\models\UserProfile */
/* @var $userModel backend\models\UserForm */

// Форма ввода имени
$form = ActiveForm::begin(['id' => 'user-settings']);
    echo $form->field($userProfile, 'firstname', ['options' => ['class' => 'col-md-6']]);
ActiveForm::end();

// Форма ввода email
$form = ActiveForm::begin(['id' => 'account-settings']);
    echo $form->field($userModel, 'email', ['options' => ['class' => 'col-md-6']]);
ActiveForm::end();

$form = ActiveForm::begin([
    'id'      => 'avatar-upload',
    'action'  => 'user/upload',
    'options' => [
        'class'   => 'col-xs-12 col-sm-12',
        'enctype' => 'multipart/form-data'
    ]
]);

echo DropZone::widget([
    'options'      => [
        'url'                => '/user/upload',
        'acceptedFiles'      => 'image/*',
        'paramName'          => 'avatar',
        'dictDefaultMessage' => '<i class="fa fa-cloud-upload"></i><span class="sub-text">Загрузите новую аватарку</span>',
        'maxFilesize'        => 2,
        'maxFiles'           => 1,
        'autoProcessQueue'   => false,
        'addRemoveLinks'     => true
    ],
    'clientEvents' => [
        'success'     => 'function() {
            location.reload();
        }',
        'error'       => 'function() {
            alert("Не больше одного файла!");
        }',
        'addedfile'   => 'function() {
            $("#load").prop("disabled", false);
            $(".dz-message").css("display", "none");
        }',
        'removedfile' => 'function() {
            $("#load").prop("disabled", true);
            $(".dz-message").css("display", "block");
        }'
    ]
]);

echo Html::submitButton('Загрузить', [
    'disabled' => 'true',
    'id'       => 'load',
    'class'    => 'btn btn-danger btn-sm ph15 next-button-container'
]);

ActiveForm::end();