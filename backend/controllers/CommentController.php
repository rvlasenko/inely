<?php

/**
 * Этот контроллер является частью проекта Inely.
 *
 * @link    http://github.com/hirootkit/inely
 * @licence http://github.com/hirootkit/inely/blob/master/LICENSE.md GPL
 * @author  hirootkit <admiralexo@gmail.com>
 */

namespace backend\controllers;

use backend\models\TaskComments;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class CommentController
 * @package backend\controllers
 */
class CommentController extends Controller
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
                        'allow' => false,
                        'roles' => ['?']
                    ]
                ]
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'get-comments' => ['get'],
                    'set-comment'  => ['post']
                ]
            ],
            [
                'class'   => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ]
            ]
        ];
    }

    /**
     * Формирование комментариев задачи со свойствами в будущий объект и передача инициатору.
     * Инциатором запроса является callback $.magnificPopup.open в обработчике [[handleOpenSettings()]].
     *
     * @param integer $taskId ID задачи, для которой требуется сформировать комментарии.
     *
     * @return array|null JSON объект с комментариями пользователей.
     */
    public function actionGetComments($taskId)
    {
        if (Yii::$app->request->isAjax) {
            $model = new TaskComments();

            return $model->getComments($taskId);
        }

        return $this->goHome();
    }

    /**
     * Запись комментария к необходимой задаче в базу данных, и передача инициатору запроса.
     * @return array объект с текущим комментарием.
     * @throws Exception если принятые атрибуты не прошли валидацию.
     */
    public function actionSetComment()
    {
        $model = new TaskComments();

        return $model->setComment(Yii::$app->request->post());
    }
}
