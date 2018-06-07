<?php

namespace common\widgets;

use yii\bootstrap\Tabs;
use yii\bootstrap\Html;

/**
 * Description of AdminLteTab class
 *
 * @author Sergiy Filonyuk <sergiy.filonyuk@gmail.com>
 */
class AdminLteTab extends Tabs {

    public $tabContentOptions = [
        'style' => [
            'border' => '1px solid #ddd'
        ]
    ];

    public function renderItems() {
        return Html::tag('div', parent::renderItems(), ['class' => 'nav-tabs-custom']);        
    }

}
