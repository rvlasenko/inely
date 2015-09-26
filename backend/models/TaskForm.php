<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * (c) Inely <http://github.com/hirootkit/inely>
 *
 * @author hirootkit
 */

namespace backend\models;

use yii\base\Model;
use Yii;

class TaskForm extends Model
{
    /**
     * Посредник между созданием узла дерева [[make()]] и установкой отношений [[afterCreate()]].
     *
     * @param array    $data индексы новой ветки
     * @param int|bool $id   id нового пользователя, для задания ему первичной задачи
     *
     * @return int|bool значение первичного ключа только что созданной строки.
     */
    public function make($data, $id = false)
    {
        $user = new Task();

        if ($id) {
            $user->author = $id;
            $user->save();

            return $user->afterCreate($data);
        } else {
            if ($user->save()) {
                return $user->afterCreate($data);
            }
        }

        return null;
    }
}
