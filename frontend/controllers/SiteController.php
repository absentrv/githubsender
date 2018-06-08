<?php
namespace frontend\controllers;

use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use frontend\actions\ErrorAction;

/**
 * Description of SiteController
 *
 * @author Sergiy Filonyuk
 */
class SiteController extends Controller
{

    public $serializer = 'yii\rest\Serializer';

    public function behaviors()
    {
        return [
            'jsonResponse' => [
                'class' => ContentNegotiator::class,
                'only' => ['error'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ]
            ]
        ];
    }

    public function actions()
    {
        return [
            'error' => ErrorAction::class
        ];
    }
   
}
