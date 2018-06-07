<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GlideHelper
 *
 * @author www
 */

namespace common\components\glide;

use Yii;

class GlideHelper {

    public function createImage($path, $options = []) {
        return Yii::$app->glide->createSignedUrl(array_merge([
                    'glide/index',
                    'path' => $path,
                                ], $options), true);

//        $imgurl = Yii::$app->urlManagerStorage->createAbsoluteUrl(array_merge([
//            'glide/index',
//            'path' => $path,
//                        ], $options));
//        return Yii::$app->glide->signUrl($imgurl);
    }

}
