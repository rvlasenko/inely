<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

?>

<aside id="sidebar_left" class="sidebar-light">
    <div class="nano-content">

        <?= $this->render('_leftHeader') ?>

        <ul class="nav sidebar-menu">
            <li>
                <a href="#" class="active inboxGroup">
                    <span class="fa fa-inbox"></span>
                    <span class="sidebar-title">Входящие</span>
                    <span class="counter inbox"></span>
                </a>
            </li>
            <li>
                <a href="#" class="todayGroup">
                    <span class="fa fa-sun-o"></span>
                    <span class="sidebar-title">Сегодня</span>
                    <span class="counter today"></span>
                </a>
            </li>
            <li>
                <a href="#" class="nextGroup">
                    <span class="fa fa-calendar"></span>
                    <span class="sidebar-title">Следующие 7 дней</span>
                    <span class="counter next7days"></span>
                </a>
            </li>
        </ul>

        <div id="projects">
            <div class="control br-t-n ptn">Проекты</div>
            <div class="projectTree mb10"></div>
            <div class="a-form project mb10" hidden>
                <div class="form-group form-material">
                    <span class="input-group-addon color-pick">
                        <i class="fa fa-circle"></i>
                    </span>
                    <input type="text" class="form-control input-lg input-proj pl50 empty" id="projectInput" placeholder="Write here something" spellcheck="false" autocomplete="off">
                </div>
            </div>
            <a href="#" class="actionProject" data-role="next">
                <svg class="svgIcon ml22" viewBox="0 0 32 32">
                    <polygon points="28,14 18,14 18,4 14,4 14,14 4,14 4,18 14,18 14,28 18,28 18,18 28,18"></polygon>
                </svg>
                <span class="pl10">Добавить</span>
            </a>
        </div>
    </div>
</aside>