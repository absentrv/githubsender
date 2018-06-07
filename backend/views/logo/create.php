<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\logo */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Logo',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Logos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="logo-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
