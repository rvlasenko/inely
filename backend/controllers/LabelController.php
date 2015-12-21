<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link   http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace backend\controllers;

use backend\models\TaskLabels;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use yii\web\Response;

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
     * @throws HttpException если принятые атрибуты не прошли валидацию.
     */
    public function actionEdit()
    {
        $request = Yii::$app->request;
        $label   = TaskLabels::findOne($request->post('id'));

        if ($label->load($request->post()) && $label->save()) {
            return $request->post('labelName');
        } else {
            throw new HttpException(500, $label->getErrors());
        }
    }

    /**
     * Создание новой метки.
     * @return array идентификатор и название созданной метки, JSON.
     * @throws HttpException при неудачном сохранении.
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $label   = new TaskLabels();

        if ($label->load($request->post()) && $label->save()) {
            return [
                'name' => $request->post('labelName'),
                'id'   => $label->getPrimaryKey()
            ];
        } else {
            throw new HttpException(500, $label->getErrors());
        }
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