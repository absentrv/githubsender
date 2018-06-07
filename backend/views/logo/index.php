<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Логотипи');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logo-index">


    <p>
        <?php echo Html::a('Додати', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'common\grid\SortColumn\SortColumn'],
            [
                'attribute' => 'image', 
                'format' => 'raw',
                'label'  => 'Картинка',
                'value' => function($model) {
                    return \yii\bootstrap\Html::img($model->originalImage, [
                        'alt' => $model->link,
                        'style' => 'width: 64px',
                        
                    ]);
                }
            ],
            [
                'class' => 'common\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>

</div>
