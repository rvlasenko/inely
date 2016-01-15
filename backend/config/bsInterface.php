<?php

namespace backend\config;

use backend\models\Task;
use common\models\UserProfile;
use Yii;
use yii\base\BootstrapInterface;

/**
 * Class bsInterface
 * @package backend\config
 */

class bsInterface implements BootstrapInterface
{
    private $userId;

    public function __construct() {
        $this->userId = Yii::$app->user->id;
    }

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * Loads all the settings into the Yii::$app->params array
     *
     * @param Application $app the application currently running
     */

    public function bootstrap($app)
    {
        if ($this->userId) {
            Yii::$app->view->params['firstName'] = Yii::$app->user->identity->userProfile->firstname ?: Yii::$app->user->identity->username;
            Yii::$app->view->params['haveAssignedToMe'] = Task::findOne(['assignedTo' => $this->userId]);
        }
    }

}