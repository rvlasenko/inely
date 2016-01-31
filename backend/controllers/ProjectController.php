<?php

/**
 * Этот контроллер является частью проекта Inely.
 *
 * @link    http://github.com/hirootkit/inely
 * @licence http://github.com/hirootkit/inely/blob/master/LICENSE.md GPL
 * @author  hirootkit <admiralexo@gmail.com>
 */

namespace backend\controllers;

use backend\models\Project;
use backend\models\TaskData;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class ProjectController
 * @package backend\controllers
 */
class ProjectController extends Controller
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
                    'create'              => ['post'],
                    'delete'              => ['post'],
                    'edit'                => ['post'],
                    'share-with-user'     => ['post'],
                    'remove-collaborator' => ['post'],
                    'get-collaborators'   => ['get'],
                    'get-assigned'        => ['get'],
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
        $request = Yii::$app->request;
        $project = $this->findModel($request->post('id'));

        if ($project->load($request->post()) && !$project->save()) {
            throw new Exception('Переданы данные, несоответствующие формату');
        }

        return $request->post('listName');
    }

    /**
     * Создание нового проекта и его уникального корневого узла.
     * Чтобы добавленные в него задачи имели id корня проекта, а не общий.
     * @method boolean makeRoot() Создает корень, если Active Record объект новый.
     * @return array идентификатор и название созданного проекта, JSON.
     */
    public function actionCreate()
    {
        $model = new Project();

        return $model->createProject(Yii::$app->request->post());
    }

    /**
     * Удаление существующего проекта и его корневого узла.
     * @method ActiveQuery roots(string $author, integer $listId) Получает корневой узел.
     * @return bool значение, если удаление записи всё-таки произошло.
     */
    public function actionDelete()
    {
        $project = $this->findModel(Yii::$app->request->post('id'));
        $root    = TaskData::find()->roots([
            'author' => Yii::$app->user->id,
            'listID' => $project->getPrimaryKey()
        ])->one();

        if ($project->delete() && $root->delete()) {
            return true;
        }

        return null;
    }

    /**
     * Приглашение пользователя к совместной работе над проектом.
     * Такие пользователи, могут добавлять, удалять и завершать задачи из этого списка.
     * @return bool если юзер теперь имеет доступ к проекту.
     */
    public function actionShare()
    {
        $model = new Project();

        return $model->shareWithUser([
            'listID' => Yii::$app->request->post('listId'),
            'email'  => Yii::$app->request->post('email')
        ]);
    }

    /**
     * Исключение пользователя из совместного проекта.
     * @method ActiveQuery rootId(string $author, integer $listId) Получает id корневого списка.
     * @return bool если юзер теперь не имеет доступа к проекту.
     */
    public function actionRemoveCollaborator()
    {
        $model = new Project();

        return $model->removeCollaborator([
            'listID' => Yii::$app->request->post('listId'),
            'userID' => Yii::$app->request->post('userId')
        ]);
    }

    /**
     * Возвращение списка пользователей, которые имеющих доступ к проекту, включая владельца.
     * Он может взаимодействовать с юзерами, добавлять и удалять их. (Пока не более двух)
     *
     * @param integer $listId ID проекта (списка), по которому группируются требуемые задачи.
     *
     * @return array|null объект участников в списке.
     */
    public function actionGetCollaborators($listId = null)
    {
        if (Yii::$app->request->isAjax && $listId !== null) {
            $model = new Project();

            return $model->getCollaborators($listId);
        }

        return null;
    }

    /**
     * Возвращение списка пользователей, имеющих доступ к проекту, включая владельца.
     * Первым элементом в списке пользователей, которых можно назначить на задачу, следует "отключающий".
     *
     * @param integer $listId ID проекта (списка), по которому группируются требуемые задачи.
     *
     * @return array объект участников в списке.
     */
    public function actionGetAssigned($listId = null)
    {
        if (Yii::$app->request->isAjax && $listId !== null) {
            $model = new Project();

            return $model->getAssignedUsers($listId);
        }
    }

    /**
     * Поиск модели пользователя по его PK.
     * Если модель не найдена, будет сгенерировано исключение.
     *
     * @param integer $id
     *
     * @return null|static модель пользователя
     * @throws NotFoundHttpException если модель не может быть найдена
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запрошенная страница не существует');
        }
    }
}
