<?php

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
                        'roles' => [ '@' ]
                    ],
                    [
                        'actions' => [ 'index' ],
                        'allow' => false,
                        'roles' => [ '?' ],
                        'denyCallback' => function () {
                            return $this->redirect([ '/login' ]);
                        }
                    ]
                ]
            ]
        ];
    }

    public function actions()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => [ 'index', 'char' ],
                'duration' => 84600
            ],
            'error' => [ 'class' => 'yii\web\ErrorAction' ]
        ];
    }

    /**
     * Check user status and then performs the appropriate action
     * @return string|\yii\web\Response
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
                'i18n' => Yii::t('backend', 'Are you sure?')
            ]);
        }
    }

    /**
     *
     * @return \yii\web\Response
     * @throws HttpException
     */
    public function actionChar()
    {
        if (Yii::$app->request->post()) {
            $userProfile = $this->findModel(Yii::$app->user->id, UserProfile::className());
            $user        = $this->findModel(Yii::$app->user->id, User::className());

            $user->status               = User::STATUS_ACTIVE;
            $userProfile->def_char_name = $_POST[ 'mascot' ][ 0 ];

            if ($userProfile->save() && $user->save()) {
                return $this->goHome();
            } else {
                throw new HttpException(500, 'Unable to save user data');
            }
        } else {
            return $this->goHome();
        }
    }

    /**
     * Action for uploading a custom character to the server
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

                // Search current user and updating his character
                $userProfile = $this->findModel(Yii::$app->user->id, UserProfile::className());
                $user        = $this->findModel(Yii::$app->user->id, User::className());

                $user->status                = User::STATUS_ACTIVE;
                $userProfile->user_char_path = $uploadPath . $file->name;

                // If everything is alright return JSON
                if ($userProfile->save(true) && $user->save(true)) {
                    return Json::encode($file);
                } else {
                    throw new HttpException(500, 'Unable to save user data');
                }
            }
        }
        else {
            return $this->goHome();
        }
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $class)
    {
        if (($model = $class::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
