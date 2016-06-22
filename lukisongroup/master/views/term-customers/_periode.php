<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\Url;

 ?>

<?php
$form = ActiveForm::begin([
  'id'=>$model->formName(),
  'enableClientValidation' => true,
  'enableAjaxValidation'=>true,
  'validationUrl'=>Url::toRoute('/master/term-customers/valid')
]);
 ?>

<?= $form->field($model, 'PERIOD_START')->widget(DatePicker::classname(), [
'options' => ['placeholder' => 'Dari  ...'],
'pluginOptions' => [
   'autoclose'=>true,
    'value' => '01/29/2014',
   'format' => 'dd-mm-yyyy',
],

'pluginEvents'=>[
       'show' => "function(e) {errror}",
           ],

])  ?>

<?= $form->field($model, 'PERIOD_END')->widget(DatePicker::classname(), [
'options' => ['placeholder' => 'Sampai'],
'pluginOptions' => [
   'autoclose'=>true,
   'format' => 'dd-mm-yyyy',
],

'pluginEvents'=>[
       'show' => "function(e) {error}",
           ],
])  ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
