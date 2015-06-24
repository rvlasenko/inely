<?php
namespace frontend\controllers;

use frontend\models\ContactForm;
use frontend\modules\user\models\Tasks;
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
            ],
        ];
    }

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ]
        ];
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if ($action->id == 'error')
                $this->layout = '_error';
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     * Определение категории пользователя и вывод
     * Также из модели дергаются методы и всё отправляется в index
     */

    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            $model = new Tasks();
            $tasks = $model->getTasks();

            return $this->render('index', [
                'tasks' => $tasks,
            ]);
        }
        else {
            return $this->render('landing');
        }
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->contact(getenv('ROBOT_EMAIL'))) {
                return $this->redirect(\Yii::$app->request->getReferrer());
            }
        }

        return $this->renderAjax('contact', [
            'model' => $model
        ]);
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }
}
