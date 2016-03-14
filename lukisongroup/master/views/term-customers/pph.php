<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\checkbox\CheckboxX;

$data = [2=>'2 persen',
          4=>'4 persen ',
          10=>'10 persen',
          15=>'15 persen'

      ]

 ?>

<?php
$form = ActiveForm::begin([
  'id'=>$Model->formName(),

]);
 ?>

 <?php
 echo '<label class="cbx-label" for="s_1"> Is Pph 23 </label>';
 echo CheckboxX::widget([
     'name'=>'pph',
     'value'=>0,
     'options'=>['id'=>'s_1'],
     'pluginOptions'=>['threeState'=>false]
 ]);


  ?>
<div id="pph23">
<?= $form->field($Model, 'PPH23')->widget(Select2::classname(), [
     'data' => $data,
     'options' => ['placeholder' => 'Pilih Percentage ...'],
     'pluginOptions' => [
       'allowClear' => true
     ],
 ])?>
 </div>

<div class="form-group">
    <?= Html::submitButton($Model->isNewRecord ? 'Create' : 'Update', ['class' => $Model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php
$this->registerJs('
$("#s_1").change(function(){
var val = $("#s_1").val();
if(val == "1")
{
  $("#pph23").hide();
}
else{
    $("#pph23").show();
}

})

',$this::POS_READY);

?>
