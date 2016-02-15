<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\label\LabelInPlace;
use kartik\money\MaskMoney;

$config = ['template'=>"{input}\n{error}\n{hint}"];

 ?>

<?php
$form = ActiveForm::begin([
  'id'=>$model->formName(),

]);
 ?>

  <?= $form->field($model, 'TARGET_TEXT', $config)->widget(LabelInPlace::classname())?>

  <?= $form->field($model, 'TARGET_VALUE')->widget(MaskMoney::classname(), [
    'pluginOptions' => [
        'prefix' => 'RP ',
        'allowNegative' => false
    ]
]) ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
