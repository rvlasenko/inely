<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link   http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace frontend\modules\user\controllers;

use frontend\modules\user\models\LoginForm;
use Yii;
use yii\web\Response;

class SignInController extends AuthController
{
    /**
     * Вход в систему, используя принятые данные.
     * Также выполняется проверка модели и возвращается массив сообщений об ошибке в JSON формате.
     * @return array|string|Response
     */
    public function actionLogin()
    {
        $model   = new LoginForm();
        $message = Yii::t('frontend', 'The email or password you entered was incorrect. Please try again.');

        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            return $this->redirect(Yii::$app->urlManagerBackend->createUrl(false));
        } elseif (Yii::$app->request->isGet) {
            return $this->render('login', ['message' => false, 'display' => false]);
        } else {
            return $this->render('login', ['message' => $message, 'display' => true]);
        }
    }
}
