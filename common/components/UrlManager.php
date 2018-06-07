<?php

/*
 * Добавляет указатель языка в ссылки
 */

namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;

class UrlManager extends \yii\web\UrlManager {

    public $defaultLanguage;
    /**
     * getLangApp
     * @return type
     */
    public static function getLangApp() {        
        return ArrayHelper::getValue(Yii::$app->params['localesUrls'], Yii::$app->language);
    }

    /**
     * $lang - Url локали (ru | ua ) - localesUrls
     * @param type $params
     * @return type
     */
    public function createUrl($params) {        
        if (isset($params['lang'])) {
            if (in_array($params['lang'], array_values(Yii::$app->params['localesUrls']))) {
                $lang = trim($params['lang']);
            } else {
                $lang = self::getLangApp();
            }
            unset($params['lang']);
        } else {
            $lang = self::getLangApp();
        }
        $url = parent::createUrl($params);

        return urldecode(implode('/', ['', $lang, ltrim($url, '/')]));
    }

}
