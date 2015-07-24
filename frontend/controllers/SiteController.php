<?php
namespace frontend\controllers;

use frontend\models\ContactForm;
use Yii;
use yii\web\Controller;

/**
 * Основной контроллер
 */
class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 60
            ]
        ];
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if ($action->id == 'error')
                $this->layout = '_error';
            return true;
        } else
            return false;
    }

    /**
     * @return string
     * Определение категории пользователя
     * Также из модели дергаются методы и всё отправляется в index
     */

    public function actionIndex()
    {
        return Yii::$app->user->isGuest ?
            $this->redirect(Yii::$app->urlManagerFrontend->createUrl('')) :
            $this->redirect(Yii::$app->urlManagerBackend->createUrl(''));
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->contact(getenv('ROBOT_EMAIL')))
                return $this->redirect(\Yii::$app->request->getReferrer());
        }

        return $this->renderAjax('contact', ['model' => $model]);
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;

        if ($exception !== null)
            return $this->render('error', ['exception' => $exception]);
    }
}
