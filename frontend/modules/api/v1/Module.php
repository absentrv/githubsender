<?php
namespace frontend\modules\api\v1;

use frontend\modules\api\Module as BaseModule;
use Yii;

class Module extends BaseModule
{

    public $controllerNamespace = 'frontend\modules\api\v1\controllers';

    public function init()
    {
        parent::init();
        Yii::$app->user->identityClass = 'frontend\modules\api\v1\models\ApiUserIdentity';
        Yii::$app->user->enableSession = false;        
        Yii::$app->user->loginUrl = null;

        Yii::$app->response->on(\yii\web\Response::EVENT_BEFORE_SEND, function($event) {
            $response = $event->sender;
            $response->data = [
                'success' => $response->isSuccessful,
                'data' => $response->data ?? [],
            ];
        });
    }
}
