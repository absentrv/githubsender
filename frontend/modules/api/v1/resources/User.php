<?php

namespace frontend\modules\api\v1\resources;

use common\models\User as BaseUser;
use yii\helpers\Url;

/**
 * @author Serhii Filoniuk
 */
class User extends BaseUser
{
    public function fields()
    {
        return [
            'id',            
            'originalImage' => function() {
                return $this->image ? Url::home() . $this->image: null;
            },
            'access_token',
            'email',
            'thumbnail' => function() {
                return $this->image_thumbnail ? Url::home(). $this->image_thumbnail : null;
            },
        ];
    }
    
}
