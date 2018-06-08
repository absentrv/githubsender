<?php
namespace frontend\modules\api\v1\controllers;

use frontend\modules\api\v1\models\LoginForm;
use frontend\modules\api\v1\models\SendMessageModel;
use frontend\modules\api\v1\resources\User;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\rest\Controller;
use yii\web\Response;

/**
 * Description of UserController
 *
 * @author Sergiy Filonyuk
 */
class UserController extends Controller
{

    /**
     * @var string
     */
    public $modelClass = 'frontend\modules\api\v1\resources\User';

    public function actions()
    {
        return [
            'options' => \yii\rest\OptionsAction::class
        ];
    }

    /**
     * @var array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON
        ];
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['send-message']
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'sign-up' => ['post'],
                'sign-in' => ['post'],
                'send-message' => ['post'],
            ]
        ];
        $behaviors['rateLimiter']['enableRateLimitHeaders'] = true;
        return $behaviors;
    }

    /**
     * @api {post} /users/sign-up Sign up for user
     * @apiPermission none
     * @apiName Sign up user
     * @apiGroup User Authorization
     * @apiVersion 1.0.0
     *
     * @apiHeader {String} Content-Type application/json
     * @apiHeaderExample {json} Header-Example:
     *  {
     *      "Content-Type": "application/json"
     *  }
     * 
     * @apiParam {String} email User e-mail
     * @apiParam {String} password User password
     * @apiParam {String} image User avatar encoded as base64
     * @apiParamExample {json} Request-Example:
     * {
     *   "email": "test@test.com",
     *   "password": "secredPassword123",
     *   "avatar": "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMEAAAEFAA...",
     * }
     * 
     * @apiSuccess {String} success Returns result of api result
     * @apiSuccess {Object} data Created User data
     * @apiSuccess {String} data.access_token User token
     * @apiSuccess {String} data.thumbnail User avatar thumbnail path
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 201 Created
     * {
     *    "success": true,
     *    "data": {
     *        "access_token": "P7hoG41F-sIoIyGK_TcgRvIAy4pjcSr6ljJDEiZX",
     *        "thumbnail": "http://gitsender.local/images/uploads/thumbnail_5b1a34af28b33.png"
     *    }
     * }
     * 
     * @apiError Data validation errors 
     * @apiErrorExample {json} Data-Validation-Error-Response:
     * HTTP/1.1 422 Data Validation Failed.
     * {
     *  "success": false,
     *  "data": [
     *      {
     *          "field": "password",
     *          "message": "Password cannot be blank."
     *      },
     *      {
     *          "field": "email",
     *          "message: "E-mail \"test@test.ua\" has already been taken"
     *      }
     *  ]
     * }
     *      
     */
    public function actionSignUp()
    {
        $user = new User();
        if ($user->load(Yii::$app->request->getBodyParams(), '') && $user->validate()) {
            $user->register();
            Yii::$app->getResponse()->setStatusCode(201);
            return [
                'access_token' => $user->access_token,
                'thumbnail' => $user->image_thumbnail ? Url::home() . $user->image_thumbnail : null
            ];
        }
        return $user;
    }

    /**
     * @api {post} /users/sign-in Sign in for registered user
     * @apiPermission none
     * @apiName Sign in user
     * @apiGroup User Authorization
     * @apiVersion 1.0.0
     *
     * @apiHeader {String} Content-Type application/json
     * @apiHeaderExample {json} Header-Example:
     *  {
     *      "Content-Type": "application/json"
     *  }
     * 
     * @apiParam {String} email User e-mail
     * @apiParam {String} password User password     
     * @apiParamExample {json} Request-Example:
     * {
     *   "email": "test@test.com",
     *   "password": "secredPassword123",
     * }
     * 
     * @apiSuccess {String} success Returns result of api result
     * @apiSuccess {Object} data Created User data
     * @apiSuccess {Number} data.id User's id
     * @apiSuccess {String} data.original_image User's original avatar path
     * @apiSuccess {String} data.thumbnail User's avatar thumbnail path
     * @apiSuccess {String} data.access_token User's token to access api
     * @apiSuccess {String} data.email User's email
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "success": true,
     *    "data": {
     *        "id": 43,
     *        "originalImage": "http://gitsender.local/images/uploads/5b1a34af28b33.png",
     *        "access_token": "XSFb0Q10epQdIf9W1YgtzXUoaunkUpK9QXnPLKhj",
     *        "email": "test@test.ua",
     *        "thumbnail": "http://gitsender.local/images/uploads/thumbnail_5b1a34af28b33.png"
     *    }
     * }
     * 
     * @apiError Data validation errors 
     * @apiErrorExample {json} Data-Validation-Error-Response:
     * HTTP/1.1 422 Data Validation Failed.
     * {
     *  "success": false,
     *  "data": [
     *      {
     *          "field": "password",
     *          "message": "Password cannot be blank."
     *      },
     *      {
     *          "field": "password",
     *          "message": "Incorrect email or password."
     *      }
     *  ]
     * }
     *      
     */
    public function actionSignIn()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
            $user = $model->user;
            $user->refreshToken();
            $model = $user;
        }
        return $model;
    }

    /**
     * @api {post} /users/send-message Send messages to github users
     * @apiPermission logged user
     * @apiName Send message
     * @apiGroup User Actions
     * @apiVersion 1.0.0
     *
     * @apiHeader {String} Content-Type application/json
     * @apiHeader {String} Authorization Uses BearerAuth
     * @apiHeaderExample {json} Header-Example:
     *  {
     *      "Content-Type": "application/json",
     *      "Authorization": "Bearer jVPxD-xmHH7OWWNP_jwpTKG_RUEdeSaz3jETF-xi"
     *  }
     * 
     * @apiParam {String} message Email message for users which will be sended
     * @apiParam {Object} users Array of usernames from github.com
     * @apiParam {String} users[] First username
     * @apiParam {String} users[] Sedond username
     * @apiParam {String} users[] N-.. username
     * @apiParamExample {json} Request-Example:
     * {
     *   "message": "Hello my dear developers!",
     *   "users": ["samdark", "absentrv"],
     * }
     * 
     * @apiSuccess {String} success Returns result of api result
     * @apiSuccess {Object} data Returned api data (for this method empty array is normal)
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * {
     *    "success": true,
     *    "data": []
     * }
     * 
     * @apiError Data validation errors 
     * @apiErrorExample {json} Data-Validation-Error-Response:
     * HTTP/1.1 422 Data Validation Failed.
     * {
     *  "success": false,
     *  "data": [
     *    {
     *        "field": "message",
     *        "message": "Message cannot be blank."
     *    },
     *    {
     *        "field": "users",
     *        "message": "Users cannot be blank."
     *    }
     *  ]
     * }
     *      
     */
    public function actionSendMessage()
    {
        $model = new SendMessageModel();
        if ($model->load(Yii::$app->request->getBodyParams(), '') && $model->validate()) {
            $model->sendLetters();
        }

        if ($model->hasErrors()) {
            return $model;
        }
    }
}
