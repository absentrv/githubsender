<?php

namespace backend\controllers;

use common\actions\SetPosition;
use common\models\ArticleCategory;
use common\models\Page;
use frontend\models\search\ArticleSearch;
use common\models\Article;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends BaseController
{
    public function actions() {
        return  [
            'set-position' => [
                'class' => SetPosition::class,
                'className' => Page::class
            ]
        ];
    }
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post']
                ]
            ]
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $searchModel = new ArticleSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => Article::find()
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();
 
         foreach (Yii::$app->request->post('ArticleTranslation', []) as $language => $data) {
            foreach ($data as $attribute => $translation) {
                $model->translate($language)->$attribute = $translation;
            }
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'categories' => ArticleCategory::find()->active()->all(),
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {    
        $model = $this->findModel($id);
foreach (Yii::$app->request->post('ArticleTranslation', []) as $language => $data) {
            foreach ($data as $attribute => $translation) {
                $model->translate($language)->$attribute = $translation;
            }
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'categories' => ArticleCategory::find()->active()->all(),
            ]);
        }
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
}
