<?php

/**
 * Этот файл является частью проекта Inely.
 *
 * @link http://github.com/hirootkit/inely
 *
 * @author hirootkit <admiralexo@gmail.com>
 */

namespace console\controllers;

use common\models\User;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $user = $auth->createRole(User::ROLE_USER);
        $auth->add($user);

        $loginToBackend = $auth->createPermission('loginToBackend');
        $auth->add($loginToBackend);

        $admin = $auth->createRole(User::ROLE_ADMINISTRATOR);
        $auth->add($admin);

        $auth->assign($admin, 1);
        $auth->assign($user, 2);

        Console::output('Success! RBAC roles has been added.');
    }
}
