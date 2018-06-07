<?php

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */

$this->title = "Банери";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-index">


    <p>
        <?php
        echo Html::a("Додати банер", ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'common\grid\SortColumn\SortColumn'],
            [
                'attribute' => 'image',
                'label' => 'Картинка',
                'format' => 'raw',
                'value' => function($data) {
                    return Html::img($data->originalImage, [
                                'alt' => $data->title,
                                'style' => 'width:100px;'
                    ]);
                },
            ],
            'title:text:Назва',
            'status:boolean:Видимий',
            [
                'class' => 'common\grid\ActionColumn',
                'template'=>'{update} {delete}',                
            ],
        ],
    ]);
    ?>

</div>
