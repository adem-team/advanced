<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Kategoricus */
/* @var $form yii\widgets\ActiveForm */


?>





<div class="kategoricus-form">

    <?php $form = ActiveForm::begin([
	  'id'=>$model->formName(),
      'enableClientValidation' => true,
      'enableAjaxValidation'=>true,
      'validationUrl'=>Url::toRoute('/master/customers-kategori/valid')

	]); ?>


    <?=  $form->field($model, 'parentnama')->checkbox() ?>

    <?= $form->field($model, 'CUST_KTG_NM')->textInput(['maxlength' => true])->label('Nama Parent') ?>

      <div id="grp">
      <?php
  echo $form->field($model, 'CUST_KTG_PARENT')->widget(Select2::classname(), [
         'data' => $parent,
        'options' => [
        'placeholder' => 'Pilih Parent ...'],
        'pluginOptions' => [
            'allowClear' => true
             ],

    ]);
    ?>
  </div>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs("


$('#kategoricus-parentnama').click(function(){
 var checkedValue = $('#kategoricus-parentnama:checked').val();

  if(checkedValue == 1)
  {
    $('#grp').hide();
  }
  else
  {
      $('#grp').show();
  }

});


 ",$this::POS_READY);
