<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
?>

	<?php
		$form = ActiveForm::begin([
				'id'=>'frm-spl-proccess',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/purchasing/purchase-order/supplier-save'],
		]);
	?>	
		<?php echo  $form->field($poHeaderVal, 'kD_SUPPLIER')->textInput()->label('Supplier'); ?>
		<?php echo  $form->field($poHeaderVal, 'kD_PO')->hiddenInput(['value'=>$poHeader->KD_PO,'maxlength' => true, 'readonly' => true])->label(false); ?>		
		<div style="text-align: right;"">
			<?php echo Html::submitButton('simpan',['class' => 'btn btn-primary']); ?>
		</div>

    
	<?php ActiveForm::end(); ?>	

	





