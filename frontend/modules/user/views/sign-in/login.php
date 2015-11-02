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

$this->title = Yii::t('frontend', 'Login ~ Inely');

?>

<div class="logo"></div>
<div id="loader-wrapper">
    <div id="loader"></div>
</div>
<div class="card login">
    <?php Pjax::begin(['enablePushState' => false]) ?>
    <?php ActiveForm::begin(['options' => ['class' => 'auth-form login', 'data-pjax' => true]]) ?>
        <div class="row name">
            <input type="email" name="email" pattern="^[^\s@＠=]+[@|＠][^\.\s@＠]+(\.[^\.\s@＠]+)+$" placeholder="Email" title="Пожалуйста, введите корректный email" required autofocus>
        </div>
        <div class="row password">
            <input type="password" name="password" placeholder="Пароль" title="<?= Yii::t('frontend', 'Your password must have at least 8 characters') ?>" required>
        </div>
        <div class="errors" style="<?= $display ? 'display: table' : 'display: none' ?>">
            <div role="alert" class="message"><?= $message ?></div>
        </div>
        <div class="row submit">
            <input type="submit" id="submit" class="button big blue" value="Войти">
        </div>
        <span class="link forgot-password">
            <a href="/forgotpass">Забыли пароль?</a>
        </span>
    <?php ActiveForm::end() ?>
    <?php Pjax::end() ?>

    <div class="buttons-external has-more">
        <a href="/oauth?authclient=vkontakte" class="icon-button vk"><i class="icon-vk"></i><span></span></a>
        <a href="/oauth?authclient=facebook" class="icon-button facebook"><i class="icon-facebook"></i><span></span></a>
        <a href="/oauth?authclient=google" class="icon-button google-plus"><i class="icon-google-plus"></i><span></span></a>
    </div>
    <span class="link signup">Нет учетной записи? <a href="/signup">Создать учетную запись</a></span>
</div>
