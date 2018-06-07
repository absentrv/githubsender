<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

/**
 * Frontend application asset
 */
class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    /**
     * @var string
     */

    /**
     * @var array
     */
    public $css = [
       
    ];

    /**
     * @var array
     */
    public $js = [
    ];

    /**
     * @var array
     */
    public $depends = [
        YiiAsset::class,
    ];
}
