<?php

namespace common\components\events;

use yii\base\Event;

class AfterSignUpEvent extends Event
{
    const EVENT_NEW_USER = 'new-user';

    public function newUser($event)
    {
        echo 'Under construction';
    }
}