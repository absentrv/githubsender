<?php

namespace backend\controllers;

use backend\models\SystemLog;
use common\models\TimelineEvent;
use Yii;
use yii\web\Controller;

/**
 * Description of BaseController
 *
 * @author sergiy
 */
class BaseController extends Controller {

    public function beforeAction($action) {
        
        if (Yii::$app->request->isGet) {            
            $timelineEvents = TimelineEvent::find()->today()->count();
            $systemLogCount = SystemLog::find()->count();
            $this->view->params['timelineEventCount'] = $timelineEvents;        
            $this->view->params['systemLogCount'] = $systemLogCount;        
        }
        return parent::beforeAction($action);
    }

}
