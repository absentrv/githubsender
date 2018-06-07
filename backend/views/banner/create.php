<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\banner */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Banner',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
