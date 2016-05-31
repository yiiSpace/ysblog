<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'my\blog\frontend\Bootstrap',
    ],
    'aliases' => [
        '@my' => '@app/my',
        '@common' => '@app/common',
    ],
    'components' => [
        'view' => [
            /*
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                ],
            ],
            */
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'VKwdY7E601t1uiliVkZw8WQAAik05hZQ',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [

            'class' => 'my\user\components\User',

           // 'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
            'messageConfig' => [
                'from' => ['admin@website.com' => 'Admin'], // this is needed for sending emails
                'charset' => 'UTF-8',
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
    'modules' => [
        'admin' => [
            'class' => 'my\admin\Module',
            'modules' => [
                'blog' => [
                    'class' => 'my\blog\backend\Module',
                ],
            ]
        ],
        'blog' => [
            'class' => 'my\blog\frontend\Module',
        ],
        'comment' => [
            'class' => 'my\comment\Module',
        ],
        'user' => [
             'class' => 'my\user\Module',
            // 'class' => 'amnah\yii2\user\Module',
            // set custom module properties here ..
            'modelClasses'=> [
                    "User" => "my\user\models\User"
                ],

        ],
        'api' => [
            'class' => 'my\api\Module',
            'modules' => [
                // 'v1' => 'my\api\v1\Module',
                'v1' => [
                  'class'=>'my\api\v1\Module',
                    'modules'=>[
                        'comment'=>'my\comment\api\Module'
                    ],
                ] ,

                'comment'=>[
                    'class'=>'my\comment\api\Module'
                ],
            ]
        ]
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
