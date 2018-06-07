<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Зворотній зв'язок (сторінка контактів)";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feedback-index">

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name:text:Ім\'я',
            'phone:text:Телефон',
            'created_at:datetime:Додано',
            'checked:boolean:Переглянуто',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]);
    ?>
</div>
