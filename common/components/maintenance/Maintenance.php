<?php

namespace common\components\maintenance;

use Yii;
use yii\base\Component;

class Maintenance extends Component
{
    /**
     * @var boolean|\Closure boolean value or Closure that return
     * boolean indicating if app in maintenance mode or not
     */
    public $enabled;
    /**
     * @var string
     * @see \yii\web\Application::catchAll
     */
    public $catchAllRoute;

    /**
     * @var mixed
     * @link http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.37
     */
    public $retryAfter = 300;
    /**
     * @var string
     */
    public $maintenanceLayout = '@common/components/maintenance/views/layouts/main.php';
    /**
     * @var string
     */
    public $maintenanceView = '@common/components/maintenance/views/maintenance/index.php';
    /**
     * @var string
     */
    public $maintenanceText;

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param \yii\web\Application $app the application currently running
     */
    }
