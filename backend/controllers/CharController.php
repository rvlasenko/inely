<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author hirootkit
 */

namespace backend\controllers;

use common\models\User;
use common\models\UserProfile;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class CharController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions'      => ['index'],
                        'allow'        => false,
                        'roles'        => ['?'],
                        'denyCallback' => function () {
                            return $this->redirect(['/login']);
                        }
                    ]
                ]
            ]
        ];
    }

    /**
     * Проверка статуса пользователя и определение дальнейшего действия.
     * Если пользователь подтвержден, он редиректится на Dashboard.
     * @return homeUrl редирект на домашнюю страницу.
     */
    public function actionIndex()
    {
        $this->layout = 'welcome';
        $model        = new UserProfile();

        if (Yii::$app->user->identity->status == User::STATUS_ACTIVE) {
            return $this->goHome();
        } else {
            return $this->render('index', [
                'model' => $model,
                'i18n'  => Yii::t('backend', 'Are you sure?')
            ]);
        }
    }

    /**
     * Выбор любимца из списка достпных персонажей.
     * @return homeUrl редирект на домашнюю страницу.
     * @throws HttpException если сохранение пошло не так.
     */
    public function actionChar()
    {
        if (Yii::$app->request->post()) {
            if ((new User)->setActive() && (new UserProfile)->setDefChar($_POST['mascot'][0])) {
                return $this->goHome();
            } else {
                throw new HttpException(500, 'Unable to save user data');
            }
        } else {
            return $this->goHome();
        }
    }

    /**
     * Загрузка собственного персонажа на сервер.
     * Если загрузка осуществилась успешно, пользовательский статус обновляется.
     *
     * @property string $fileName   экземпляр загруженного файла.
     * @property string $uploadPath путь к файлу, соответствующий алиасу.
     * @return bool|string закодированная JSON строка файла.
     * @throws HttpException если сохранение пошло не так.
     *
     * Возвращается null, если файла почему-то не существует в массиве.
     */
    public function actionUpload()
    {
        $fileName   = 'mascot_path';
        $uploadPath = Yii::getAlias('@storage/web/source/');

        if (isset($_FILES[$fileName]) && Yii::$app->request->isPost) {
            $file = UploadedFile::getInstanceByName($fileName);

            if ($file->saveAs($uploadPath . $file->name)) {
                if ((new User)->setActive() && (new UserProfile)->setOwnChar($uploadPath . $file->name)) {
                    return Json::encode($file);
                } else {
                    throw new HttpException(500, 'Unable to save user data');
                }
            }
        } else {
            return $this->goHome();
        }

        return null;
    }

    /**
     * Поиск модели "UserProfile" на основе её первичного ключа.
     * Если модель не найдена, будет сгенерировано исключение HTTP со статусом 404.
     *
     * @param int $id
     *
     * @return модель UserProfile
     * @throws NotFoundHttpException если модель не может быть найдена.
     */
    protected function findModel($id)
    {
        if (($model = UserProfile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
