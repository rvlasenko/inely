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
        <p class="small center accept-terms">
            Регистрируясь, вы соглашаетесь с нашими
            <a href="http://www.wunderlist.com/terms-of-use" target="_blank">Условия использования</a> и <a href="http://www.wunderlist.com/privacy-policy" target="_blank">Политика конфиденциальности </a>.
        </p>
    </div>
    <ul class="card benefits">
        <li>
            <span class="icon tick">
            <svg width="100%" height="100%" viewBox="0 0 38 34" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g transform="translate(-701.000000, -301.000000)" stroke="#2B88D9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g transform="translate(231.000000, 238.000000)">
                            <g transform="translate(451.000000, 51.000000)">
                                <g>
                                    <g transform="translate(20.000000, 0.000000)">
                                        <path d="M35.2941176,13 C25.7717647,22.7128 18.6258824,32.3968 11.7411765,44.2 C8.18352941,40.5712 4.24470588,37.3528 0,34.6"></path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>
            </span>
            <div class="details">
                <summary>Достигайте цели</summary>
                Независимо от того, что Вы собираетесь делать - поделиться списком покупок с любимым человеком или поработать над проектом - с помощью Wunderlist любое дело станет простым и приятным.
            </div>
        </li>
        <li>
            <span class="icon cloud">
            <svg width="50px" height="37px" viewBox="0 0 50 37" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g transform="translate(-696.000000, -409.000000)" stroke="#2B88D9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g transform="translate(231.000000, 238.000000)">
                            <g transform="translate(451.000000, 51.000000)">
                                <g>
                                    <g transform="translate(0.000000, 52.000000)">
                                        <g transform="translate(15.000000, 69.000000)">
                                            <path d="M31,13 L31,18 L27,18 M31,21 C30.7415693,24.908 27.4931553,28 23.5125209,28 C19.363606,28 16,24.642 16,20.5 C16,16.358 19.363606,13 23.5125209,13 C26.7819699,13 29.5565943,15.089 30.5883139,18"></path>
                                            <path d="M13.7142857,35 L10.2857143,35 C4.60457143,35 0,30.2995 0,24.5 C0,19.754 3.10285714,15.792 7.33371429,14.49 C7.056,13.496 6.85714286,12.4635 6.85714286,11.375 C6.85714286,5.0925 11.8457143,0 18,0 C22.5874286,0 26.52,2.8315 28.2274286,6.874 C29.4137143,5.8765 30.9154286,5.25 32.5714286,5.25 C36.36,5.25 39.4285714,8.3825 39.4285714,12.25 C39.4285714,12.9115 39.3085714,13.5415 39.1405714,14.147 C44.1394286,14.861 48,19.201 48,24.5 C48,30.2995 43.3954286,35 37.7142857,35 L34.2857143,35 L13.5111111,35"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>
            </span>
            <div class="details">
                <summary>Напоминания в любое время</summary>
                Вы никогда не забудете о встрече, сроке исполнения или о молоке. Wunderlist позволяет Вам с легкостью установить напоминания, с помощью которых Вы будете помнить все, и большие события и мелочи.
            </div>
        </li>
        <li>
            <span class="icon people">
            <svg width="44px" height="37px" viewBox="0 0 44 37" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g transform="translate(-699.000000, -520.000000)" stroke="#2B88D9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <g transform="translate(231.000000, 238.000000)">
                            <g transform="translate(451.000000, 51.000000)">
                                <g>
                                    <g transform="translate(0.000000, 162.000000)">
                                        <path d="M39.7943158,77.4 C39.7943158,73.1622667 36.538,70 32.5263158,70 C28.5146316,70 25.2631579,73.1622667 25.2631579,77.4 C25.2631579,82.7946 28.3282105,89.7333333 32.5287368,89.7333333 C36.7631579,89.7333333 39.7943158,82.7946 39.7943158,77.4 L39.7943158,77.4 Z M27.6842105,92.2 C27.3186316,92.5675333 26.8610526,92.8240667 26.3623158,92.9449333 L22.3603158,93.9069333 C20.4525263,94.3682 19.0071579,95.9518 18.6948421,97.9202 L18,102.288667 C18,102.288667 21.3507368,104.533333 32.5263158,104.533333 C43.6994737,104.533333 47.0526316,102.288667 47.0526316,102.288667 L46.3602105,97.9202 C46.0454737,95.9518 44.6001053,94.3682 42.6923158,93.9069333 L38.6903158,92.9449333 C38.1915789,92.8240667 37.734,92.5675333 37.3684211,92.2 M54.3230526,80.5869333 C54.3230526,77.4641333 51.8874737,74.9333333 48.8781053,74.9333333 C45.8711579,74.9333333 43.4355789,77.4641333 43.4355789,80.5869333 C43.4355789,84.1414 45.4547368,88.5 48.8781053,88.5 C52.3038947,88.5 54.3230526,84.1414 54.3230526,80.5869333 L54.3230526,80.5869333 Z M53.1052632,90.9296667 C53.4635789,91.3588667 53.9211579,91.6918667 54.4368421,91.8990667 L56.4414737,92.7056667 C57.5696842,93.1595333 58.4025263,94.161 58.6567368,95.3721333 L59.1578947,97.75 C59.1578947,97.75 56.8118947,99.3681333 51.8947368,99.6"></path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>
            </span>
            <div class="details">
                <summary>Всё синхронизировано, сэр</summary>
                Оставайтесь мотивированными, постепенно повышая свой уровень, зарабатывая достижения и приятные бонусы, выполняя задачи и используя функции Inely. Бросьте себе вызов.
            </div>
        </li>
    </ul>
</div>