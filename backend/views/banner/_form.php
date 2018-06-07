<?php

use common\widgets\AdminLteTab;
use trntv\filekit\widget\Upload;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model common\models\banner */
/* @var $form ActiveForm */
?>

<div class="banner-form">

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
    <?php echo $form->field($model, 'image')->widget(Upload::class, [
        'url' => ['/file-storage/upload'],
        'maxFileSize' => 5000000, // 5 MiB
    ]) ?>
    <?php echo $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? "Створити" : "Редагувати", ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
