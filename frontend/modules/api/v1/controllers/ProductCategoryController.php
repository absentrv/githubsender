<?php

namespace frontend\modules\api\v1\controllers;

use common\models\User;
use frontend\modules\api\v1\resources\ProductCategory as ProductCategoryResource;
use Yii;
use yii\db\ActiveRecord;
use yii\filters\auth\HttpBasicAuth;
use yii\helpers\Url;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

/**
 * Description of ProductCategoryController
 *
 * @author Sergiy Filonyuk <sf@32x32.com.ua>
 */
class ProductCategoryController extends ActiveController {

    /**
     * @var string
     */
    public $modelClass = 'frontend\modules\api\v1\resources\ProductCategory';

    /**
     * @return array
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON
        ];
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => function ($username, $password) {
                $user = User::findByLogin($username);
                return ($user && $user->validatePassword($password)) ? $user : null;
            }
        ];
        $behaviors['rateLimiter']['enableRateLimitHeaders'] = true;
        return $behaviors;
    }
    
     /**
     * @api {GET} /product-categories/:id Get product category by id
     * @apiName Get product category by id
     * @apiGroup Product Category
     * @apiVersion 1.0.0
     *
     * @apiHeader {String} Content-Type application/json     
     * @apiHeader {String} Authorization uses HTTP Basic Authentication
     * @apiHeaderExample {json} Header-Example:
     *  {
     *      "Content-Type": "application/json",
     *      "Authorization": "Basic YXBpZG9jOmFwaWRvYw==" 
     *      
     *  } 
     * @apiParam {number} id Product Category id
     * @apiParamExample {curl} Call api method example:
     * GET http://agrod-site.32server.in.ua/api/v1/product-categories/5
     * @apiSuccess {Object} ProductCategory Returns created ProductCategory object 
     * @apiSuccess {string} ProductCategory.1c_id Id of category in 1C
     * @apiSuccess {number} ProductCategory.id ID of created ProductCategory
     * @apiSuccess {number} ProductCategory.position order position of created object
     * @apiSuccess {number} ProductCategory.parent_id id of parent category of created object
     * @apiSuccess {number} ProductCategory.visible visible status of created object
     * @apiSuccess {Object[]} translations List of translateable category attributes
     * @apiSuccess {String} translations.title Category title
     * @apiSuccess {String} translations.description Category description  
     * 
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 201 OK     
    *      {
    *          "id": 1,
    *          "1c_id": null,
    *          "position": 1,
    *          "parent_id": null,
    *          "visible": 1,
    *          "translations": [
    *              {
    *                  "title": "Комбайн",
    *                  "description": "Описание для категории"
    *              },
    *              {
    *                  "title": "Combine",
    *                  "description": "Description of combine category2"
    *              }
    *          ]
    *      }
     */
     /**
     * @api {GET} /product-categories Get all product categories
     * @apiName Get all product categories
     * @apiGroup Product Category
     * @apiVersion 1.0.0
     *
     * @apiHeader {String} Content-Type application/json     
     * @apiHeader {String} Authorization uses HTTP Basic Authentication
     * @apiHeaderExample {json} Header-Example:
     *  {
     *      "Content-Type": "application/json",
     *      "Authorization": "Basic YXBpZG9jOmFwaWRvYw==" 
     *      
     *  }    
     * @apiParamExample {curl} Call api method example:
     * GET http://agrod-site.32server.in.ua/api/v1/product-categories 
     * @apiSuccess {Object} ProductCategory Returns created ProductCategory object 
     * @apiSuccess {string} ProductCategory.1c_id Id of category in 1C
     * @apiSuccess {number} ProductCategory.id ID of created ProductCategory
     * @apiSuccess {number} ProductCategory.position order position of created object
     * @apiSuccess {number} ProductCategory.parent_id id of parent category of created object
     * @apiSuccess {number} ProductCategory.visible visible status of created object
     * @apiSuccess {Object[]} translations List of translateable category attributes
     * @apiSuccess {String} translations.title Category title
     * @apiSuccess {String} translations.description Category description  
     * 
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 201 OK
        * [
    *      {
    *          "id": 24,
    *          "1c_id": null,
    *          "position": 1,
    *          "parent_id": null,
    *          "visible": 1,
    *          "translations": [
    *              {
    *                  "title": "Комбайн",
    *                  "description": "Описание для категории"
    *              },
    *              {
    *                  "title": "Combine",
    *                  "description": "Description of combine category2"
    *              }
    *          ]
    *      },
    *      {
    *          "id": 25,
    *          "1c_id": null,
    *          "position": 1,
    *          "parent_id": null,
    *          "visible": 1,
    *          "translations": [
    *              {
    *                  "title": "Комбайн",
    *                  "description": "Описание для категории"
    *              },
    *              {
    *                  "title": "Combine",
    *                  "description": "Description of combine category2"
    *              }
    *          ]
    *      }
    *   ]
     */
    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass
            ],
            'view' => [
                'class' => 'yii\rest\ViewAction',
                'modelClass' => $this->modelClass,
                'findModel' => [$this, 'findModel']
            ],
            'options' => [
                'class' => 'yii\rest\OptionsAction'
            ]
        ];
    }
     /**
     * @api {post} /product-categories Create new category
     * @apiName Create new category
     * @apiGroup Product Category
     * @apiVersion 1.0.0
     *
     * @apiHeader {String} Content-Type application/json     
     * @apiHeader {String} Authorization uses HTTP Basic Authentication
     * @apiHeaderExample {json} Header-Example:
     *  {
     *      "Content-Type": "application/json",
     *      "Authorization": "Basic YXBpZG9jOmFwaWRvYw==" 
     *      
     *  }
     * @apiParam {string{max 50}} 1c_id Id of category in 1C
     * @apiParam {number} [position] category order on the site
     * @apiParam {number} [parent_id=null] id of parent category. If this category is parent set this value as null
     * @apiParam {number=0,1} [visible=1] category visibility
     * @apiParam {Object[translations]} translations List of translateable category attributes
     * @apiParam {string} translations.title Category title
     * @apiParam {string} translations.description Category description  
     * @apiParamExample {curl} Call api method example:
     * POST http://agrod-site.32server.in.ua/api/v1/product-categories
     * @apiParamExample {json} Request-Example:
     * {
     *"position": 1,
     *"parent_id": null,
     *"1c_id": "1cfd-sdf-sdf-sdf",
     *"visible": 1,
     *"translations": {
     *	"uk-UA": { 
     *		"title": "NEW Category Name"
     *		"description": "NEW test description",
     *	},
     *	"en-US": { 
     *		"title": "first_category",
     *		"description": "test description"
     *      }
     *  }
     *}   
     * @apiSuccess {Object} ProductCategory Returns created ProductCategory object 
     * @apiSuccess {string} ProductCategory.1c_id Id of category in 1C
     * @apiSuccess {number} ProductCategory.id ID of created ProductCategory
     * @apiSuccess {number} ProductCategory.position order position of created object
     * @apiSuccess {number} ProductCategory.parent_id id of parent category of created object
     * @apiSuccess {number} ProductCategory.visible visible status of created object
     * @apiSuccess {Object[]} translations List of translateable category attributes
     * @apiSuccess {String} translations.title Category title
     * @apiSuccess {String} translations.description Category description  
     * 
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 201 OK
     *{
     *"id" : 5, 
     *"position": 1,
     *"parent_id": null,
     *"visible": 1,
     *"translations": {
     *	"uk_UA": { 
     *		"title": "first_category",
     *		"description": "test description"
     *	},
     *	"en-US": { 
     *		"title": "first_category",
     *		"description": "test description"
     *	}
     *}
     *   }    
     */
    public function actionCreate()
    {
        $model = new $this->modelClass();
        
        foreach (Yii::$app->request->getBodyParam('translations', []) as $language => $data) {            
            foreach ($data as $attribute => $translation) {
                $model->translate($language)->$attribute = $translation;
            }
        }       
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');                      
       
        if ($model->save()) {            
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
            $model->refresh();
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }       
        return $model;
    }
        /**
     * @api {PUT} /product-categories/:id Update category
     * @apiName Update category
     * @apiGroup Product Category
     * @apiVersion 1.0.0
     *
     * @apiHeader {String} Content-Type application/json     
     * @apiHeader {String} Authorization uses HTTP Basic Authentication
     * @apiHeaderExample {json} Header-Example:
     *  {
     *      "Content-Type": "application/json",
     *      "Authorization": "Basic YXBpZG9jOmFwaWRvYw==" 
     *      
     *  }
     * @apiParam {string{max 50}} 1c_id Id of category in 1C database
     * @apiParam {number} [position] category order position on the site
     * @apiParam {number} [parent_id=null] id of parent category. If this category is parent set this value as null
     * @apiParam {number=0,1} [visible=1] category visibility
     * @apiParam {Object[translations]} translations List of translateable category attributes
     * @apiParam {String} translations.title Category title
     * @apiParam {String} translations.description Category description    
     * @apiParamExample {curl} Call api method example:
     * PUT http://agrod-site.32server.in.ua/api/v1/product-categories/1  
     * @apiParamExample {json} Request-Example:
     * {
     *"1c_id": "123-asd-231-asd",
     *"position": 1,
     *"parent_id": null,
     *"visible": 1,
     *"translations": {
     *	"uk-UA": { 
     *		"title": "NEW Category Name"
     *		"description": "NEW test description",
     *	},
     *	"en-US": { 
     *		"title": "first_category",
     *		"description": "test description"
     *      }
     *  }
     *}
     * @apiSuccess {Object} ProductCategory Returns created ProductCategory object 
     * @apiSuccess {string} ProductCategory.1c_id Id of category in 1C database
     * @apiSuccess {number} ProductCategory.id ID of created ProductCategory
     * @apiSuccess {number} ProductCategory.position order position of created object
     * @apiSuccess {number} ProductCategory.parent_id id of parent category of created object
     * @apiSuccess {number} ProductCategory.visible visible status of created object
     * @apiSuccess {Object[]} translations List of translateable category attributes
     * @apiSuccess {String} translations.title Category title
     * @apiSuccess {String} translations.description Category description  
     * 
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *{
     *"1c_id": "123-asd-231-asd",
     *"id" : 5, 
     *"position": 1,
     *"parent_id": null,
     *"visible": 1,
     *"translations": {
     *	"uk_UA": { 
     *		"title": "New first_category",
     *		"description": "New test description"
     *	},
     *	"en-US": { 
     *		"title": "first_category",
     *		"description": "test description"
     *	}
     *}
     *   }    
     */
    public function actionUpdate($id)
    {
        /* @var $model ActiveRecord */
        $model = $this->findModel($id);

        foreach (Yii::$app->request->getBodyParam('translations', []) as $language => $data) {            
            foreach ($data as $attribute => $translation) {
                $model->translate($language)->$attribute = $translation;
            }
        }     
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
     
        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }
        
        return $model;
    }
    
     /**
     * @api {DELETE} /product-categories/:id Delete category by id
     * @apiName Delete category
     * @apiGroup Product Category
     * @apiVersion 1.0.0
     *
     * @apiHeader {String} Content-Type application/json     
     * @apiHeader {String} Authorization uses HTTP Basic Authentication
     * @apiHeaderExample {json} Header-Example:
     *  {
     *      "Content-Type": "application/json",
     *      "Authorization": "Basic YXBpZG9jOmFwaWRvYw==" 
     *      
     *  }
     * @apiParam {Integer} id category id
     * @apiParamExample {curl} Call api method example:
     * DELETE http://agrod-site.32server.in.ua/api/v1/product-categories/1 
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 204 No Content    
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        if ($model->delete() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        Yii::$app->getResponse()->setStatusCode(204);
    }
    /**
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     */
    public function findModel($id) {
        $model = ProductCategoryResource::find()
                ->byId($id)
                ->with('translations')
                ->limit(1)
                ->one();
       
        if (!$model) {
            throw new NotFoundHttpException;
        }
        return $model;
    }

}
