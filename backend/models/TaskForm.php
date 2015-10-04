<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace backend\models;

use yii\base\Model;
use Yii;

class TaskForm extends Model
{
    /**
     * Посредник между созданием узла дерева [[make()]] и установкой отношений [[afterCreate()]].
     *
     * @param array    $data левые и правые индексы новой ветки
     *
     * @return int|bool значение первичного ключа только что созданной строки
     */
    public function make($data)
    {
        $user = new Task();
        $user->setAttributes($data, false);

        if ($user->save()) {
            return $user->afterCreate($data);
        }

        return null;
    }
}
