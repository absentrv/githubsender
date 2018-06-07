<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ContactPerson */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Contact Person',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Contact People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-person-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
