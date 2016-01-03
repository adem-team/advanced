<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
?>

	<?php
		$form = ActiveForm::begin([
				'id'=>'frm-delivery-proccess',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/purchasing/purchase-order/delivery-save'],
		]);
	?>	
		<?php echo  $form->field($poHeaderVal, 'dELIVERY')->textInput()->label('Delevery Cost'); ?>
		<?php echo  $form->field($poHeaderVal, 'kD_PO')->hiddenInput(['value'=>$poHeader->KD_PO,'maxlength' => true, 'readonly' => true])->label(false); ?>		
		<div style="text-align: right;"">
			<?php echo Html::submitButton('simpan',['class' => 'btn btn-primary']); ?>
		</div>

    
	<?php ActiveForm::end(); ?>	

	





