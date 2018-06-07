<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */

$this->title = 'Update Comment: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="comment-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
