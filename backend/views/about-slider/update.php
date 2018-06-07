<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AboutSlider */

$this->title = 'Редагування: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Картинки на сторінку "Про нас"', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="about-slider-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
