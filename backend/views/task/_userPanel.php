<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

use yii\helpers\HtmlPurifier;

?>

<header class="sidebar-header">
    <div class="form-group form-material">
        <span class="input-group-addon">
            <i class="fa fa-search"></i>
        </span>
        <input type="text" class="form-control empty input-lg input-search" id="searchText" spellcheck="false" autocomplete="off" placeholder="Поиск">
    </div>
    <div class="sidebar-widget author-widget">
        <div class="media">
            <a class="media-left" href="#">
                <img src="images/avatars/4.jpg" class="img-responsive">
            </a>

            <div class="media-body">
                <div class="media-links">
                    <a href="#" class="sidebar-menu-toggle">Меню</a> &dash;
                    <a href="/logout" data-method="post">Выйти</a>
                </div>
                <div class="media-author"><?= HtmlPurifier::process(Yii::$app->user->identity->username) ?></div>
            </div>
        </div>
    </div>
</header>