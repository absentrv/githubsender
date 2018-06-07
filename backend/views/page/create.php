<?php
/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = "Створення сторінки";
$this->params['breadcrumbs'][] = ['label' => 'Статичні сторінки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
