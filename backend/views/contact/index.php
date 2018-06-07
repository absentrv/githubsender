<?php

use yii\bootstrap\Html;
use yii\bootstrap\Tabs;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $dataProvider ActiveDataProvider */

$this->title = "Контактна інформація";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-index">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'phones')->textInput()->hint('Якщо телефонів декілька - розділяйте їх комою ,'); 
    echo $form->field($model, 'email')->textInput();
    $tabs = [];
    foreach (Yii::$app->params['availableLocales'] as $lang => $name):
        $tabs[] = [
            'content' => $this->render('langTab/oneLang', ['language' => $lang, 'model' => $model, 'form' => $form]),
            'label' => $name
        ];
    endforeach;
    ?>
    <div class="nav-tabs-custom">
        <?php
        echo Tabs::widget([
            'items' => $tabs,
            'tabContentOptions' => [
                'style' => [
                    'border' => '1px solid #ddd'
                ]
            ]
        ]);
        ?>
    </div>
    <?= Html::submitButton("Зберегти", ['class' => 'btn btn-primary btn-block']);
    ActiveForm::end();
?>

</div>
