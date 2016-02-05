<?php

use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = Yii::t('frontend', 'Reset password ~ Inely');

?>

<div class="logo"></div>

<div class="card forgot-password">
    <?php Pjax::begin(['enablePushState' => false]) ?>
    <?php ActiveForm::begin(['options' => ['class' => 'auth-form forgot-password', 'data-pjax' => true]]) ?>
        <div class="row labels">
            <h2>Забыли пароль?</h2>

            <h3>Не переживайте. Просто введите ниже свой email, и мы вышлем вам инструкцию по восстановлению пароля.</h3>
        </div>
        <div class="row email">
            <input type="email" name="email" pattern="^[^\s@＠=]+[@|＠][^\.\s@＠]+(\.[^\.\s@＠]+)+$" title="Пожалуйста, введите корректный email" placeholder="Email" required autofocus autocomplete>
        </div>
        <div class="errors" style="<?= $display ? 'display: table' : 'display: none' ?>">
            <div role="alert" class="message"><?= $message ?></div>
        </div>
        <div class="row submit">
            <input type="submit" class="button big blue" value="Восстановить пароль">
        </div>
    <?php ActiveForm::end() ?>
    <?php Pjax::end() ?>

  <span class="link login">Уже зарегистрированы? <a href="/login">Войти</a></span>
</div>