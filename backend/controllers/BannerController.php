<?php

namespace backend\controllers;

use backend\controllers\BaseController;
use common\actions\SetPosition;
use common\models\Banner;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\HttpCache;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * BannerController implements the CRUD actions for banner model.
 */
class BannerController extends BaseController {

    public function actions() {
        return [
            'set-position' => [
                'class' => SetPosition::class,
                'className' => Banner::class
            ]
        ];
    }

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            [
                'class' => HttpCache::class,
                'only' => ['index'],
                'lastModified' => function() {
                    return Banner::find()->max('updated_at');
                }
            ],
            [
                'class' => HttpCache::class,
                'only' => ['update'],
                'etagSeed' => function() {
                    $model = $this->findModel(\Yii::$app->request->get('id'));                  
                    return md5($model->updated_at);
                }
            ]
        ];
    }

    /**
     * Lists all banner models.
     * @return mixed
     */
    public function actionIndex() {        
        $dataProvider = new ActiveDataProvider([
            'query' => Banner::find(),
        ]);
        
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single banner model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new banner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new banner();
        foreach (Yii::$app->request->post('BannerTranslation', []) as $language => $data) {
            foreach ($data as $attribute => $translation) {
                $model->translate($language)->$attribute = $translation;
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing banner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        foreach (Yii::$app->request->post('BannerTranslation', []) as $language => $data) {
            foreach ($data as $attribute => $translation) {
                $model->translate($language)->$attribute = $translation;
            }
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing banner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the banner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return banner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = banner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
