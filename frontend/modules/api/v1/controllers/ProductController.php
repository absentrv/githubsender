<?php

namespace frontend\modules\api\v1\controllers;

use common\models\User;
use frontend\modules\api\v1\resources\Product;
use Yii;
use yii\db\ActiveRecord;
use yii\filters\auth\HttpBasicAuth;
use yii\helpers\Url;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

/**
 * Description of ProductController
 *
 * @author Sergiy Filonyuk <sf@32x32.com.ua>
 */
class ProductController extends ActiveController {

    /**
     * @var string
     */
    public $modelClass = 'frontend\modules\api\v1\resources\Product';

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
     * @api {GET} /products/:id Get product 
     * @apiName Get product 
     * @apiGroup Product
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
     * @apiParam {number} id Id of product     
     * @apiParamExample {curl} Call api method example:
     * POST http://agrod-site.32server.in.ua/api/v1/products/5     
     * @apiSuccess {Object} product Returns created Product object 
     * @apiSuccess {number} product.id ID of created Product object
     * @apiSuccess {string} product.1c_id Id of product in 1C
     * @apiSuccess {number} product.position order position of created object
     * @apiSuccess {boolean} product.status visible status of created object (1 - visible, 0 - unvisible)
     * @apiSuccess {number} product.category_id id of product category
     * @apiSuccess {number} product.availability product count of created object
     * @apiSuccess {number} product.price product price
     * @apiSuccess {string} product.oem oem of product
     * @apiSuccess {string[]} product.image Array with main image properties
     * @apiSuccess {string} product.image.path path to main image location
     * @apiSuccess {object[object]} product.productAttachments array of additional product images with poperties
     * @apiSuccess {string} product.productAttachments.path path to additional product image
     * @apiSuccess {object[translations]} product.translations List of translateable Product attributes
     * @apiSuccess {object[]=uk-UA, en-US} product.translations.language Language
     * @apiSuccess {string{max 255 symbols}} product.translations.language.title Product title
     * @apiSuccess {string} product.translations.language.description Product description  
     * @apiSuccess {string} product.translations.language.short_description Product short description  
     * @apiSuccess {number[]} product.analogs Array of Product analogs ids
     * @apiSuccess {object[]} product.characteristics Array of product characteristics with translations
     * @apiSuccess {object[]=uk-UA, en-US} product.characteristics.language Language as a key to array
     * @apiSuccess {string{..max 255}} product.characteristics.language.title Characteristic title
     * @apiSuccess {string{..max 255}} product.characteristics.language.value Characteristic value
     * @apiSuccess {string{..max 50}} [product.characteristics.language.measurement] Characteristic measurement
     * @apiParam {object[]} usedIn Array of Product Used In with their translations 
     * @apiParam {object[usedIn]=uk-UA, en-US} usedIn.language Language is a key of each element of characteristics array
     * @apiParam {string} usedIn.language.title Title of Product Used In
     * @apiParam {string} usedIn.language.parent_title Parent Title of Product Used In
     * 
     * 
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     *  {
     *    "id": 24,
     *    "1c_id": null,
     *    "position": 1,
     *    "status": 1,
     *    "category_id": 24,
     *    "availability": 10,
     *    "price": "1250.55",
     *    "oem": "testString",
     *    "image": {
     *        "path": "1c/2WTWJ_RPs-MEWewLPc28Z6hgbKcMZOjl.jpg",
     *        "base_url": "http://storage.agrodruzi.local/source",
     *        "type": "image/jpeg",
     *        "size": 1061959,
     *        "name": null,
     *        "order": null,
     *        "timestamp": 1521722357
     *    },
     *    "productAttachments": [
     *        {
     *            "id": 47,
     *            "product_id": 24,
     *            "path": "1c/35vvjzyoXd_Xqub499LmMrNQ7g61sa2f.jpg",
     *            "base_url": "http://storage.agrodruzi.local/source",
     *            "created_at": 1521735435,
     *            "updated_at": 1521735435,
     *            "order": null
     *        },
     *        {
     *            "id": 48,
     *            "product_id": 24,
     *            "path": "1c/QvXM-uRibBxRhxqgjZIGe4poMODBUMAX.jpg",
     *            "base_url": "http://storage.agrodruzi.local/source",
     *            "created_at": 1521735435,
     *            "updated_at": 1521735435,
     *            "order": null
     *        }
     *    ],
     *    "translations": {
     *        "en-US": {
     *            "title": "Combine",
     *            "description": "Combine description",
     *            "language": "en-US"
     *        },
     *        "uk-UA": {
     *            "title": "Комбайн",
     *            "description": "Опис до комбайну",
     *            "language": "uk-UA"
     *        }
     *    },
     *    "analogs": [
     *        "21",
     *        "22"
     *    ],
     *    "characteristics": [{
     *        "uk-UA": {
     *            "language": "uk-UA",
     *            "title": "Виробник",
     *            "measurement": null,
     *            "value": "ХТЗ"
     *        },
     *        "en-US": {
     *            "language": "en-US",
     *            "title": "Manufacturer",
     *            "measurement": null,
     *            "value": "HTZ"
     *        }
     *    }],
     *    "usedIn": [{
     *        "uk-UA": {
     *            "language": "uk-UA",
     *            "title": "COMMANDOR",
     *            "parent_title": "Комбайн (укр)",
     *        },
     *        "en-US": {
     *            "language": "en-US",
     *            "title": "COMMANDOR",
     *            "parent_title": "Комбайн (укр)",
     *        }
     *    }]
     * }
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
     * @api {POST} /products Create new product
     * @apiName Create new product
     * @apiGroup Product
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
     * @apiParam {string{max 50}} 1c_id Id of product in 1C
     * @apiParam {number} [position] Product order on the site (need for custom sorting)
     * @apiParam {number=0,1} [status=1] Product status (visibility)
     * @apiParam {number} category_id id of product category.
     * @apiParam {number} availability Product count.
     * @apiParam {number} price Product price.
     * @apiParam {string} [oem] Product OEM.
     * @apiParam {string[]} [images] Product images. <br><b>Note</b>: the first image in array is the main image
     * @apiParam {object[translations]} translations List of translateable Product attributes
     * @apiParam {object[]=uk-UA, en-US} translations.language Language
     * @apiParam {string{max 255 symbols}} translations.language.title Product title
     * @apiParam {string} translations.language.description Product description  
     * @apiParam {string} translations.language.short_description Product short description  
     * @apiParam {number[]} analogs Array of analogs Product ids 
     * @apiParam {object[]} characteristics Array of Product characteristics with their translations 
     * @apiParam {object[characteristics]=uk-UA, en-US} characteristics.language Language is a key of each element of characteristics array
     * @apiParam {string} characteristics.language.title Title of Product characteristic
     * @apiParam {string} characteristics.language.measurement Measurement of Product characteristic
     * @apiParam {string} characteristics.language.value Value of Product characteristic
     * @apiParam {object[]} usedIn Array of Product Used In with their translations 
     * @apiParam {object[usedIn]=uk-UA, en-US} usedIn.language Language is a key of each element of characteristics array
     * @apiParam {string} usedIn.language.title Title of Product Used In
     * @apiParam {string} usedIn.language.parent_title Parent Title of Product Used In
     * @apiParamExample {curl} Call api method example:
     * POST http://agrod-site.32server.in.ua/api/v1/products
     * @apiParamExample {json} Request-Example:
     *    {
     * 	"1c_id": "222-asdasd-qweqew",
     * 	"position": 1,
     * 	"status": 1,
     * 	"category_id": 24,
     * 	"availability": 10,
     * 	"price": 1250.55,
     * 	"oem": "testString",
     * 	"images": [
     * 		"2WTWJ_RPs-MEWewLPc28Z6hgbKcMZOjl.jpg",
     * 		"35vvjzyoXd_Xqub499LmMrNQ7g61sa2f.jpg",
     * 		"QvXM-uRibBxRhxqgjZIGe4poMODBUMAX.jpg"
     * 		],
     * 	"translations": {
     * 		"uk-UA": { 
     * 			"description": "Опис до комбайну",
     * 			"short_description": "Короткий опис до комбайну",
     * 			"title": "Комбайн"
     * 		},
     * 		"en-US": { 
     * 			"title": "Combine",
     * 			"short_description": "Short combine description",
     * 			"description": "Combine description"
     * 		}
     * 	},
     * 	"analogs": [
     * 		21,22
     * 		],
     * 	"characteristics": [
     * 		{
     * 		"uk-UA": {
     * 			"title": "Масимальна швидкість",
     * 			"measurement": "км",
     * 			"value": "45"
     * 		},
     * 		"en-US": {
     * 			"title": "Max speed",
     * 			"measurement": "km",
     * 			"value": "45"
     * 		}
     * 	},
     * 	{
     * 		"uk-UA": {
     * 			"title": "Виробник",
     * 			"measurement": null,
     * 			"value": "ХТЗ"
     * 		},
     * 		"en-US": {
     * 			"title": "Manufacturer",
     * 			"measurement": null,
     * 			"value": "HTZ"
     * 		}
     * 	}
     * 	],
     *    "usedIn": [{
     *        "uk-UA": {
     *            "language": "uk-UA",
     *            "title": "COMMANDOR",
     *            "parent_title": "Комбайн (укр)",
     *        },
     *        "en-US": {
     *            "language": "en-US",
     *            "title": "COMMANDOR",
     *            "parent_title": "Комбайн (укр)",
     *        }
     *    }]
     * }
     * @apiSuccess {Object} product Returns created Product object 
     * @apiSuccess {number} product.id ID of created Product object
     * @apiSuccess {string} product.1c_id Id of product in 1C
     * @apiSuccess {number} product.position order position of created object
     * @apiSuccess {boolean} product.status visible status of created object (1 - visible, 0 - unvisible)
     * @apiSuccess {number} product.category_id id of product category
     * @apiSuccess {number} product.availability product count of created object
     * @apiSuccess {number} product.price product price
     * @apiSuccess {string} product.oem oem of product
     * @apiSuccess {string[]} product.image Array with main image properties
     * @apiSuccess {string} product.image.path path to main image location
     * @apiSuccess {object[object]} product.productAttachments array of additional product images with poperties
     * @apiSuccess {string} product.productAttachments.path path to additional product image
     * @apiSuccess {object[translations]} product.translations List of translateable Product attributes
     * @apiSuccess {object[]=uk-UA, en-US} product.translations.language Language
     * @apiSuccess {string{max 255 symbols}} product.translations.language.title Product title
     * @apiSuccess {string} product.translations.language.description Product description  
     * @apiSuccess {string} product.translations.language.short_description Product short description  
     * @apiSuccess {number[]} product.analogs Array of Product analogs ids
     * @apiSuccess {object[]} product.characteristics Array of product characteristics with translations
     * @apiSuccess {object[]=uk-UA, en-US} product.characteristics.language Language as a key to array
     * @apiSuccess {string{..max 255}} product.characteristics.language.title Characteristic title
     * @apiSuccess {string{..max 255}} product.characteristics.language.value Characteristic value
     * @apiSuccess {string{..max 50}} [product.characteristics.language.measurement] Characteristic measurement
     * @apiParam {object[]} usedIn Array of Product Used In with their translations 
     * @apiParam {object[usedIn]=uk-UA, en-US} usedIn.language Language is a key of each element of characteristics array
     * @apiParam {string} usedIn.language.title Title of Product Used In
     * @apiParam {string} usedIn.language.parent_title Parent Title of Product Used In
     * 
     * 
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 201 Created
     *     {
     *    "id": 24,
     *    "1c_id": null,
     *    "position": 1,
     *    "status": 1,
     *    "category_id": 24,
     *    "availability": 10,
     *    "price": "1250.55",
     *    "oem": "testString",
     *    "image": {
     *        "path": "1c/2WTWJ_RPs-MEWewLPc28Z6hgbKcMZOjl.jpg",
     *        "base_url": "http://storage.agrodruzi.local/source",
     *        "type": "image/jpeg",
     *        "size": 1061959,
     *        "name": null,
     *        "order": null,
     *        "timestamp": 1521722357
     *    },
     *    "productAttachments": [
     *        {
     *            "id": 47,
     *            "product_id": 24,
     *            "path": "1c/35vvjzyoXd_Xqub499LmMrNQ7g61sa2f.jpg",
     *            "base_url": "http://storage.agrodruzi.local/source",
     *            "created_at": 1521735435,
     *            "updated_at": 1521735435,
     *            "order": null
     *        },
     *        {
     *            "id": 48,
     *            "product_id": 24,
     *            "path": "1c/QvXM-uRibBxRhxqgjZIGe4poMODBUMAX.jpg",
     *            "base_url": "http://storage.agrodruzi.local/source",
     *            "created_at": 1521735435,
     *            "updated_at": 1521735435,
     *            "order": null
     *        }
     *    ],
     *    "translations": {
     *        "en-US": {
     *            "title": "Combine",
     *            "description": "Combine description",
     *            "language": "en-US"
     *        },
     *        "uk-UA": {
     *            "title": "Комбайн",
     *            "description": "Опис до комбайну",
     *            "language": "uk-UA"
     *        }
     *    },
     *    "analogs": [
     *        "21",
     *        "22"
     *    ],    
     *    "characteristics": [{
     *        "uk-UA": {
     *            "language": "uk-UA",
     *            "title": "Виробник",
     *            "measurement": null,
     *            "value": "ХТЗ"
     *        },
     *        "en-US": {
     *            "language": "en-US",
     *            "title": "Manufacturer",
     *            "measurement": null,
     *            "value": "HTZ"
     *        }
     *    }],
     *    "usedIn": [{
     *        "uk-UA": {
     *            "language": "uk-UA",
     *            "title": "COMMANDOR",
     *            "parent_title": "Комбайн (укр)",
     *        },
     *        "en-US": {
     *            "language": "en-US",
     *            "title": "COMMANDOR",
     *            "parent_title": "Комбайн (укр)",
     *        }
     *    }]
     * }
     */
    public function actionCreate() {       
        $model = $this->processTranslations(new $this->modelClass(), Yii::$app->request->getBodyParam('translations', []));
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        $this->processImages($model, Yii::$app->getRequest()->getBodyParam('images', []));
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
     * @api {PUT} /products/:id Update product
     * @apiName Update product
     * @apiGroup Product
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
     * @apiParam {string{max 50}} 1c_id Id of product in 1C
     * @apiParam {number} [position] Product order on the site (need for custom sorting)
     * @apiParam {number=0,1} [status=1] Product status (visibility)
     * @apiParam {number} category_id id of product category.
     * @apiParam {number} availability Product count.
     * @apiParam {number} price Product price.
     * @apiParam {string} [oem] Product OEM.
     * @apiParam {string[]} [images] Product images. <br><b>Note</b>: the first image in array is the main image
     * @apiParam {object[translations]} translations List of translateable Product attributes
     * @apiParam {object[]=uk-UA, en-US} translations.language Language
     * @apiParam {string{max 255 symbols}} translations.language.title Product title
     * @apiParam {string} translations.language.description Product description  
     * @apiParam {string} translations.language.short_description Product short description  
     * @apiParam {number[]} analogs Array of analogs Product ids 
     * @apiParam {object[]} characteristics Array of Product characteristics with their translations 
     * @apiParam {object[characteristics]=uk-UA, en-US} characteristics.language Language is a key of each element of characteristics array
     * @apiParam {string} characteristics.language.title Title of Product characteristic
     * @apiParam {string} characteristics.language.measurement Measurement of Product characteristic
     * @apiParam {string} characteristics.language.value Value of Product characteristic
     * @apiParam {object[]} usedIn Array of Product Used In with their translations 
     * @apiParam {object[usedIn]=uk-UA, en-US} usedIn.language Language is a key of each element of characteristics array
     * @apiParam {string} usedIn.language.title Title of Product Used In
     * @apiParam {string} usedIn.language.parent_title Parent Title of Product Used In
     * @apiParamExample {curl} Call api method example:
     * PUT http://agrod-site.32server.in.ua/api/v1/products
     * @apiParamExample {json} Request-Example:
     *    {
     * 	"1c_id": "222-asdasd-qweqew",
     * 	"position": 1,
     * 	"status": 1,
     * 	"category_id": 24,
     * 	"availability": 10,
     * 	"price": 1250.55,
     * 	"oem": "testString",
     * 	"images": [
     * 		"2WTWJ_RPs-MEWewLPc28Z6hgbKcMZOjl.jpg",
     * 		"35vvjzyoXd_Xqub499LmMrNQ7g61sa2f.jpg",
     * 		"QvXM-uRibBxRhxqgjZIGe4poMODBUMAX.jpg"
     * 		],
     * 	"translations": {
     * 		"uk-UA": { 
     * 			"description": "Опис до комбайну",
     * 			"short_description": "Короткий опис до комбайну",
     * 			"title": "Комбайн"
     * 		},
     * 		"en-US": { 
     * 			"title": "Combine",
     * 			"short_description": "Short combine description",
     * 			"description": "Combine description"
     * 		}
     * 	},
     * 	"analogs": [
     * 		21,22
     * 		],
     * 	"characteristics": [
     * 		{
     * 		"uk-UA": {
     * 			"title": "Масимальна швидкість",
     * 			"measurement": "км",
     * 			"value": "45"
     * 		},
     * 		"en-US": {
     * 			"title": "Max speed",
     * 			"measurement": "km",
     * 			"value": "45"
     * 		}
     * 	},
     * 	{
     * 		"uk-UA": {
     * 			"title": "Виробник",
     * 			"measurement": null,
     * 			"value": "ХТЗ"
     * 		},
     * 		"en-US": {
     * 			"title": "Manufacturer",
     * 			"measurement": null,
     * 			"value": "HTZ"
     * 		}
     * 	}
     * 	],
     *    "usedIn": [{
     *        "uk-UA": {
     *            "language": "uk-UA",
     *            "title": "COMMANDOR",
     *            "parent_title": "Комбайн (укр)",
     *        },
     *        "en-US": {
     *            "language": "en-US",
     *            "title": "COMMANDOR",
     *            "parent_title": "Комбайн (укр)",
     *        }
     *    }]
     * }
     * @apiSuccess {Object} product Returns created Product object 
     * @apiSuccess {number} product.id ID of created Product object
     * @apiSuccess {string} product.1c_id Id of product in 1C
     * @apiSuccess {number} product.position order position of created object
     * @apiSuccess {boolean} product.status visible status of created object (1 - visible, 0 - unvisible)
     * @apiSuccess {number} product.category_id id of product category
     * @apiSuccess {number} product.availability product count of created object
     * @apiSuccess {number} product.price product price
     * @apiSuccess {string} product.oem oem of product
     * @apiSuccess {string[]} product.image Array with main image properties
     * @apiSuccess {string} product.image.path path to main image location
     * @apiSuccess {object[object]} product.productAttachments array of additional product images with poperties
     * @apiSuccess {string} product.productAttachments.path path to additional product image
     * @apiSuccess {object[translations]} product.translations List of translateable Product attributes
     * @apiSuccess {object[]=uk-UA, en-US} product.translations.language Language
     * @apiSuccess {string{max 255 symbols}} product.translations.language.title Product title
     * @apiSuccess {string} product.translations.language.description Product description  
     * @apiSuccess {string} product.translations.language.short_description Product short description  
     * @apiSuccess {number[]} product.analogs Array of Product analogs ids
     * @apiSuccess {object[]} product.characteristics Array of product characteristics with translations
     * @apiSuccess {object[]=uk-UA, en-US} product.characteristics.language Language as a key to array
     * @apiSuccess {string{max 255}} product.characteristics.language.title Characteristic title
     * @apiSuccess {string{max 255}} product.characteristics.language.value Characteristic value
     * @apiSuccess {string{max 50}} [product.characteristics.language.measurement] Characteristic measurement
     * @apiParam {object[]} usedIn Array of Product Used In with their translations 
     * @apiParam {object[usedIn]=uk-UA, en-US} usedIn.language Language is a key of each element of characteristics array
     * @apiParam {string} usedIn.language.title Title of Product Used In
     * @apiParam {string} usedIn.language.parent_title Parent Title of Product Used In
     * 
     * 
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 200 OK
     * {
     *    "id": 24,
     *    "1c_id": "asdad-123123-asdasd-asd",
     *    "position": 1,
     *    "status": 1,
     *    "category_id": 24,
     *    "availability": 10,
     *    "price": "1250.55",
     *    "oem": "testString",
     *    "image": {
     *        "path": "1c/2WTWJ_RPs-MEWewLPc28Z6hgbKcMZOjl.jpg",
     *        "base_url": "http://storage.agrodruzi.local/source",
     *        "type": "image/jpeg",
     *        "size": 1061959,
     *        "name": null,
     *        "order": null,
     *        "timestamp": 1521722357
     *    },
     *    "productAttachments": [
     *        {
     *            "id": 47,
     *            "product_id": 24,
     *            "path": "1c/35vvjzyoXd_Xqub499LmMrNQ7g61sa2f.jpg",
     *            "base_url": "http://storage.agrodruzi.local/source",
     *            "created_at": 1521735435,
     *            "updated_at": 1521735435,
     *            "order": null
     *        },
     *        {
     *            "id": 48,
     *            "product_id": 24,
     *            "path": "1c/QvXM-uRibBxRhxqgjZIGe4poMODBUMAX.jpg",
     *            "base_url": "http://storage.agrodruzi.local/source",
     *            "created_at": 1521735435,
     *            "updated_at": 1521735435,
     *            "order": null
     *        }
     *    ],
     *    "translations": {
     *        "en-US": {
     *            "title": "Combine",
     *            "description": "Combine description",
     *            "language": "en-US"
     *        },
     *        "uk-UA": {
     *            "title": "Комбайн",
     *            "description": "Опис до комбайну",
     *            "language": "uk-UA"
     *        }
     *    },
     *    "analogs": [
     *        "21",
     *        "22"
     *    ],
     *    "characteristics": [{
     *        "uk-UA": {
     *            "language": "uk-UA",
     *            "title": "Виробник",
     *            "measurement": null,
     *            "value": "ХТЗ"
     *        },
     *        "en-US": {
     *            "language": "en-US",
     *            "title": "Manufacturer",
     *            "measurement": null,
     *            "value": "HTZ"
     *        }
     *    }],
     *    "usedIn": [{
     *        "uk-UA": {
     *            "language": "uk-UA",
     *            "title": "COMMANDOR",
     *            "parent_title": "Комбайн (укр)",
     *        },
     *        "en-US": {
     *            "language": "en-US",
     *            "title": "COMMANDOR",
     *            "parent_title": "Комбайн (укр)",
     *        }
     *    }]
     * } 
     */
    public function actionUpdate($id) {
        /* @var $model ActiveRecord */
        $model = $this->findModel($id);        
        $this->processTranslations($model, Yii::$app->request->getBodyParam('translations', []));
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
       
        $this->processImages($model, Yii::$app->getRequest()->getBodyParam('images', []));
        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }
        return $model;
    }

