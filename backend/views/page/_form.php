<?php

use common\models\Page;
use common\widgets\AdminLteTab;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Page */
/* @var $form ActiveForm */
?>

<div class="page-form">

   <?php $form = ActiveForm::begin(); ?>
    <?php
    $items = [];
    foreach (Yii::$app->params['availableLocales'] as $key => $value) {
        $items[] = [
            'label' => $value,
            'content' => $this->render('langTab/oneFormTab', ['language' => $key, 'model' => $model, 'form' => $form])
        ];
    }
    echo AdminLteTab::widget(['items' => $items]);
    ?>

    <?php echo $form->field($model, 'slug')->textInput(['maxlength' => true, 'readonly' => $model->static]) ?>

    <?php echo $form->field($model, 'status')->radioList(Page::getStatuses()) ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
