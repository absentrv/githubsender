<?php

use yii\imperavi\Widget;
echo $form->field($model->translate($language), "[$language]title")->textInput();

    echo $form->field($model->translate($language), "[$language]body")->widget(Widget::className(), [
        'plugins' => ['fullscreen', 'fontcolor', 'video'],
        'options' => [
            'minHeight' => 400,
            'maxHeight' => 400,
                 'buttonSource' => true,
                'convertDivs' => false,
                'replaceDivs' => false,
                'removeEmptyTags' => false,
            'imageUpload' => Yii::$app->urlManager->createUrl(['/file-storage/upload-imperavi']),
//            'lang' => 'ua'
        ]
    ]);

?>

<div class="box box-solid box-info">
    <div class="box-header">
        <h3 class="box-title"><?= Yii::t('backend', 'Seo configuration'); ?></h3>
    </div>
    <div class="box-body">
        <?php
        echo $form->field($model->translate($language), "[$language]seo_title")->textInput();
        echo $form->field($model->translate($language), "[$language]seo_keywords")->textArea();
        echo $form->field($model->translate($language), "[$language]seo_description")->textArea();
        ?>
    </div>
</div>