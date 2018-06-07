<?php

use common\models\Comment;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Comment */
/* @var $form ActiveForm */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>


    
    <?php echo $form->field($model, 'product_id')->textInput(['disabled' => 'disabled', 'value' => $model->product->title]) ?>
    <?php echo $form->field($model, 'rating')->textInput(['type' => 'number', 'max' => 5, 'min' => 1]) ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'visible')->checkbox() ?>

    <?php echo $form->field($model, 'checked')->checkbox() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
