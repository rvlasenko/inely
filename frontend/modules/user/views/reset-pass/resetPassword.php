<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = Yii::t('frontend', 'Reset password ~ Inely');

?>

<div class="logo"></div>
<div class="card reset-password">
    <?php Pjax::begin(['enablePushState' => false]) ?>
    <?php ActiveForm::begin(['options' => ['class' => 'auth-form reset-password', 'data-pjax' => true]]) ?>
        <div class="row labels">
            <h2>Новый пароль</h2>
            <h3>Привет, пришло время создать Ваш новый пароль для Inely</h3>
        </div>
        <div class="row password">
            <input type="password" name="password" required autofocus autocomplete="off" pattern=".{8,}" minlength="8" title="<?= Yii::t('frontend', 'Your password must have at least 8 characters') ?>" placeholder="<?= Yii::t('frontend', 'New Password') ?>">
        </div>
        <div class="row confirmation">
            <input type="password" name="passwordConfirm" required autocomplete="off" pattern=".{8,}" minlength="8" title="<?= Yii::t('frontend', 'Your password must have at least 8 characters') ?>" placeholder="<?= Yii::t('frontend', 'Re-enter Your New Password') ?>">
        </div>
        <div class="errors" style="<?= $display ? 'display: table' : 'display: none' ?>">
            <div role="alert" class="message"><?= $message ?></div>
        </div>
        <div class="row submit">
            <input type="submit" class="button big blue" value="<?= Yii::t('frontend', 'Reset Password') ?>">
        </div>
    <?php ActiveForm::end() ?>
    <?php Pjax::end() ?>
</div>