<?php
/**
 * Application configuration shared by all applications and test types
 */
return [
    'language'      => 'en-US',
    'controllerMap' => [
        'fixture' => [
            'class'           => 'yii\faker\FixtureController',
            'fixtureDataPath' => '@tests/codeception/common/fixtures/data',
            'templatePath'    => '@tests/codeception/common/templates/fixtures',
            'namespace'       => 'tests\codeception\common\fixtures',
        ],
    ],
    'components'    => [
        'db'         => [
            'dsn'      => 'mysql:host=localhost;port=3306;dbname=madeasy',
            'username' => 'root',
            'password' => 'qwerty'
        ],
        'mailer'     => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];
