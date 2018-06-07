<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Картинки на сторінку "Про нас"';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="about-slider-index">


    <p>
        <?php echo Html::a("Додати", ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php Pjax::begin(); 
echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'common\grid\SortColumn\SortColumn'],
                [
                'attribute' => 'image',
                'format' => 'raw',
                    'label' => 'Картинка',
                'value' => function($data) {
                    return Html::img($data->originalImage, [
                                'alt' => $data->title,
                                'style' => 'width:100px;'
                    ]);
                },
            ],
            'title:text:Назва',
            'visible:boolean:Видимий',
                [
                    'class' => 'common\grid\ActionColumn',
                    'template' => '{update} {delete}'
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?></div>
