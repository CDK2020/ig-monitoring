<?php

use app\components\Formatter;
use app\models\User;
use app\modules\admin\Module;

date_default_timezone_set('UTC');

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'IG Monitoring',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'container' => require __DIR__ . '/container.php',
    'defaultRoute' => '/admin/monitoring/accounts',
    'modules' => [
        'admin' => [
            'class' => Module::class,
        ],
    ],
    'components' => [
        'queue' => require __DIR__ . '/queue.php',
        'formatter' => Formatter::class,
        'authClientCollection' => require __DIR__ . '/authClientCollection.php',
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'vT3_-Kt_uTwlkUroO-ijO3mWb-wpjKec',
        ],
        'cache' => require __DIR__ . '/cache.php',
        'user' => [
            'identityClass' => User::class,
            'loginUrl' => ['/admin/auth/login'],
        ],
        'errorHandler' => [
            'errorAction' => '/admin/default/error',
            'traceLine' => '<a href="phpstorm://open?url={file}&line={line}">{file}:{line}</a>',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'fileMode' => 0777,
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'traceLine' => '<a href="phpstorm://open?url={file}&line={line}">{file}:{line}</a>',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
        'generators' => [//here
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'templates' => [
                    'adminlte' => '@vendor/dmstr/yii2-adminlte-asset/gii/templates/crud/simple',
                ],
            ],
        ],
    ];
}

return $config;
