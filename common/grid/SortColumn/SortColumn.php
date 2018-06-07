<?php

namespace common\grid\SortColumn;

use common\grid\SortColumn\assets\SortAsset;
use yii\grid\Column;
use yii\helpers\Html;
use yii\web\View;

class SortColumn extends Column {

    public $header = '<i class="fa fa-arrows-v"></i>';
    public $headerOptions = ['style' => ['width' => '30px;', 'text-align' => 'center']];

    public function init() {
        SortAsset::register($this->grid->view);
        $this->grid->view->registerJs("InitRow('{$this->grid->id}');", View::POS_READY);
    }

    protected function renderDataCellContent($model, $key, $index) {
        return Html::tag('div', '&#9776;', [
                    'class' => 'sortable-widget-handler',
                    'data-id' => $model->id,
        ]);
    }

}
