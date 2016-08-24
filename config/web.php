<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'language'=>'zh-CN',

    'bootstrap' => [
        'log',
        'my\blog\frontend\Bootstrap',
        'plugins',
    ],
    'aliases' => [
        '@my' => '@app/my',
        '@common' => '@app/common',
    ],
    // support the multiple themes
    // NOTE  不可以放 aliases 属性上面哦 不然别名找不到 坑！
    'as themeAble' => [
        'class' => 'common\behaviors\Themable',
    ],
    'components' => [
        'plugins' => [
            'class' => 'lo\plugins\components\EventBootstrap',
            'appId' => 'frontend'
        ],
        // @see http://www.ramirezcobos.com/2014/03/22/how-to-use-bootstrapinterface-yii2/
        'view' => [
            'class'=>'common\base\View',
            'theme' => [
                'class' => 'common\base\Theme',
                'active' =>  'mdl', //'materialize',
                'basePath' => '@app/themes/mdl',
                // this will be used for assets(js css images) file
                'baseUrl' => '@web/themes/mdl',
                'pathMap' => [
                    '@app/views' => [
                        '@app/themes/mdl/views',
                    ]
                ],
                /*
                'pathMap' => [
                    '@app/views' => '@app/themes/basic',
                    '@app/modules' => '@app/themes/basic/modules', // <-- !!!
                ],
                */
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'VKwdY7E601t1uiliVkZw8WQAAik05hZQ',
        ],
        'settings' => [
                'class'            => 'marsoltys\yii2settings\CmsSettings',
                'cacheComponentId' => 'cache',
                'cacheId'          => 'global_website_settings',
                'cacheTime'        => 84000,
                'tableName'        => '{{settings}}',
                'dbComponentId'    => 'db',
                'createTable'      => true, // TODO 首次运行后 第二次关闭之
            'dbEngine'         => 'InnoDB',
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
                'menu' => [
                    'class' => 'infoweb\menu\Module',
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
        ],
        'test' => [
            'class' => 'my\test\Module',
        ],
        'plugins' => [
            'class' => 'lo\plugins\Module',
            'pluginsDir'=>[
                '@lo/plugins/plugins', // default dir with core plugins
                // '@common/plugins', // dir with our plugins
            ]
        ],
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
