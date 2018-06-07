<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AboutSlider */

$this->title = 'Додавання картинки';
$this->params['breadcrumbs'][] = ['label' => 'Картинки на сторінку "Про нас"', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="about-slider-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
