<?php

/**
 * Этот контроллер является частью проекта Inely.
 *
 * @link    http://github.com/hirootkit/inely
 * @licence http://github.com/hirootkit/inely/blob/master/LICENSE.md GPL
 * @author  hirootkit <admiralexo@gmail.com>
 */

namespace backend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Class DocsController
 * @package backend\controllers
 */
class DocsController extends Controller
{
    public $layout = 'support';

    public function actionIndex()
    {
        return $this->render('index');
    }
}
