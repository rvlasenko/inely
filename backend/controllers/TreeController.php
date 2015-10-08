<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace backend\controllers;

use backend\models\Task;
use backend\models\TaskForm;
use backend\models\TasksData;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class TreeController extends Controller
{
    /**
     * @var array Массив, указывающий, какое значение какому полю соответствует в базе.
     */
    protected $options = [
        'structure' => [
            'id'       => 'dataId',
            'left'     => 'lft',
            'right'    => 'rgt',
            'level'    => 'lvl',
            'parentId' => 'pid',
            'position' => 'pos'
        ]
    ];

    /**
     * @var array Фиктивный корневой узел.
     * Перед выборкой, jsTree посылает запрос /task/node?id ожидая JSON данные корневого узла
     * Чтобы предотвратить избыточность данных в базе, формируется фиктивный корень вида:
     * ```
     * [{
     *      "id":       1,
     *      "text":     "Root",
     *      "a_attr":   { "class":null },
     *      "data":     { "note":false },
     *      "children": true
     * }]
     * ```
     */
    protected $root = [
        'dataId'   => 1,
        'name'     => 'Root',
        'note'     => null,
        'lft'      => 1,
        'rgt'      => 11,
        'lvl'      => 0,
        'pid'      => 0,
        'pos'      => 1,
        'children' => true,
        'tasks'    => ['priority' => null]
    ];

    /**
     * Создание экземпляра ActiveRecord таблицы "tasks_data".
     * Если у узла существуют дочерние элементы, то они формируются в ключе "children" по вызову [[getChildren()]].
     * Иначе возвращаются только сгруппированные узлы [[getPath()]].
     *
     * @param int   $id      идентификатор узла
     * @param array $options дополнительные параметры
     *
     * @return array|null полученные атрибуты узла.
     */
    public function getNode($id, $options = [])
    {
        $node = TasksData::find()->where(['dataId' => $id])->asArray()->one();

        if (ArrayHelper::getValue($options, 'withChildren')) {
            $node['children'] = $this->getChildren($id, ArrayHelper::getValue($options, 'deepChildren'));
        }

        if (ArrayHelper::getValue($options, 'withPath')) {
            $node['path'] = $this->getPath($id);
        }

        return $node;
    }

    /**
     * Создание экземпляра ActiveRecord и получение всех дочерних элементов требуемого узла.
     * Первичное обращение к методу выполняется из Task контроллера действием [[actionNode()]].
     *
     * @param int  $id        идентификатор узла
     * @param bool $recursive параметр задающий рекурсию
     * @param int  $list      категория по которой будет произведена выборка
     *
     * @return array|ActiveRecord[] результат запроса.
     * Если результат равен null, то будет возвращен пустой массив.
     */
    public function getChildren($id, $recursive = false, $list = null)
    {
        $query[] = $this->root;
        $cond    = ['pid' => $id, 'tasks.author' => Yii::$app->user->id, 'tasks.isDone' => 0];
        if ($recursive) {
            // Рекурсивная проверка на наличие вложенных задач
            $node  = $this->getNode($id);
            $query = TasksData::find()
                              ->where(['>', 'lft', $node['lft']])
                              ->andWhere(['<', 'rgt', $node['rgt']])
                              ->orderBy('lft')->asArray()->all();
        } elseif (!is_null($list)) {
            if ($id) {
                // Если $list равен null, то искать все задачи независимо от категории
                // Иначе требуются задачи с категорией, которая пришла в $list
                $query = TasksData::find()
                                  ->joinWith('tasks')
                                  ->where($cond)
                                  ->andWhere(['tasks.list' => $list])
                                  ->orderBy('pos')->asArray()->all();
            }
        } else {
            // Выборка всех задач в Inbox, которым не назначен список
            if ($id) {
                $query = TasksData::find()
                                  ->joinWith('tasks')
                                  ->where($cond)
                                  ->andWhere(['tasks.list' => null])
                                  ->orderBy('pos')->asArray()->all();
            }
        }

        return $query;
    }

    /**
     * Создание экземпляра ActiveRecord и получение всех сгруппированных элементов.
     *
     * @param int $id идентификатор узла.
     *
     * @return array|ActiveRecord[] результат запроса.
     * Если результат равен null, то будет возвращен пустой массив.
     */
    public function getPath($id)
    {
        $node  = $this->getNode($id);
        $query = false;
        if ($node) {
            $query = TasksData::find()
                              ->where(['<', 'lft', $node['lft']])
                              ->andWhere(['>', 'rgt', $node['rgt']])
                              ->orderBy('lft')->asArray()->all();
        }

        return $query;
    }

    /**
     * Выполнение SQL запросов по вставке нового узла и обновления позиции существующих.
     *
     * @param int   $parent   родительский элемент, куда был создан данный узел.
     * @param int   $position позиция узла, куда он был впоследствии перемещен.
     * @param array $data     некоторые кастомные атрибуты.
     *
     * @throws HttpException если невозможно создать узел.
     * @throws \Exception если не определен родитель.
     * @throws \yii\db\Exception если невозможно переименовать после создания.
     * @return id только что созданного узла.
     */
    public function make($parent, $position = 0, $data = [])
    {
        $cond = ['tasks.author' => Yii::$app->user->id, 'pid' => 1];
        if ($parent == 0) { throw new \Exception('Parent is 0'); }
        if ($parent == 1) {
            $parent = $this->root;
            $parent['children'] = TasksData::find()->joinWith('tasks')->where($cond)->asArray()->all();
        } else {
            $parent = $this->getNode($parent, ['withChildren' => true, 'withPath' => true]);
        }

        if (!$parent['children']) { $position = 0; }
        if ($parent['children'] && $position >= count($parent['children'])) {
            $position = count($parent['children']);
        }

        /* Подготовка нового родительского элемента */
        // Обновление позиции всех следующих элементов.
        $db = Yii::$app->db;
        $db->createCommand('UPDATE tasks_data SET pos = pos + 1 WHERE pid = :pid AND pos >= :pos')
           ->bindValue(':pid', (int)$parent['dataId'])
           ->bindValue(':pos', $position)
           ->execute();

        $refLft = $this->updateLeftIndexes($parent, $position);
        $refRgt = $this->updateRightIndexes($parent, $position);

        $db->createCommand('UPDATE tasks_data SET lft = lft + 2 WHERE lft >= :lft')
           ->bindValue(':lft', (int)$refLft)
           ->execute();

        $db->createCommand('UPDATE tasks_data SET rgt = rgt + 2 WHERE rgt >= :rgt')
           ->bindValue(':rgt', (int)$refRgt)
           ->execute();

        /* Вставка нового узла в структуру */
        $tmp = [];
        foreach ($this->options['structure'] as $k => $v) {
            switch ($k) {
                case 'id':
                    $tmp[$v] = null;
                    break;
                case 'left':
                    $tmp[$v] = $refLft;
                    break;
                case 'right':
                    $tmp[$v] = $refLft + 1;
                    break;
                case 'level':
                    $tmp[$v] = $parent[$v] + 1;
                    break;
                case 'parentId':
                    $tmp[$v] = $parent['dataId'];
                    break;
                case 'position':
                    $tmp[$v] = $position;
                    break;
                default:
                    $tmp[] = null;
            }
        }
        $data = array_merge($data, $tmp);

        if ($node = (new TaskForm)->make($data)) {
            return $node;
        } else {
            throw new HttpException(500, 'Unable to save user data');
        }
    }

    /**
     * Выполнение SQL запросов для переименования данного узла.
     *
     * @param int   $id   идентификатор узла, который был переименован.
     * @param array $data некоторые атрибуты, например, новое имя.
     *
     * @return bool если сохранение завершено.
     * @throws \Exception если невозможно переименовать несуществующий узел.
     */
    public function rename($id, $data)
    {
        if (TasksData::findOne(['dataId' => $id, 'name' => 'Root'])) {
            throw new AccessDeniedException('Could not rename root node');
        }

        if (ArrayHelper::keyExists('name', $data)) {
            $taskData = TasksData::findOne(['dataId' => $id]);
            $taskData->name = $data['name'];
            $taskData->save();
        }

        return true;
    }

    /**
     * Выполнение SQL запросов для перемещения узла в указанную позицию некоего родителя.
     *
     * @param int $id       идентификатор узла, который был перемещен
     * @param int $parent   родительский элемент, куда был перемещен данный узел.
     * @param int $position позиция узла, куда он был впоследствии перемещен.
     *
     * @return bool если сохранение завершено.
     * @throws \Exception если невозможно по каким-то причинам переместить узел.
     * @throws InvalidConfigException если пользователь захотел переместить узел за пределы корня.
     */
    public function move($id, $parent = 0, $position = 0)
    {
        $cond = ['tasks.author' => Yii::$app->user->id, 'pid' => 1];
        if ($parent == 0 || $id == 0 || $id == 1) {
            throw new InvalidConfigException('Cannot move inside 0, or move root node');
        }

        if ($parent == 1) {
            $parent = $this->root;
            $parent['children'] = TasksData::find()->joinWith('tasks')->where($cond)->asArray()->all();
        } else {
            $parent = $this->getNode($parent, ['withChildren' => true, 'withPath' => true]);
        }
        $id = $this->getNode($id, ['withChildren' => true, 'deepChildren' => true, 'withPath' => true]);

        if (!$parent['children']) {
            $position = 0;
        }
        if ($id['pid'] == $parent['dataId'] && $position > $id['pos']) {
            $position++;
        }
        if ($parent['children'] && $position >= count($parent['children'])) {
            $position = count($parent['children']);
        }
        if ($id['lft'] < $parent['lft'] && $id['rgt'] > $parent['rgt']) {
            throw new \Exception('Could not move parent inside child');
        }

        $tmp   = [];
        $width = $id['rgt'] - $id['lft'] + 1;
        $tmp[] = $id['dataId'];

        if ($id['children'] && is_array($id['children'])) {
            foreach ($id['children'] as $c) {
                $tmp[] = (int)$c['dataId'];
            }
        }

        /* Подготовка нового родительского элемента */
        // Обновление позиции всех следующих элементов.
        $db = Yii::$app->db;
        $db->createCommand('UPDATE tasks_data SET pos = pos + 1 WHERE dataId != :dataId AND pid = :pid AND pos >= :pos')
           ->bindValue(':dataId', (int)$id['dataId'])
           ->bindValue(':pid', (int)$parent['dataId'])
           ->bindValue(':pos', $position)
           ->execute();

        $refLft = $this->updateLeftIndexes($parent, $position);
        $refRgt = $this->updateRightIndexes($parent, $position);

        $db->createCommand('UPDATE tasks_data SET lft = lft + :width WHERE lft >= :lft AND dataId NOT IN (:dataId)')
           ->bindValue(':width', $width)
           ->bindValue(':lft', (int)$refLft)
           ->bindValue(':dataId', (int)implode(',', $tmp))
           ->execute();

        $db->createCommand('UPDATE tasks_data SET rgt = rgt + :width WHERE rgt >= :rgt AND dataId NOT IN (:dataId)')
           ->bindValue(':width', $width)
           ->bindValue(':rgt', (int)$refRgt)
           ->bindValue(':dataId', (int)implode(',', $tmp))
           ->execute();

        /* Перемещение узла и его дочерних элементов */
        // правый, левый атрибуты и уровень вложенности
        $diff = $refLft - (int)$id['lft'];

        if ($diff > 0) {
            $diff = $diff - $width;
        }
        $leftDiff = ((int)$parent['lvl'] + 1) - (int)$id['lvl'];
        $db->createCommand('UPDATE tasks_data SET rgt = rgt + :diff, lft = lft + :diff, lvl = lvl + :ldiff WHERE dataId IN(:dataId)')
           ->bindValue(':diff', $diff)
           ->bindValue(':ldiff', $leftDiff)
           ->bindValue(':dataId', (int)implode(',', $tmp))
           ->execute();

        // позиция и id родителя
        $db->createCommand('UPDATE tasks_data SET pos = :pos, pid = :pid WHERE dataId = :id')
           ->bindValue(':pos', $position)
           ->bindValue(':pid', (int)$parent['dataId'])
           ->bindValue(':id', (int)$id['dataId'])
           ->execute();

        /* Очистка старого родителя */
        // Обновление позиции всех следующих элементов.
        $db->createCommand('UPDATE tasks_data SET pos = pos - 1 WHERE pid = :pid AND pos > :pos')
           ->bindValue(':pid', (int)$id['pid'])
           ->bindValue(':pos', (int)$id['pos'])
           ->execute();

        // А также левых индексов
        $db->createCommand('UPDATE tasks_data SET lft = lft - :width WHERE lft > :rgt AND dataId NOT IN(:id)')
           ->bindValue(':width', $width)
           ->bindValue(':rgt', $id['rgt'])
           ->bindValue(':id', (int)implode(',', $tmp))
           ->execute();

        // И правых индексов
        $db->createCommand('UPDATE tasks_data SET rgt = rgt - :width WHERE rgt > :rgt AND dataId NOT IN(:id)')
           ->bindValue(':width', $width)
           ->bindValue(':rgt', $id['rgt'])
           ->bindValue(':id', (int)implode(',', $tmp))
           ->execute();

        return true;
    }

    /**
     * Выполнение SQL запросов на удаление узла дерева и всех его дочерних элементов.
     *
     * @param int $id идентификатор узла, который был удален.
     *
     * @return bool если удаление завершено.
     * @throws NotFoundHttpException если пользователь передал несуществующий id.
     * @throws AccessDeniedException либо он задумал удалить корень.
     */
    public function remove($id)
    {
        if (!Task::findOne([$id])) {
            throw new NotFoundHttpException('Could not delete non-existing node');
        }
        if (TasksData::findOne(['dataId' => $id, 'name' => 'Root'])) {
            throw new AccessDeniedException('Could not delete root node');
        }

        $db    = Yii::$app->db;
        $data  = $this->getNode($id, ['withChildren' => true, 'deepChildren' => true]);
        $tmp[] = $data['dataId'];

        $db->createCommand()->delete('tasks_data', 'lft >= :lft AND rgt <= :rgt', [
            ':lft' => $data['lft'],
            ':rgt' => $data['rgt']
        ])->execute();

        if ($data['children'] && is_array($data['children'])) {
            foreach ($data['children'] as $v) {
                $tmp[] = $v['dataId'];
            }
        }

        $db->createCommand()->delete('tasks', 'id IN (:id)', [':id' => implode(',', $tmp)])->execute();

        return true;
    }

    /**
     * Обновление структуры правых индексов.
     *
     * @param array $parent   родительский элемент, куда был перемещен данный узел.
     * @param int   $position позиция узла, куда он был впоследствии перемещен.
     *
     * @return int правый ключ
     */
    protected function updateRightIndexes($parent, $position)
    {
        if (!$parent['children']) {
            $refRgt = $parent['rgt'];
        } else {
            if (!isset($parent['children'][$position])) {
                $refRgt = $parent['rgt'];
            } else {
                $refRgt = $parent['children'][(int)$position]['lft'] + 1;
            }
        }

        return $refRgt;
    }

    /**
     * Обновление структуры левых индексов.
     *
     * @param array $parent   родительский элемент, куда был перемещен данный узел.
     * @param int   $position позиция узла, куда он был впоследствии перемещен.
     *
     * @return int левый ключ
     */
    protected function updateLeftIndexes($parent, $position)
    {
        if (!$parent['children']) {
            $refLft = $parent['rgt'];
        } else {
            if (!isset($parent['children'][$position])) {
                $refLft = $parent['rgt'];
            } else {
                $refLft = $parent['children'][(int)$position]['lft'];
            }
        }

        return $refLft;
    }

    /**
     * Метод обрабатывает GET параметр на наличие необходимых значений.
     *
     * @param string $param параметр, который требуется проверить.
     *
     * @return string|bool тот же самый параметр, либо 0, если проверка не пройдена.
     */
    protected static function checkGetParam($param)
    {
        $getRequest = Yii::$app->request->get();

        if (ArrayHelper::keyExists($param, $getRequest) && ArrayHelper::getValue($getRequest, $param) !== '#') {
            return ArrayHelper::getValue($getRequest, $param);
        }

        return false;
    }
}
