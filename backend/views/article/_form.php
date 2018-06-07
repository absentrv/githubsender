<?php

use common\models\Article;
use common\models\ArticleCategory;
use common\widgets\AdminLteTab;
use trntv\filekit\widget\Upload;
use trntv\yii\datetime\DateTimeWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Article */
/* @var $categories ArticleCategory[] */
/* @var $form ActiveForm */
?>

<div class="article-form">

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
        
        
        <?php echo $form->field($model, 'slug')
        ->hint("Якщо Ви залишите це поле пустим, воно згенеруютсья автоматично")
        ->textInput(['maxlength' => true]) ?>


   
    <?php echo $form->field($model, 'thumbnail')->widget(
        Upload::className(),
        [
            'url' => ['/file-storage/upload'],
            'maxFileSize' => 5000000, // 5 MiB
        ]);
    ?>

    <?php /*echo $form->field($model, 'attachments')->widget(
        Upload::className(),
        [
            'url' => ['/file-storage/upload'],
            'sortable' => true,
            'maxFileSize' => 10000000, // 10 MiB
            'maxNumberOfFiles' => 10
        ]); */
    ?>

    <?php echo $form->field($model, 'status')->checkbox() ?>    

    <div class="form-group">
        <?php echo Html::submitButton(
            $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
