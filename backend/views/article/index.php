<?php

use backend\models\search\ArticleSearch;
use common\grid\EnumColumn;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel ArticleSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = "Статті";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(
            "Додати статтю",
            ['create'],
            ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'columns' => [

//            'id',
            'title:text:Назва',                       
            [
                'class' => EnumColumn::className(),
                'attribute' => 'status',
                'enum' => [
                    Yii::t('backend', 'Not Published'),
                    Yii::t('backend', 'Published')
                ],
                'label' => 'Статус'
            ],
            'created_at:datetime:Створена',

            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ]
        ]
    ]); ?>
</div>
