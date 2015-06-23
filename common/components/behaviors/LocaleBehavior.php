<?php

namespace common\components\behaviors;

use yii\base\Behavior;
use Yii;

/**
 * Class LocaleBehavior
 * @package common\components\behaviors
 */
class LocaleBehavior extends Behavior
{

    /**
     * @var string
     */
    public $cookieName = '_locale';

    /**
     * @return array
     */
    public function events()
    {
        return [
            \yii\web\Application::EVENT_BEFORE_REQUEST => 'beforeRequest'
        ];
    }

    /**
     * Resolve application language by checking user cookies, preferred language and profile settings
     */
    public function beforeRequest()
    {
        Yii::$app->language = 'ru-RU';
    }
}
