<?php

namespace backend\controllers;

use backend\models\search\TimelineEventSearch;
use Yii;
use backend\controllers\BaseController;

/**
 * Application timeline controller
 */
class TimelineEventController extends BaseController
{
    public $layout = 'common.twig';

    /**
     * Lists all TimelineEvent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TimelineEventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];

        return $this->render('index.twig', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
