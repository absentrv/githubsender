<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\logo */

$this->title = "Редагування". ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => "Логотипи", 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Редагування";
?>
<div class="logo-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
