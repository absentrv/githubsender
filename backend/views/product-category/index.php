<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Product Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-index">


<?php Pjax::begin(); ?>            <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                'attribute' => 'id',
                'headerOptions' => ['style' => ['width' => '50px;', 'text-align' => 'center']]
            ],          
            'title:text:Назва',
            'parent.title:text:Батьківська категорія',
            'visible:boolean:Видимий',
             '1c_id:text:1С ідентифікатор',
//
//                [
//                    'class' => 'common\grid\ActionColumn',
//                    'template' => '{update} {delete}'
//                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?></div>
