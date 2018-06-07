<?php

namespace frontend\modules\api\v1;

use frontend\modules\api\Module as BaseModule;
use Yii;

class Module extends BaseModule {

    public $controllerNamespace = 'frontend\modules\api\v1\controllers';

    public function init() {
        parent::init();
        Yii::$app->user->identityClass = 'frontend\modules\api\v1\models\ApiUserIdentity';
        Yii::$app->user->enableSession = false;
        Yii::$app->user->loginUrl = null;        
    }

}
