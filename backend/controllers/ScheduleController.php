<?php

namespace backend\controllers;

use yii\web\Controller;

class ScheduleController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
