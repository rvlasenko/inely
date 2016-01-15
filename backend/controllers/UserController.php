<?php

/**
 * Этот контроллер является частью проекта Inely.
 *
 * @link    http://github.com/hirootkit/inely
 * @licence http://github.com/hirootkit/inely/blob/master/LICENSE.md GPL
 * @author  hirootkit <admiralexo@gmail.com>
 */

namespace backend\controllers;

use backend\models\UserForm;
use common\models\User;
use Yii;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
     * @return string
     * @throws Exception
     */
    public function actionProfile()
    {
        $userProfile  = Yii::$app->user->identity->userProfile;
        $userModel    = new UserForm();
        $userIdentity = Yii::$app->user->identity;

        $userModel->email = $userIdentity->email;

        if ($userProfile->load(Yii::$app->request->post()) && !$userProfile->save()) {
            throw new Exception('Ошибка при изменении имени пользователя.');
        }

        return $this->renderAjax('index', [
            'userProfile' => $userProfile,
            'userModel'   => $userModel
        ]);
    }

    /**
     * @throws Exception
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
