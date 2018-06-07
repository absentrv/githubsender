<?php

use trntv\filekit\widget\Upload;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model common\models\logo */
/* @var $form ActiveForm */
?>

<div class="logo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php //echo $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'image')->widget(Upload::class, [
        'url' => ['/file-storage/upload'],
        'maxFileSize' => 5000000, // 5 MiB
    ]) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
