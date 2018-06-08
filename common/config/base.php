<?php

$config = [
    'name' => 'GitSender',
    'vendorPath' => __DIR__ . '/../../vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'sourceLanguage' => 'en-US',
    'language' => 'en-US',
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'glideHelper' => [
            'class' => 'common\components\glide\GlideHelper',
        ],
        'authManager' => [
            'class' => yii\rbac\DbManager::class,
            'itemTable' => '{{%rbac_auth_item}}',
            'itemChildTable' => '{{%rbac_auth_item_child}}',
            'assignmentTable' => '{{%rbac_auth_assignment}}',
            'ruleTable' => '{{%rbac_auth_rule}}'
        ],
        'cache' => [
            'class' => yii\caching\FileCache::class,
            'cachePath' => '@common/runtime/cache'
        ],
        'commandBus' => [
            'class' => trntv\bus\CommandBus::class,
            'middlewares' => [
                [
                    'class' => trntv\bus\middlewares\BackgroundCommandMiddleware::class,
                    'backgroundHandlerPath' => '@console/yii',
                    'backgroundHandlerRoute' => 'command-bus/handle',
                ]
            ]
        ],
        'formatter' => [
            'class' => yii\i18n\Formatter::class,
        ],
        'glide' => [
            'class' => trntv\glide\components\Glide::class,
            'sourcePath' => '@storage/web/source',
            'cachePath' => '@storage/cache',
            'urlManager' => 'urlManagerStorage',
            'maxImageSize' => env('GLIDE_MAX_IMAGE_SIZE'),
            'signKey' => env('GLIDE_SIGN_KEY')
        ],
        'mailer' => [
            'class' => yii\swiftmailer\Mailer::class,
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => env('ADMIN_EMAIL')
            ]
        ],
        'db' => [
            'class' => yii\db\Connection::class,
            'dsn' => env('DB_DSN'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'tablePrefix' => env('DB_TABLE_PREFIX'),
            'charset' => env('DB_CHARSET', 'utf8'),
            'enableSchemaCache' => YII_ENV_PROD,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'db' => [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning'],
                    'except' => ['yii\web\HttpException:*', 'yii\i18n\I18N\*'],
                    'prefix' => function () {
                        $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : null;
                        return sprintf('[%s][%s]', Yii::$app->id, $url);
                    },
                    'logVars' => [],
                    'logTable' => '{{%system_log}}'
                ]
            ],
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => yii\i18n\PhpMessageSource::class,
                    'basePath' => '@common/messages',
                ],
                '*' => [
                    'class' => yii\i18n\PhpMessageSource::class,
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'common' => 'common.php',
                        'backend' => 'backend.php',
                        'frontend' => 'frontend.php',
                    ],
                    'on missingTranslation' => [backend\modules\i18n\Module::class, 'missingTranslation']
                ],
            /* Uncomment this code to use DbMessageSource
              '*'=> [
              'class' => 'yii\i18n\DbMessageSource',
              'sourceMessageTable'=>'{{%i18n_source_message}}',
              'messageTable'=>'{{%i18n_message}}',
              'enableCaching' => YII_ENV_DEV,
              'cachingDuration' => 3600,
              'on missingTranslation' => ['\backend\modules\i18n\Module', 'missingTranslation']
              ],
             */
            ],
        ],
        'fileStorage' => [
            'class' => trntv\filekit\Storage::class,
            'baseUrl' => '@storageUrl/source',
            'filesystem' => [
                'class' => common\components\filesystem\LocalFlysystemBuilder::class,
                'path' => '@storage/web/source'
            ],
            'as log' => [
                'class' => common\behaviors\FileStorageLogBehavior::class,
                'component' => 'fileStorage'
            ]
        ],
    
        'urlManagerBackend' => \yii\helpers\ArrayHelper::merge(
                [
            'hostInfo' => env('BACKEND_HOST_INFO'),
            'baseUrl' => env('BACKEND_BASE_URL'),
                ], require(Yii::getAlias('@backend/config/_urlManager.php'))
        ),
        'urlManagerFrontend' => \yii\helpers\ArrayHelper::merge(
                [
            'hostInfo' => env('FRONTEND_HOST_INFO'),
            'baseUrl' => env('FRONTEND_BASE_URL'),
                ], require(Yii::getAlias('@frontend/config/_urlManager.php'))
        ),
        'urlManagerStorage' => \yii\helpers\ArrayHelper::merge(
                [
            'hostInfo' => env('STORAGE_HOST_INFO'),
            'baseUrl' => env('STORAGE_BASE_URL'),
                ], require(Yii::getAlias('@storage/config/_urlManager.php'))
        ),
        'queue' => [
            'class' => \yii\queue\file\Queue::class,
            'path' => '@common/runtime/queue',
        ],
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    // Array of twig options:
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'html' => ['class' => '\yii\helpers\Html'],
                        'Url' => ['class' => '\yii\helpers\Url'],
                    ],
                    'functions' => [// defining available function
                        't' => 'Yii::t',
                        'dump' => '\yii\helpers\BaseVarDumper::dump',
                    ],
                    'extensions' => YII_DEBUG ? [
                '\Twig_Extension_Debug',
                    ] : [],
                    'uses' => ['yii\bootstrap'],
                ],
            // ...
            ],
        ],
    ],
    'params' => [
        'np_apikey' => '822c8b7726e7ad4eb773674d32a82c16',
        'adminEmail' => env('ADMIN_EMAIL'),
        'robotEmail' => env('ROBOT_EMAIL'),
        'availableLocales' => [
            'uk-UA' => 'Українська (Україна)',
            'en-US' => 'English (US)',
        ],
        'localesUrls' => [
            'uk-UA' => 'ua',
            'en-US' => 'en',
        ],
    ],
];

if (YII_ENV_PROD) {
    $config['components']['mailer']['transport'] = [
        'class' => 'Swift_SmtpTransport',
        'host' => 'smtp.gmail.com',
        'port' => env('SMTP_PORT'),
        'encryption' => 'tls',
        'username' => env('ROBOT_EMAIL'),
        'password' => env('SMTP_PASSWORD'),
    ];
}

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class
    ];

    $config['components']['cache'] = [
        'class' => yii\caching\DummyCache::class
    ];
    $config['components']['mailer']['transport'] = [
        'class' => 'Swift_SmtpTransport',
        'host' => env('SMTP_HOST'),
        'port' => env('SMTP_PORT'),
    ];
}

return $config;
