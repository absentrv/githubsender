<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Коментарі до товарів';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">


<?php Pjax::begin(); 
echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
//          
            'product.title:text:Назва товару',
            'rating:text:Рейтинг',
            'name:text:Ім\'я',
            'email:email',
             'text:ntext',
             'created_at:date:Додано',
             'visible:boolean:Видимий',
             'checked:boolean:Переглянутий',

                [
                    'class' => 'common\grid\ActionColumn',
                    'template' => '{update} {delete}'
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?></div>
