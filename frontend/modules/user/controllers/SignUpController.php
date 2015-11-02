<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link   http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace frontend\modules\user\controllers;

use common\models\User;
use frontend\modules\user\models\ConfirmEmailForm;
use frontend\modules\user\models\SignupForm;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class SignUpController extends AuthController
{
    /**
     * Регистрация пользователя.
     *
     * @return string|Response редирект на Dashboard либо вывод результата рендеринга.
     */
    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post(), '')) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->redirect(Yii::$app->urlManagerBackend->createUrl(false));
                }
            } else {
                $message = Yii::t('frontend', 'This email address has already been taken');
                return $this->renderAjax('signUp', ['message' => $message, 'display' => true]);
            }
        }

        return $this->render('signUp', ['message' => false, 'display' => false]);
    }

    /**
     * Подтверждение email и запись flash сообщения.
     *
     * @param string $token уникальный токен.
     *
     * @return Response редирект зависит от условия.
     * @throws BadRequestHttpException если произошла ошибка при создании формы 'ConfirmEmail'.
     */
    public function actionConfirmEmail($token)
    {
        $status = Yii::$app->user->identity->status;

        try {
            $model = new ConfirmEmailForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($status != User::STATUS_UNCONFIRMED && $model->confirmEmail()) {
            Yii::$app->session->setFlash('alert', [
                'title' => Yii::t('backend', 'Email confirmation'),
                'body'  => Yii::t('backend', 'Thanks! Account e-mail address confirmed successfully')
            ]);
        } elseif ($status == User::STATUS_UNCONFIRMED) {
            if ($model->confirmEmail()) {
                Yii::$app->session->setFlash('alert', [
                    'title' => Yii::t('backend', 'Email confirmation'),
                    'body'  => Yii::t('backend', 'Thanks! Account e-mail address confirmed successfully')
                ]);

                return $this->redirect('/welcome');
            }
        } else {
            Yii::$app->session->setFlash('alert', [
                'title' => Yii::t('backend', 'Email confirmation'),
                'body'  => Yii::t('backend', 'Sorry, an error occurred with confirmation')
            ]);
        }

        return $this->goHome();
    }

}
