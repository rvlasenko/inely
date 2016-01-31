<?php

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
     * @param $data
     *
     * @return \yii\db\ActiveQuery the owner
     */
    public function roots($data)
    {
        $model  = new $this->owner->modelClass();
        $listID = $data['listID'] === '' ? null : $data['listID'];

        $this->owner->joinWith(Task::tableName())
                    ->andWhere([$model->leftAttribute => 1])
                    ->andWhere(['tasks.ownerId' => $data['author']])
                    ->orWhere(['tasks.sharedWith' => $data['author']])
                    ->andWhere(['tasks.listId' => $listID])
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
                    ->orWhere(['tasks.sharedWith' => $author])
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