    /**
     * @api {DELETE} /products/:id Delete Product by id
     * @apiName Delete product
     * @apiGroup Product
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
     * @apiParam {Integer} id Product id
     * @apiParamExample {curl} Call api method example:
     * DELETE http://agrod-site.32server.in.ua/api/v1/products/1 
     * @apiSuccessExample {json} Success-Response:
     *  HTTP/1.1 204 No Content    
     */
    public function actionDelete($id) {
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
        $model = Product::find()
                ->byId($id)
                ->limit(1)
                ->one();

        if (!$model) {
            throw new NotFoundHttpException;
        }
        return $model;
    }

    private function processTranslations(Product $model, Array $translations): Product {
        foreach ($translations as $language => $data) {
            foreach ($data as $attribute => $translation) {
                $model->translate($language)->$attribute = $translation;
            }
        }
        return $model;
    }

    private function processImages(Product &$model, Array $images) {

        $model->image = null;
        $model->attachments = null;
        if (!empty($images)) {

            $mainImage = array_shift($images);
            $model->image = [
                'path' => '1c/' . $mainImage,
                'name' => $mainImage,
                'base_url' => Yii::getAlias('@storageUrl') . '/source'
            ];
            foreach ($images as $oneImage) {
                $model->attachments[] = [
                    'path' => '1c/' . $oneImage,
                    'name' => $oneImage,
                    'base_url' => Yii::getAlias('@storageUrl') . '/source'
                ];
            }
        }
        
    }

}
