<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = "Редагування" . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => "Статичні сторінки", 'url' => ['index']];
$this->params['breadcrumbs'][] = "Редагування";
?>
<div class="page-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
