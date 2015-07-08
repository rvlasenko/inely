<?php
namespace common\components\maintenance;

use yii\web\AssetBundle;

/**
 * Class MaintenanceAsset
 * @package common\components\maintenance
 */
class MaintenanceAsset extends AssetBundle
{
    public $sourcePath = '@common/components/maintenance/assets';

    public $css = [
        'css/maintenance.css'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset'
    ];
}
