<?php

/**
 * Эта модель является частью проекта Inely.
 *
 * @link    http://github.com/hirootkit/inely
 * @licence http://github.com/hirootkit/inely/blob/master/LICENSE.md GPL
 * @author  hirootkit <admiralexo@gmail.com>
 */

namespace backend\models;

use common\components\formatter\FormatterComponent;
use common\models\UserProfile;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * Класс модели для таблицы "task"
 *
 * @property int        $taskId
 * @property int        $listId
 * @property int        $ownerId
 * @property int        $isDone
 * @property string     $priority
 * @property timestamp  $dueDate
 */
class Task extends ActiveRecord
{
    const ACTIVE_TASK     = 0;
    const COMPLETED_TASK  = 1;
    const INCOMPLETE_TASK = 2;
    const PR_HIGH   = 'high';
    const PR_MEDIUM = 'medium';
    const PR_LOW    = 'low';

    public function behaviors()
    {
        return [
            [
                'class'              => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt'
            ]
        ];
    }

    /**
     * Правила валидации для атрибутов.
     * @return array
     */
    public function rules()
    {
        return [
            ['ownerId', 'default', 'value' => Yii::$app->user->id],
            [['listId', 'sharedWith'], 'safe'],
            ['isDone', 'default', 'value' => self::ACTIVE_TASK],
            ['dueDate', 'date', 'format' => 'yyyy-MM-dd'],
            ['isDone', 'in', 'range' => [0, 1, 2]],
            ['priority', 'in', 'range' => [1, 2, 3]],
            ['assignedTo', 'integer']
        ];
    }

    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * Получение количества задач по группам.
     * @return array результаты запроса. Если результатов нет, будет возвращен [].
     */
    public static function getCountOfGroups()
    {
        $cond   = ['ownerId' => Yii::$app->user->id, 'isDone' => self::ACTIVE_TASK];
        $inbox  = ['listId' => null];
        $result = [];

        $result['inbox'] = Task::find()
            ->innerJoin(TaskData::tableName(), 'dataId = taskId')
            ->where($cond)
            ->andWhere($inbox)
            ->count();

        $result['today'] = Task::find()
            ->innerJoin(TaskData::tableName(), 'dataId = taskId')
            ->where($cond)
            ->andWhere((new Expression('DATE(IFNULL(dueDate, createdAt)) = CURDATE()')))
            ->count();

        $result['week'] = Task::find()
            ->innerJoin(TaskData::tableName(), 'dataId = taskId')
            ->where($cond)
            ->andWhere((new Expression('IFNULL(dueDate, createdAt)
                                        BETWEEN CURDATE()
                                        AND DATE_ADD(CURDATE(),
                                        INTERVAL 7 DAY)')))
            ->count();

        $result['assign'] = Task::find()
            ->innerJoin(TaskData::tableName(), 'dataId = taskId')
            ->where(['assignedTo' => Yii::$app->user->id])
            ->count();

        return $result;
    }

    /**
     * Преоразование массива задач в объект вида:
     * [{
     *      "id":   "240",
     *      "text": "Child task",
     *      "a_attr": {
     *          "note":       "<p>Не забыть</p>",
     *          "degree":     "high",
     *          "incomplete": "true",
     *          "lname":      "новая метка",
     *          "assignedId": "26",
     *          "assigned":   "/images/avatars/some.jpg",
     *          "date":  "5 Янв",
     *          "rel":   "future",
     *          "hint":  "осталось 10 дней"
     *      },
     *      "icon":     "entypo-chat",
     *      "children": false
     * }]
     *
     * @param array $node        узел, сформированный в результате запроса
     * @param bool  $showHistory отображение завершенных задач
     *
     * @return array результат преобразования
     * @key int     id       уникальный идентификатор узла
     * @key string  text     строка определяющая имя задачи юзера
     * @key string  note     заметка к задаче как html, при наличии
     * @key string  degree   степень важности как css класс, от которого меняется цвет
     * @key bool    incomplete указывает на зависимость дочерней задачи, когда она выполнена, но всё ещё в списке
     * @key int     assignedId идентификатор юзера, на которого назначена задача
     * @key string  assigned   аватар юзера при делегированной ему задаче
     * @key string  date     дата (+ относительная), подсказки и подчеркивание
     * @key string  icon     при общении в комментариях к задаче стоит иконка
     * @key bool    children наличие дочерних узлов
     * @key bool    data     отображение активных (true) или завершенных (false) задач
     */
    public function buildTree($node, $showHistory = false)
    {
        $result    = [];
        $formatter = new FormatterComponent();

        foreach ($node as $v) {
            $assignedId = $v[Task::tableName()]['assignedTo'];
            $taskLabel  = TaskLabels::findOne(['taskId' => $v['dataId']]);
            $taskComm   = TaskComments::findOne(['taskId' => $v['dataId']]);
            $userAvatar = (new UserProfile())->getAvatar($assignedId);

            // Абсолютная дата выполнения например '6 окт.' или относительная 'через 3 дня'
            $dueDate = $formatter->asRelativeDate($v[Task::tableName()]['dueDate']);
            // Словесная дата степени просроченности, например 'today', 'future'
            $relativeDate = $formatter->timeInWords($v[Task::tableName()]['dueDate']);
            // Относительная дата для тултипа, кол-во оставшихся дней eg. '3 дня осталось'
            $futureDate = $formatter->dateLeft($v[Task::tableName()]['dueDate']);

            // Иконка при наличии комментария у задачи
            $hasComment = $taskComm ? TaskComments::ICON_CLASS : null;

            // Частичное завершение задачи (если она дочерняя)
            $incompletely = ($v[Task::tableName()]['isDone'] == Task::INCOMPLETE_TASK);

            // Если пользователю делегирована задача, ставим его аватарку
            $isAssigned = isset($assignedId) ? $userAvatar : false;

            // Если для задачи установлена некая контекстная метка, отобразить её
            $labelName  = ArrayHelper::getValue($taskLabel, 'labelName', false);
            $labelColor = ArrayHelper::getValue($taskLabel, 'badgeColor', false);

            $result[] = [
                'id'       => $v['dataId'],
                'text'     => $v['name'],
                'a_attr' => [
                    'note'       => $v['note'],
                    'degree'     => $v[Task::tableName()]['priority'],
                    'incomplete' => $incompletely,
                    'lname'      => $labelName,
                    'lcolor'     => $labelColor,
                    'assigned'   => $isAssigned,
                    'assignId'   => $assignedId,
                    'date'       => $dueDate,
                    'rel'        => $relativeDate,
                    'hint'       => $futureDate
                ],
                'icon'     => $hasComment,
                'children' => ($v['rgt'] - $v['lft'] > 1),
                'data'     => $showHistory
            ];
        }

        return $result;
    }

    /**
     * @param $condition
     */
    public function removeCompleted($condition)
    {
        foreach (TaskData::find()
                         ->joinWith(Task::tableName())
                         ->where($condition)
                         ->each() as $task) {
            $task->deleteWithChildren();
        }
    }

    /**
     * Отношение с таблицей "tasks_cat"
     * @return ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'listId']);
    }

    /**
     * Отношение с таблицей "tasks_data"
     * @return ActiveQuery
     */
    public function getTaskData()
    {
        return $this->hasOne(TaskData::className(), ['dataId' => 'taskId']);
    }

    /**
     * Запись данных в модель. Метод перегружен от базового класса Model.
     *
     * @param array|boolean $data     массив данных.
     * @param string        $formName имя формы, использующееся для записи данных в модель.
     *
     * @return boolean если `$data` содержит некие данные, которые связываются с атрибутами модели.
     */
    public function load($data, $formName = '')
    {
        $scope = $formName === null ? $this->formName() : $formName;
        if ($scope === '' && !empty($data)) {
            $this->setAttributes($data);

            return true;
        } elseif (isset($data[$scope])) {
            $this->setAttributes($data[$scope]);

            return true;
        } else {
            return false;
        }
    }
}
