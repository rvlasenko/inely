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

        <!-- sidebar menu -->
        <ul class="nav sidebar-menu">

            <li>
                <a href="#" class="active">
                    <span class="fa fa-inbox"></span>
                    <span class="sidebar-title">Входящие</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="fa fa-sun-o"></span>
                    <span class="sidebar-title">Сегодня</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="fa fa-calendar"></span>
                    <span class="sidebar-title">Следующие 7 дней</span>
                </a>
            </li>

            <div class="divider"></div>
            <li>
                <a href="#">
                    <span class="fa fa-send-o"></span>
                    <span class="sidebar-title">Обзор</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="fa fa-tasks"></span>
                    <span class="sidebar-title">Все задачи</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="fa fa-bullseye"></span>
                    <span class="sidebar-title">Цели</span>
                </a>
            </li>
            <div class="divider"></div>

        </ul>

        <div id="projTree"></div>
    </div>
</aside>