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

        <!-- Start: Sidebar Header -->
        <header class="sidebar-header">
            <div class="sidebar-widget search-widget">
                <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-search"></i>
                        </span>
                    <input type="text" id="sidebar-search" class="form-control" placeholder="Search...">
                </div>
            </div>
            <div class="sidebar-widget author-widget">
                <div class="media">
                    <a class="media-left" href="#">
                        <img src="images/avatars/4.jpg" class="img-responsive">
                    </a>

                    <div class="media-body">
                        <div class="media-links">
                            <a href="#" class="sidebar-menu-toggle">User Menu -</a>
                            <a href="pages_login(alt).html">Logout</a>
                        </div>
                        <div class="media-author">Michael Richards</div>
                    </div>
                </div>
            </div>
        </header>
        <!-- End: Sidebar Header -->

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

    </div>
</aside>