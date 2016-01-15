<?php

/**
 * Этот контроллер является частью проекта Inely.
 *
 * @link    http://github.com/hirootkit/inely
 * @licence http://github.com/hirootkit/inely/blob/master/LICENSE.md GPL
 * @author  hirootkit <admiralexo@gmail.com>
 */

namespace frontend\modules\user\controllers;

use frontend\modules\user\models\PasswordResetRequestForm;
use frontend\modules\user\models\ResetPasswordForm;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class ResetPassController extends AuthController
{
    /**
     * Передача сообщения о востановлении данных на email со ссылкой для сброса пароля.
     * @return string|Response редирект на страницу входа.
     */
    public function actionRequestPasswordReset()
    {
        $model   = new PasswordResetRequestForm();
        $message = null;
        $display = false;

        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            if ($model->sendEmail()) {
                $message = Yii::t('frontend', 'Please check your email for instructions to reset your password.');
                $display = true;
            } else {
                $message = Yii::t('frontend', 'Sorry, we are unable to reset password for email provided');
                $display = true;
            }
        }

        return $this->render('requestPasswordReset', ['message' => $message, 'display' => $display]);
    }

    /**
     * Сброс пароля и запись flash сообщения.
     *
     * @param $token уникальный токен.
     *
     * @return string|Response редирект на Dashboard.
     * @throws BadRequestHttpException если произошла ошибка при создании формы 'ResetPassword'.
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post(), '')) {
            if ($model->validate() && $model->resetPassword()) {
                return $this->redirect(Yii::$app->urlManagerBackend->createUrl(false));
            } else {
                $message = Yii::t('frontend', 'The passwords you entered do not match.');

                return $this->render('requestPasswordReset', ['message' => $message, 'display' => true]);
            }
        }

        return $this->render('requestPasswordReset', ['message' => false, 'display' => false]);
    }
}
