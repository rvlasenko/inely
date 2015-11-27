<?php
/**
 * @link      https://github.com/creocoder/yii2-nested-sets
 * @copyright Copyright (c) 2015 Alexander Kochetov
 * @license   http://opensource.org/licenses/BSD-3-Clause
 */

namespace common\components\nested;

use backend\models\Task;
use yii\base\Behavior;
use yii\db\Expression;

/**
 * NestedSetsQueryBehavior
 *
 * @property \yii\db\ActiveQuery $owner
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 */
class NestedSetQueryBehavior extends Behavior
{
    /**
     * Gets the root nodes.
     *
     * @param $author
     *
     * @param $listId
     *
     * @return \yii\db\ActiveQuery the owner
     */
    public function roots($author, $listId)
    {
        $model     = new $this->owner->modelClass();
        $listId = $listId === '' ? null : $listId;

        $this->owner->joinWith(Task::tableName())
                    ->andWhere([$model->leftAttribute => 1])
                    ->andWhere(['tasks.ownerId' => $author])
                    ->orWhere(['tasks.assignedTo' => $author])
                    ->andWhere(['tasks.listId' => $listId])
                    ->addOrderBy([$model->primaryKey()[0] => SORT_ASC]);

        return $this->owner;
    }

    /**
     * Gets the root id by list id.
     *
     * @param $author
     *
     * @param $listId
     *
     * @return \yii\db\ActiveQuery the owner
     */
    public function rootId($author, $listId)
    {
        $model     = new $this->owner->modelClass();
        $listId = $listId === '' ? null : $listId;

        $this->owner->joinWith(Task::tableName())
                    ->andWhere([$model->leftAttribute => 1])
                    ->andWhere(['tasks.ownerId' => $author])
                    ->orWhere(['tasks.assignedTo' => $author])
                    ->andWhere(['tasks.listId' => $listId])
                    ->addOrderBy([$model->primaryKey()[0] => SORT_ASC]);

        $root = $this->owner->all();
        return $root[0]['dataId'];
    }

    /**
     * Gets the leaf nodes.
     * @return \yii\db\ActiveQuery the owner
     */
    public function leaves()
    {
        $model = new $this->owner->modelClass();
        $db    = $model->getDb();

        $columns = [$model->leftAttribute => SORT_ASC];

        if ($model->treeAttribute !== false) {
            $columns = [$model->treeAttribute => SORT_ASC] + $columns;
        }

        $this->owner->andWhere([$model->rightAttribute => new Expression($db->quoteColumnName($model->leftAttribute) . '+ 1')])
                    ->addOrderBy($columns);

        return $this->owner;
    }
}