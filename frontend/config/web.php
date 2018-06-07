<?php

$config = [
    'homeUrl' => Yii::getAlias('@frontendUrl'),
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'site/index',
    'bootstrap' => ['maintenance'],
    'modules' => [
        'user' => [
            'class' => frontend\modules\user\Module::class,
            'shouldBeActivated' => false,
            'enableLoginByPass' => false,
        ],
        'api' => [
            'class' => frontend\modules\api\Module::class,
            'modules' => [
                'v1' => frontend\modules\api\v1\Module::class
            ],
            'as globalAccess' => [
                'class' => common\behaviors\GlobalAccessBehavior::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['api_user'],
                    ]
                ]
            ],
        ]
    ],
    'on beforeRequest' => function ($event) {
        $url = Yii::$app->request->getUrl();
        if (strpos($url, '/api/v1/') !== false) {
            $data = "IP: " . Yii::$app->request->getUserIP() . PHP_EOL;
            $data .= "Method: " . Yii::$app->request->method . PHP_EOL;
            $data .= 'Data: ' . print_r(Yii::$app->request->getRawBody(), true);
            Yii::warning($data, 'api');
        }
    },
    'components' => [        
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'maintenance' => [
            'class' => common\components\maintenance\Maintenance::class,
            'enabled' => function ($app) {
                if (env('APP_MAINTENANCE') === '1') {
                    return true;
                }
                return $app->keyStorage->get('frontend.maintenance') === 'enabled';
            }
        ],
        'request' => [
            'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY'),
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'class' => yii\web\User::class,
            'identityClass' => common\models\User::class,
            'loginUrl' => ['/user/sign-in/login'],
            'enableAutoLogin' => true,
            'as afterLogin' => common\behaviors\LoginTimestampBehavior::class
        ],        
    ]
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
        'generators' => [
            'crud' => [
                'class' => yii\gii\generators\crud\Generator::class,
                'messageCategory' => 'frontend'
            ]
        ]
    ];
}

return $config;
