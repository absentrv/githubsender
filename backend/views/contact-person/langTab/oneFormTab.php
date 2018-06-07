<?php
echo $form->field($model->translate($language), "[$language]fio")->textInput()->label('ФІО');
echo $form->field($model->translate($language), "[$language]post")->textInput()->label('Посада');
?>
