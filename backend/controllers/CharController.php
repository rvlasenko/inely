<?php

namespace backend\controllers;

use common\models\User;
use common\models\UserProfile;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\UploadedFile;

class CharController extends Controller
{

    /**
     * Активизация кэширования страниц продолжительностью один день, установка локали
     */
    public function actions()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => [ 'index' ],
                'duration' => 84600
            ],
            'error' => [ 'class' => 'yii\web\ErrorAction' ]
        ];
    }

    /**
     *
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        $this->layout = 'welcome';
        $model = new UserProfile();

        if (Yii::$app->user->identity->status == User::STATUS_ACTIVE) {
            return $this->goHome();
        } else {
            return $this->render('index', [ 'model' => $model ]);
        }
    }

    public function actionChar()
    {
        $this->layout = 'welcome';

        $model = new UserProfile();

        if ($model->load(Yii::$app->request->post())) {
            return $this->goHome();
        } else {
            if (Yii::$app->request->isAjax) {
                return $this->renderAjax('char', [ 'model' => $model ]);
            } else {
                return $this->goHome();
            }
        }
    }

    /**
     * Метод загрузки пользовательского персонажа на сервер.
     * @property string $fileName
     * @property string $uploadPath
     * @return bool|string
     * @throws HttpException
     */
    public function actionUpload()
    {
        $fileName   = 'mascot_path';
        $uploadPath = Yii::getAlias('images/mascots/user/');

        if (isset($_FILES[ $fileName ]) && Yii::$app->request->isPost) {
            $file = UploadedFile::getInstanceByName($fileName);

            if ($file->saveAs($uploadPath . $file->name)) {

                // Поиск текущего юзера и обновление его полей
                $userProfile = UserProfile::findOne([ 'user_id' => Yii::$app->user->id ]);
                $user = User::findOne([ 'id' => Yii::$app->user->id ]);
                $user->status = User::STATUS_ACTIVE;
                $userProfile->mascot_path = $uploadPath . $file->name;

                // Если всё хорошо, вернуть JSON
                if ($userProfile->save(true) && $user->save(true)) {
                    return Json::encode($file);
                } else {
                    throw new HttpException(500, 'Unable to save user data');
                }
            }
        } else {
            return $this->goHome();
        }
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
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
