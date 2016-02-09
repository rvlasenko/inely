<?php

/**
 * Этот контроллер является частью проекта Inely.
 *
 * @link    http://github.com/hirootkit/inely
 * @licence http://github.com/hirootkit/inely/blob/master/LICENSE.md GPL
 * @author  hirootkit <admiralexo@gmail.com>
 */

namespace backend\controllers;

use backend\models\GamifyAchievements;
use backend\models\GamifyUserStats;
use backend\models\UserForm;
use common\models\User;
use common\models\UserProfile;
use Yii;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * Class UserController
 * @package backend\controllers
 */
class UserController extends Controller
{
    public $defaultAction = 'profile';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post']
                ]
            ]
        ];
    }

    /**
     * Отображение одиночной модели пользователя.
     * @return string результат визуализации профиля.
     * @throws Exception если данные не прошли валидацию.
     */
    public function actionProfile()
    {
        $userModel    = new UserForm();
        $userIdentity = Yii::$app->user->identity;
        $userProfile  = $userIdentity->userProfile;
        $userStats    = (new GamifyUserStats())->getUserStats();

        $userModel->email = $userIdentity->email;
        $userProfile->load(Yii::$app->request->post());
        $userProfile->save();

        return $this->renderAjax('index', [
            'userProfile' => $userProfile,
            'userModel'   => $userModel,
            'userStats'   => $userStats
        ]);
    }

    /**
     * Обновление существующей модели пользовательского профиля.
     * @throws Exception если email не прошел валидацию.
     */
    public function actionAccount()
    {
        $userIdentity = Yii::$app->user->identity;
        $userModel    = new UserForm();

        if ($userModel->load(Yii::$app->request->post()) && $userModel->validate()) {
            $userIdentity->email = $userModel->email;

            if (!$userIdentity->save()) {
                throw new Exception('Ошибка при изменении параметров профиля.');
            }
        }
    }

    /**
     * Выход из системы и удаление аутентификационных данных.
     * @return редирект на лендинг
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(Yii::$app->urlManagerFrontend->createUrl(false));
    }

    /**
     * Загрузка аватарки на сервер и смена пути к ней в профиле БД.
     * Если загрузка осуществилась успешно, плагину DropZone отправляется имя файла в JSON.
     *
     * @property string $fileName   параметр, в котором находится файл.
     * @property string $uploadPath путь к файлу, соответствующий алиасу.
     * @return string закодированная JSON строка файла.
     * @throws Exception если сохранение пошло не так.
     */
    public function actionUpload()
    {
        $fileParam  = 'avatar';
        $uploadPath = Yii::getAlias('@backend/web/images/avatars/storage/');

        if (Yii::$app->request->isPost) {
            $fileName = UploadedFile::getInstanceByName($fileParam);
            $filePath = $uploadPath . $fileName;

            if ($fileName->saveAs($filePath)) {
                if ((new UserProfile())->setAvatar($fileName)) {
                    return Json::encode($fileName);
                } else {
                    throw new Exception('Невозможно сохранить пользовательские данные.');
                }
            }
        }

        return false;
    }

    /**
     * Поиск модели пользователя по его PK.
     * Если модель не найдена, будет сгенерировано исключение.
     *
     * @param integer $id
     *
     * @return модель пользователя
     * @throws NotFoundHttpException если модель не может быть найдена
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрошенная страница не существует');
        }
    }
}
