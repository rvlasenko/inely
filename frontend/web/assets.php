<?php
/**
 * sudo ./yii asset web/assets.php config/assets-prod.php
 * sudo chown -R $USER:$USER /var/www/madeasy
 */

// In the console environment, some path aliases may not exist. Please define these:
Yii::setAlias('@webroot', __DIR__);
Yii::setAlias('@web', '/');

return [
    // Настроить команду/обратный вызов для сжатия файлов JavaScript:
    'jsCompressor' => 'java -jar /var/www/madeasy/frontend/web/compiler.jar --js {from} --js_output_file {to}',
    // Настроить команду/обратный вызов для сжатия файлов CSS:
    'cssCompressor' => 'java -jar /var/www/madeasy/frontend/web/yuicompressor-2.4.8.jar --type css {from} -o {to}',
    // Список комплектов ресурсов для сжатия:
    'bundles' => [
        '\frontend\assets\FrontendAsset',
        //'\frontend\assets\LandingAsset',
    ],
    // Комплект ресурса после сжатия:
    'targets' => [
        'all' => [
            'class' => 'yii\web\AssetBundle',
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'js' => 'all-{hash}.js',
            'css' => 'all-{hash}.css',
        ],
    ],
    // Настройка менеджера ресурсов:
    'assetManager' => [
        'basePath' => '@webroot/assets',
        'baseUrl' => '@web/assets',
    ],
];