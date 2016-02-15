
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use lukisongroup\master\models\Terminvest;
use kartik\money\MaskMoney;
use yii\helpers\Url;

$data = Terminvest::find()->all();
$to = "INVES_TYPE";
$from = "INVES_TYPE";


?>

<?php
$form = ActiveForm::begin([
  'id'=>$budget->formName(),
  'enableClientValidation' => true,
  'enableAjaxValidation'=>true,
  'validationUrl'=>Url::toRoute('/master/term-customers/valid-inves')
]);
 ?>

 <!-- $form->field($budget, 'ID_TERM')->textInput(['value' => $id,'readonly'=>true]) -->

<?= $form->field($budget, 'INVES_TYPE')->widget(Select2::classname(),[
  'options'=>[  'placeholder' => 'Select Type Investasi ...'
  ],
  'data' =>$budget->data($data,$to,$from)
]);?>

<?= $form->field($budget, 'PERIODE_START')->widget(DatePicker::classname(), [
'options' => ['placeholder' => 'Dari  ...'],
'pluginOptions' => [
   'autoclose'=>true
],
'pluginEvents'=>[
       'show' => "function(e) {errror}",
           ],

])  ?>

<?= $form->field($budget, 'PERIODE_END')->widget(DatePicker::classname(), [
'options' => ['placeholder' => 'Sampai'],
'pluginOptions' => [
   'autoclose'=>true
],
'pluginEvents'=>[
       'show' => "function(e) {error}",
           ],
])  ?>
<?= $form->field($budget, 'BUDGET_VALUE')->widget(MaskMoney::classname(), [
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
