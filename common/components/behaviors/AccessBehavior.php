<?php

namespace common\components\behaviors;

use yii\base\Behavior;
use yii\console\Controller;
use yii\helpers\Url;
use Yii;

/**
 * Redirects all users to login page if not logged in
 */
class AccessBehavior extends Behavior
{
    /**
     * Subscribe for events
     * @return array
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction'
        ];
    }
    /**
     * On event callback
     */
    public function beforeAction()
    {
        if (Yii::$app->getUser()->isGuest && Yii::$app->getRequest()->url !== Url::to(\Yii::$app->getUser()->loginUrl))
            Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl);
    }
}