
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use lukisongroup\master\models\Terminvest;
use kartik\money\MaskMoney;
use yii\helpers\Url;
use kartik\label\LabelInPlace;
use kartik\checkbox\CheckboxX;


$data1 = Terminvest::find()->all();
$to1 = "ID";
$from1 = "INVES_TYPE";

$config = ['template'=>"{input}\n{error}\n{hint}"];

?>

<?php
$form = ActiveForm::begin([
  'id'=>$budget->formName(),
  'enableClientValidation' => true,
  'enableAjaxValidation'=>true,
  'validationUrl'=>Url::toRoute('/master/term-customers/valid-inves')
]);
 ?>

 <?= $form->field($budget, 'ID_TERM')->hiddenInput(['value' => $id])->label(false)?>

<?= $form->field($budget, 'INVES_TYPE')->widget(Select2::classname(),[
  'options'=>[  'placeholder' => 'Select Type Investasi ...'
  ],
  'data' =>$budget->data($data1,$to1,$from1)
]);?>

<?= $form->field($budget, 'PERIODE_START')->widget(DatePicker::classname(), [
'options' => ['placeholder' => 'Dari  ...'],
'pluginOptions' => [
   'autoclose'=>true,
   'format' => 'dd-mm-yyyy',
],
'pluginEvents'=>[
       'show' => "function(e) {errror}",
           ],

])  ?>

<?= $form->field($budget, 'PERIODE_END')->widget(DatePicker::classname(), [
'options' => ['placeholder' => 'Sampai'],
'pluginOptions' => [
   'autoclose'=>true,
   'format' => 'dd-mm-yyyy',
],
'pluginEvents'=>[
       'show' => "function(e) {error}",
           ],
])  ?>

<?= $form->field($budget, 'PROGRAM')->textArea([
  'options'=>['rows'=>5]
]) ?>

<?= $form->field($budget, 'BUDGET_PLAN')->widget(MaskMoney::classname(), [
  'pluginOptions' => [
      'prefix' => 'Rp',
     'precision' => 2,
      'allowNegative' => false
  ]
]) ?>



<div class="form-group">
    <?= Html::submitButton($budget->isNewRecord ? 'Create' : 'Update', ['class' => $budget->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
