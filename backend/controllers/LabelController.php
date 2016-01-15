<?php

/**
 * Этот контроллер является частью проекта Inely.
 *
 * @link    http://github.com/hirootkit/inely
 * @licence http://github.com/hirootkit/inely/blob/master/LICENSE.md GPL
 * @author  hirootkit <admiralexo@gmail.com>
 */

namespace backend\controllers;

use backend\models\TaskLabels;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * Class LabelController
 * @package backend\controllers
 */
class LabelController extends TaskController
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
                    'create' => ['post'],
                    'delete' => ['post'],
                    'edit'   => ['post'],
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
     * Валидация принятых атрибутов и добавление их значений в соответствующие поля базы данных.
     * В случае несоответствия формату, поле игнорируется и выбрасывается исключение.
     * @return bool если редактирование завершилось успешно.
     * @throws Exception если принятые атрибуты не прошли валидацию.
     */
    public function actionEdit()
    {
        $request   = Yii::$app->request;
        $taskLabel = TaskLabels::findOne($request->post('id'));

        if ($taskLabel->load($request->post()) && !$taskLabel->save()) {
            throw new Exception('Получены данные, отличные от необходимого формата');
        }

        return $request->post('labelName');
    }

    /**
     * Создание новой метки.
     * @return array идентификатор и название созданной метки, JSON.
     * @throws Exception если принятые атрибуты не прошли валидацию.
     */
    public function actionCreate()
    {
        $request   = Yii::$app->request;
        $taskLabel = new TaskLabels();

        if ($taskLabel->load($request->post()) && !$taskLabel->save()) {
            throw new Exception('Получены данные, отличные от необходимого формата');
        }

        return [
            'name' => $request->post('labelName'),
            'id'   => $taskLabel->getPrimaryKey()
        ];
    }

    /**
     * Удаление существующей метки.
     * @return bool значение, если удаление записи всё-таки произошло.
     * @throws NotFoundHttpException если пользователь захотел удалить несуществующую метку.
     */
    public function actionDelete()
    {
        if (TaskLabels::findOne(Yii::$app->request->post('id'))->delete()) {
            return true;
        }

        return null;
    }
}