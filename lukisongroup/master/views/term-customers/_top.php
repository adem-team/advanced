<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;


$arrayTopType= [
    ['top' => 0, 'topNm' => 'Potong Tagihan'],
    ['top' => 1, 'topNm' => 'Transfer'],
];
$valTopType = ArrayHelper::map($arrayTopType, 'topNm', 'topNm');

$arrayTOP= [
    ['top' => 0, 'topNm' => 'Jatuh Tempo 7 Days'],
    ['top' => 1, 'topNm' => 'Jatuh Tempo 14 Days'],
    ['top' => 2, 'topNm' => 'Jatuh Tempo 30 Days'],
    ['top' => 3, 'topNm' => 'Jatuh Tempo 45 Days'],
    ['top' => 4, 'topNm' => 'Jatuh Tempo 60 Days'],
    ['top' => 5, 'topNm' => 'Jatuh Tempo 90 Days']
];
$valTop = ArrayHelper::map($arrayTOP, 'topNm', 'topNm');
 ?>

<?php
$form = ActiveForm::begin([
  'id'=>$model->formName(),

]);
 ?>
<?=  $form->field($model, 'term')->widget(Select2::classname(), [
    'data' => $valTopType,
    'options' => ['placeholder' => 'Pilih Metode Pembayaran...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]) ?>
<div id="slect">
<?=  $form->field($model, 'TOP')->widget(Select2::classname(), [
    'data' => $valTop,
    'options' => ['placeholder' => 'Jatuh Tempo...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]) ?>

</div>

    <!-- $form->field($model, 'TOP', $config)->widget(LabelInPlace::classname())?> -->


<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
<?php
$this->registerJs('
$("#termcustomers-term").change(function(){
  var data = $(this).val()
  if(data == "Potong Tagihan")
  {
    $("#slect").hide();
  }
  else{
      $("#slect").show();
  }

})

',$this::POS_READY);


 ?>
