<?php

namespace common\grid\SortColumn\assets;

/* 32x32
 * All Right Reserved
 * author: Max Vaskevych
 * email: Vaskevych@gmail.com
 * Created in NetBeans IDE 8.2
 */

use yii\web\AssetBundle;

class SortAsset extends AssetBundle {
    public $sourcePath = __DIR__;
    public $js = [
        'js/RowSorter.js',
    ];
    public $css = [
        'css/GridSorter.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
