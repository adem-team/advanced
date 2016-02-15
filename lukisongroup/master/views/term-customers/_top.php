<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\label\LabelInPlace;

$config = ['template'=>"{input}\n{error}\n{hint}"];
 ?>

<?php
$form = ActiveForm::begin([
  'id'=>$model->formName(),

]);
 ?>

  <?= $form->field($model, 'TOP', $config)->widget(LabelInPlace::classname())?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
