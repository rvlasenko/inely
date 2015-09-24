<?php

/**
 * This file is part of the Inely project.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author rootkit
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
                        'roles' => [ '@' ]
                    ],
                    [
                        'actions'      => [ 'index' ],
                        'allow'        => false,
                        'roles'        => [ '?' ],
                        'denyCallback' => function () {
                            return $this->redirect([ '/login' ]);
                        }
                    ]
                ]
            ]
        ];
    }

    /**
     * Check user status and then performs the appropriate action
     * @return redirect|\yii\web\Response
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
     * Selecting a character from a list of available characters.
     * @return \yii\web\Response
     * @throws HttpException
     */
    public function actionChar()
    {
        if (Yii::$app->request->post()) {
            if ((new User)->setActive() && (new UserProfile)->setDefChar($_POST[ 'mascot' ][ 0 ])) {
                return $this->goHome();
            } else {
                throw new HttpException(500, 'Unable to save user data');
            }
        } else {
            return $this->goHome();
        }
    }

    /**
     * Uploading own character to the server.
     * If everything is all right set the user as active and return JSON.
     *
     * @property string $fileName
     * @property string $uploadPath
     * @return bool|string
     * @throws HttpException
     */
    public function actionUpload()
    {
        $fileName   = 'mascot_path';
        $uploadPath = Yii::getAlias('@storage/web/source/');

        if (isset($_FILES[ $fileName ]) && Yii::$app->request->isPost) {
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
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
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
