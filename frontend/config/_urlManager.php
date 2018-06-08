<?php
return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'enableStrictParsing' => true,
    'rules' => [
        // Api
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => ['api/v1/user'],
            'pluralize' => true,
            'extraPatterns' => [
                'OPTIONS send-message' => 'options',                
                'OPTIONS sign-up' => 'options',                
                'OPTIONS sign-in' => 'options',                
                
                'POST send-message' => 'send-message',
                'POST sign-up' => 'sign-up',
                'POST sign-in' => 'sign-in'
                
            ]
            
        ],  
    ]
];
