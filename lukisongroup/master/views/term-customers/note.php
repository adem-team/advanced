<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;



 ?>

<?php
$form = ActiveForm::begin([
  'id'=>$model->formName(),
  'enableClientValidation' => true,

]);
 ?>

 <?= $form->field($model, 'KETERANGAN')->widget(CKEditor::className(), [
     'options' => ['rows' => 6],
     'preset' => 'basic'
 ]) ?>


<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
