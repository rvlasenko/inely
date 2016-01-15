<?php

namespace backend\models\query;

use common\components\nested\NestedSetQueryBehavior;
use yii\db\ActiveQuery;

class TaskQuery extends ActiveQuery
{
    public function behaviors()
    {
        return [NestedSetQueryBehavior::className()];
    }
}