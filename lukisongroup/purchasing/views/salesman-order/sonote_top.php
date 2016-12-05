<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use dosamigos\ckeditor\CKEditor;

	$arrayTopType= [
		  ['top' => 0, 'topNm' => 'Cash In Advance'],		  
		  ['top' => 1, 'topNm' => 'Cash on Delivey'],
		  ['top' => 2, 'topNm' => 'Credit']
	];	
	$valTopType = ArrayHelper::map($arrayTopType, 'topNm', 'topNm');
	
	$arrayTOP= [
		  ['top' => 0, 'topNm' => '7 Days'],		  
		  ['top' => 1, 'topNm' => '14 Days'],
		  ['top' => 2, 'topNm' => '30 Days'],
		  ['top' => 3, 'topNm' => '45 Days'],
		  ['top' => 4, 'topNm' => '60 Days'],
		  ['top' => 5, 'topNm' => '90 Days']
	];	
	$valTop = ArrayHelper::map($arrayTOP, 'topNm', 'topNm');
?>

<div class="purchaseorder-form">
     <?php $form = ActiveForm::begin([
			'id'=>$model->formName(),
			'enableClientValidation' => true,
			//'enableAjaxValidation' => true,
		]);
	?>

 <?= $form->field($model, 'ID')->hiddenInput(['value'=>$model->ID,'maxlength' => true,'readonly'=>true])->label(false) ?>
 
	<?= $form->field($model, 'TOP_TYPE')->dropDownList($valTopType,[
			'id'=>'purchaseorder-top_type',
			'promt' =>'Term Of Payment',
		])->label('Type Of Payment');?>
	
	<div id="top-note">

	 	<?= $form->field($model, 'TOP_DURATION')->dropDownList($valTop,[
			'placeholder' =>'Term Of Payment',
			//'style'=>'display: none'
		])->label('Duration Of Payment');?>
		
	</div>
  
	
	
    <div style="text-align: right;"">
		<?php echo Html::submitButton('Save',['class' => 'btn btn-primary']); ?>
	</div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs("
	$('select#purchaseorder-top_type').change(function(){
		 var val = $(this).val(); 
		//alert(val);	 
		if(val === 'Credit')
		{
			$('#top-note').show();
		}else{
			$('#top-note').hide();
		}
	});
",$this::POS_READY);
?>
