<?php

use backend\models\search\PageSearch;
use common\models\Page;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel PageSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = "Сторінки";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
        echo Html::a("Створити сторінку", ['create'], ['class' => 'btn btn-success'])
        ?>
    </p>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'columns' => [
            [
                'class' => 'common\grid\SortColumn\SortColumn'
            ],
            'title:text:Заголовок',
            [
                'class' => '\common\grid\EnumColumn',
                'attribute' => 'status',
                'enum' => Page::getStatuses() // [0=>'Deleted', 1=>'Active']
            ],
            [
                'class' => 'common\grid\ActionColumn',
                'template' => '{update} {delete}',
                'visibleButtons' => [
                    'delete' => function($model) {
                        return $model->static == 0;
                    }
                ]
            ],
        ],
    ]);
    ?>

</div>
