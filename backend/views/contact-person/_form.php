<?php

use common\models\ContactPerson;
use common\widgets\AdminLteTab;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model ContactPerson */
/* @var $form ActiveForm */
?>

<div class="contact-person-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>
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
    <?php echo $form->field($model, 'phones')->textInput(['maxlength' => true])->label('Телефони')->hint('Якщо телефонів декілька - розділяйте їх комою ,') ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
