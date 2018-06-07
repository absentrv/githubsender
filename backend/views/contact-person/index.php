<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Контакти працівників";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-person-index">


    <p>
        <?php echo Html::a("Додати працівника", ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'common\grid\SortColumn\SortColumn'],
            'fio:text:ФІО',
            'phones:text:Телефони',
            'post:text:Посада',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
                ],
        ],
    ]); ?>

</div>
