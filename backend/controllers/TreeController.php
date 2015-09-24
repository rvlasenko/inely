<?php

/**
 * This file is part of the Inely project.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author rootkit
 */

namespace backend\controllers;

use backend\models\Task;
use backend\models\TaskForm;
use backend\models\TasksData;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class TreeController extends Controller
{
    /**
     * Which field from the data table maps to the structure table.
     * @var array
     */
    protected $options = [
        'structure' => [
            'id'        => 'dataId',
            'left'      => 'lft',
            'right'     => 'rgt',
            'level'     => 'lvl',
            'parent_id' => 'pid',
            'position'  => 'pos'
        ]
    ];

    /**
     * Executes query and returns a single node of result.
     *
     * @param       $id
     * @param array $options
     *
     * @return ActiveRecord the newly created instance
     */
    protected function getNode($id, $options = [ ])
    {
        $node = TasksData::find()->where([ 'dataId' => $id ])->asArray()->one();

        if (isset($options[ 'withChildren' ])) {
            $node[ 'children' ] = $this->getChildren($id, isset($options[ 'deepChildren' ]));
        }

        if (isset($options[ 'withPath' ])) {
            $node[ 'path' ] = $this->getPath($id);
        }

        return $node;
    }

    /**
     * Executes query and returns all results as an array.
     * @param      $id
     * @param bool $recursive
     *
     * @return array|null|\yii\db\ActiveRecord[]
     */
    protected function getChildren($id, $recursive = false)
    {
        $query = null;
        if ($recursive) {
            $node  = $this->getNode($id);
            $query = TasksData::find()
                              ->where([ '>', 'lft', $node[ 'lft' ] ])
                              ->andWhere([ '<', 'rgt', $node[ 'rgt' ] ])
                              ->orderBy('lft')
                              ->asArray()
                              ->all();
        } else {
            $query = TasksData::find()
                              ->joinWith('tasks')
                              ->where([ 'pid' => $id, 'tasks.author' => Yii::$app->user->id ])
                              ->andWhere([ 'tasks.isDone' => 0 ])
                              ->orderBy('pos')
                              ->asArray()
                              ->all();
        }

        return $query;
    }

    /**
     * Executes query by condition "path" and returns all ordered nodes.
     *
     * @param $id
     *
     * @return array|bool|\yii\db\ActiveRecord[]
     * @throws \Exception
     */
    protected function getPath($id)
    {
        $node  = $this->getNode($id);
        $query = false;
        if ($node) {
            $query = TasksData::find()
                              ->where([ '<', 'lft', $node[ 'lft' ] ])
                              ->andWhere([ '>', 'rgt', $node[ 'rgt' ] ])
                              ->orderBy('lft')
                              ->asArray()
                              ->all();
        }

        return $query;
    }

    /**
     * Creates a new node with the default attributes.
     *
     * @param       $data - attributes
     *
     * @return node ID
     *
     * @param       $parent
     * @param int   $position
     * @param array $data
     *
     * @throws HttpException if unable to save data
     * @throws \Exception
     * @throws \yii\db\Exception if couldn't rename after create
     */
    protected function make($parent, $position = 0, $data = [ ])
    {
        if ($parent == 0) {
            throw new \Exception('Parent is 0');
        }
        $parent = $this->getNode($parent, [ 'withChildren' => true ]);
        if (!$parent[ 'children' ]) {
            $position = 0;
        }
        if ($parent[ 'children' ] && $position >= count($parent[ 'children' ])) {
            $position = count($parent[ 'children' ]);
        }

        /* PREPARE NEW PARENT */
        // update positions of all next elements
        $db = Yii::$app->db;
        $db->createCommand('UPDATE tasks_data SET pos = pos + 1 WHERE pid = :pid AND pos >= :pos')
           ->bindValue(':pid', (int)$parent[ 'dataId' ])
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

        /* INSERT NEW NODE IN STRUCTURE */
        $tmp = [ ];
        foreach ($this->options[ 'structure' ] as $k => $v) {
            switch ($k) {
                case 'id':
                    $tmp[ $v ] = null;
                    break;
                case 'left':
                    $tmp[ $v ] = (int)$refLft;
                    break;
                case 'right':
                    $tmp[ $v ] = (int)$refLft + 1;
                    break;
                case 'level':
                    $tmp[ $v ] = (int)$parent[ $v ] + 1;
                    break;
                case 'parent_id':
                    $tmp[ $v ] = $parent[ 'dataId' ];
                    break;
                case 'position':
                    $tmp[ $v ] = $position;
                    break;
                default:
                    $tmp[ ] = null;
            }
        }
        $data = array_merge($data, $tmp);

        if ($node = (new TaskForm)->make($data)) {
            if ($data && count($data)) {
                if (!$this->rename($node, $data)) {
                    $this->remove($node);

                    throw new \Exception('Could not rename after create');
                }
            } else {
                throw new HttpException(500, 'Unable to save user data');
            }
        }

        return $node;
    }

    /**
     * Renames the node by its unique ID
     *
     * @param $id   - the PK of the field which you want to rename
     * @param $data - array which contains the name of a field
     *
     * @return bool
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    protected function rename($id, $data)
    {
        if (!TasksData::findOne([ 'dataId' => $id ])) {
            throw new \Exception('Could not rename non-existing node');
        }

        if (count($data)) {
            $db = Yii::$app->db;
            $db->createCommand()->update('tasks_data', [ 'name' => $data[ 'name' ] ], "dataId = $id")->execute();
        }

        return true;
    }

    /**
     * @param     $id
     * @param int $parent
     * @param int $position
     *
     * @return bool
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    protected function move($id, $parent = 0, $position = 0)
    {
        $id     = (int)$id;
        $parent = (int)$parent;
        //        if($parent == 0 || $id == 0 || $id == 1) {
        //            throw new Exception('Cannot move inside 0, or move root node');
        //        }

        $parent = $this->getNode($parent, [ 'withChildren' => true, 'withPath' => true ]);
        $id     = $this->getNode($id, [ 'withChildren' => true, 'deepChildren' => true, 'withPath' => true ]);

        if (!$parent[ 'children' ]) {
            $position = 0;
        }
        if ($id[ 'pid' ] == $parent[ 'dataId' ] && $position > $id[ 'pos' ]) {
            $position++;
        }
        if ($parent[ 'children' ] && $position >= count($parent[ 'children' ])) {
            $position = count($parent[ 'children' ]);
        }
        if ($id[ 'lft' ] < $parent[ 'lft' ] && $id[ 'rgt' ] > $parent[ 'rgt' ]) {
            throw new \Exception('Could not move parent inside child');
        }

        $tmp    = [ ];
        $tmp[ ] = (int)$id[ 'dataId' ];
        if ($id[ 'children' ] && is_array($id[ 'children' ])) {
            foreach ($id[ 'children' ] as $c) {
                $tmp[ ] = (int)$c[ 'dataId' ];
            }
        }

        $width = $id[ 'rgt' ] - $id[ 'lft' ] + 1;

        /* PREPARE NEW PARENT */
        // update positions of all next elements
        $db = Yii::$app->db;
        $db->createCommand('UPDATE tasks_data SET pos = pos + 1 WHERE dataId != :dataId AND pid = :pid AND pos >= :pos')
           ->bindValue(':dataId', (int)$id[ 'dataId' ])
           ->bindValue(':pid', (int)$parent[ 'dataId' ])
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

        /* MOVE THE ELEMENT AND CHILDREN */
        // left, right and level
        $diff = $refLft - (int)$id[ 'lft' ];

        if ($diff > 0) {
            $diff = $diff - $width;
        }
        $ldiff = ((int)$parent[ 'lvl' ] + 1) - (int)$id[ 'lvl' ];
        $db->createCommand('UPDATE tasks_data SET rgt = rgt + :diff, lft = lft + :diff, lvl = lvl + :ldiff WHERE dataId IN(:dataId)')
           ->bindValue(':diff', $diff)
           ->bindValue(':ldiff', $ldiff)
           ->bindValue(':dataId', (int)implode(',', $tmp))
           ->execute();

        // position and parent_id
        $db->createCommand('UPDATE tasks_data SET pos = :pos, pid = :pid WHERE dataId = :id')
           ->bindValue(':pos', $position)
           ->bindValue(':pid', (int)$parent[ 'dataId' ])
           ->bindValue(':id', (int)$id[ 'dataId' ])
           ->execute();

        /* CLEAN OLD PARENT */
        // position of all next elements
        $db->createCommand('UPDATE tasks_data SET pos = pos - 1 WHERE pid = :pid AND pos > :pos')
           ->bindValue(':pid', (int)$id[ 'pid' ])
           ->bindValue(':pos', (int)$id[ 'pos' ])
           ->execute();

        // left indexes
        $db->createCommand('UPDATE tasks_data SET lft = lft - :width WHERE lft > :rgt AND dataId NOT IN(:id)')
           ->bindValue(':width', $width)
           ->bindValue(':rgt', $id[ 'rgt' ])
           ->bindValue(':id', (int)implode(',', $tmp))
           ->execute();

        // right indexes
        $db->createCommand('UPDATE tasks_data SET rgt = rgt - :width WHERE rgt > :rgt AND dataId NOT IN(:id)')
           ->bindValue(':width', $width)
           ->bindValue(':rgt', $id[ 'rgt' ])
           ->bindValue(':id', (int)implode(',', $tmp))
           ->execute();

        return true;
    }

    /**
     * Finds the nodes based on its primary key value.
     * Deleting node and its children from structure.
     *
     * @param $id
     *
     * @return bool
     * @throws NotFoundHttpException
     */
    protected function remove($id)
    {
        if (!Task::findOne([ $id ])) {
            throw new NotFoundHttpException('Could not delete non-existing node');
        }

        $tmp  = [ ];
        $db   = Yii::$app->db;
        $data = $this->getNode($id, [ 'withChildren' => true, 'deepChildren' => true ]);
        $db->createCommand('DELETE FROM tasks_data WHERE lft >= :lft AND rgt <= :rgt')
           ->bindValue(':lft', $data[ 'lft' ])
           ->bindValue(':rgt', $data[ 'rgt' ])
           ->execute();

        $tmp[ ] = $data[ 'dataId' ];
        if ($data[ 'children' ] && is_array($data[ 'children' ])) {
            foreach ($data[ 'children' ] as $v) {
                $tmp[ ] = $v[ 'dataId' ];
            }
        }
        $db->createCommand('DELETE FROM tasks_data WHERE dataId IN (:dataId)')
           ->bindValue(':dataId', (int)implode(',', $tmp))
           ->execute();
        $db->createCommand('DELETE FROM tasks WHERE id IN (:id)')
            ->bindValue(':id', (int)implode(',', $tmp))
            ->execute();

        return true;
    }

    /**
     * @param $parent
     * @param $position
     *
     * @return key
     */
    protected function updateRightIndexes($parent, $position)
    {
        if (!$parent[ 'children' ]) {
            $refRgt = $parent[ 'rgt' ];
        } else {
            if (!isset($parent[ 'children' ][ $position ])) {
                $refRgt = $parent[ 'rgt' ];
            } else {
                $refRgt = $parent[ 'children' ][ (int)$position ][ 'lft' ] + 1;
            }
        }

        return $refRgt;
    }

    /**
     * @param $parent
     * @param $position
     *
     * @return key
     */
    protected function updateLeftIndexes($parent, $position)
    {
        if (!$parent[ 'children' ]) {
            $refLft = $parent[ 'rgt' ];
        } else {
            if (!isset($parent[ 'children' ][ $position ])) {
                $refLft = $parent[ 'rgt' ];
            } else {
                $refLft = $parent[ 'children' ][ (int)$position ][ 'lft' ];
            }
        }

        return $refLft;
    }

    /**
     * @param $param
     *
     * @return mixed
     * @throws InvalidConfigException
     */
    protected function purifyGetRequest($param)
    {
        if (isset($_GET[ $param ]) && $_GET[ $param ] !== '#') {
            return $_GET[ $param ];
        }

        return false;
    }
}
