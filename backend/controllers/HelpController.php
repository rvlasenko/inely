<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace backend\controllers;

use yii\web\Controller;

class HelpController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
