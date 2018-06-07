<?php

use common\models\AboutSlider;
use trntv\filekit\widget\Upload;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model AboutSlider */
/* @var $form ActiveForm */
?>

<div class="about-slider-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    
    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
     <?php echo $form->field($model, 'image')->widget(Upload::class, [
        'url' => ['/file-storage/upload'],
        'maxFileSize' => 5000000, // 5 MiB
    ]) ?>
    <?php echo $form->field($model, 'visible')->checkbox() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Створити' : 'Редагувати', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
