<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ContactPerson */

$this->title = "Редагування" . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Contact People'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = "Редагування";
?>
<div class="contact-person-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
