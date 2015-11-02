<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link   http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace backend\models\query;

use common\components\nested\NestedSetQueryBehavior;
use yii\db\ActiveQuery;

class TaskQuery extends ActiveQuery
{
    public function behaviors()
    {
        return [
            NestedSetQueryBehavior::className()
        ];
    }
}