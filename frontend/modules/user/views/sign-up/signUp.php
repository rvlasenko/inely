<?php

use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = Yii::t('frontend', 'Signup ~ Inely');

?>

<div class="logo"></div>
<div id="loader-wrapper">
    <div id="loader"></div>
</div>
<h4 class="branding signup">Получите Inely бесплатно</h4>

<div class="wrapper signup">
    <div class="card signup">
        <?php Pjax::begin(['enablePushState' => false]) ?>
        <?php ActiveForm::begin(['options' => ['class' => 'auth-form signup', 'data-pjax' => true]]) ?>
            <div class="row name">
                <input type="text" name="username" placeholder="Имя" title="Пожалуйста укажите ваше имя" required autofocus>
            </div>
            <div class="row email">
                <input type="email" name="email" pattern="^[^\s@＠=]+[@|＠][^\.\s@＠]+(\.[^\.\s@＠]+)+$" placeholder="Email" title="Пожалуйста, введите корректный email" required>
            </div>
            <div class="row password">
                <input type="password" name="password" required="" pattern=".{8,}" minlength="8" placeholder="Пароль" title="<?= Yii::t('frontend', 'Your password must have at least 8 characters') ?>">
            </div>
            <div class="errors" style="<?= $display ? 'display: table' : 'display: none' ?>">
                <div role="alert" class="message"><?= $message ?></div>
            </div>
            <div class="row submit">
                <input type="submit" id="submit" class="button big blue" value="Зарегистрироваться">
            </div>
        <?php ActiveForm::end() ?>
        <?php Pjax::end() ?>
        <div class="buttons-external has-more">
            <a href="/oauth?authclient=vkontakte" class="icon-button vk"><i class="icon-vk"></i><span></span></a>
            <a href="/oauth?authclient=facebook" class="icon-button facebook"><i class="icon-facebook"></i><span></span></a>
            <a href="/oauth?authclient=google" class="icon-button google-plus"><i class="icon-google-plus"></i><span></span></a>
        </div>
        <span class="link login">Уже зарегистрированы? <a href="/login">Войти</a></span>
    </div>
    <ul class="card benefits">
        <li>
            <span class="icon tick">
                <i class="icon-check"></i>
            </span>
            <div class="details">
                <summary>Достигайте цели</summary>
                Независимо от того, что Вы собираетесь делать - поделиться списком покупок с любимым человеком или поработать над проектом - с помощью Inely любое дело станет простым и приятным.
            </div>
        </li>
        <li>
            <span class="icon cloud">
                <i class="icon-envelope-open"></i>
            </span>
            <div class="details">
                <summary>Напоминания в любое время</summary>
                Вы никогда не забудете о встрече, сроке исполнения или о молоке. Inely позволяет Вам с легкостью установить напоминания, с помощью которых Вы будете помнить все, и большие события и мелочи.
            </div>
        </li>
        <li>
            <span class="icon people">
                <i class="icon-game-controller"></i>
            </span>
            <div class="details">
                <summary>Увлекательное планирование</summary>
                Оставайтесь мотивированными, постепенно повышая свой уровень, зарабатывая достижения, просто выполняя задачи в Inely. Бросьте себе вызов.
            </div>
        </li>
    </ul>
</div>