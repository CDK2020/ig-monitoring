<?php

use pahanini\log\ConsoleTarget;
use yii\faker\FixtureController;

date_default_timezone_set('UTC');

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'queue'],
    'controllerNamespace' => 'app\commands',
    'container' => require __DIR__ . '/container.php',
    'components' => [
        'queue' => require __DIR__ . '/queue.php',
        'cache' => require __DIR__ . '/cache.php',
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'fileMode' => 0777,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['profile'],
                    'categories' => ['yii\db\*'],
                    'fileMode' => 0777,
                    'logFile' => '@runtime/logs/profile.log',
                    'logVars' => [],
                ],
                [
                    'class' => yii\log\FileTarget::class,
                    'levels' => ['error', 'warning', 'info'],
                    'categories' => [
                        'app\components\instagram\AccountScraper*',
                    ],
                    'logFile' => '@runtime/logs/ig_requests.log',
                    'logVars' => [],
                ],
                [
                    'class' => ConsoleTarget::class,
                    'levels' => ['error', 'warning', 'info'],
                    'categories' => [
                        'app\components\AccountManager*',
                        'app\components\instagram\*',
                    ],
                    'logVars' => [],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
//            'migrationPath' => null,
            'migrationNamespaces' => [
                'yii\queue\db\migrations',
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
    $config['modules']['fixture'] = [ // Fixture generation command line.
      'class' => FixtureController::class,
      'templatePath' => 'tests/fixtures/templates',
      'fixtureDataPath' => 'tests/fixtures/data',
      'namespace' => 'app\tests\fixtures',
      'count' => 10,
    ];
}

return $config;
