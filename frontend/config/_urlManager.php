<?php
return [
   'enableLanguagePersistence' => false,
    'enableLanguageDetection' => false,
    'enableLocaleUrls' => true,
    'languages' => [],
    'class' => 'frontend\components\localeUrlManager\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [

        // Api
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/product'],
        
    ]
];
