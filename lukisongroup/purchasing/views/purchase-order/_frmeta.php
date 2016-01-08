<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
?>

	<?php
		$form = ActiveForm::begin([
				'id'=>'frm-eta-proccess',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/purchasing/purchase-order/eta-save'],
		]);
	?>	
		<?php //echo  $form->field($poHeaderVal, 'eTA')->textInput()->label('ETA (Estimete Time Arriver)'); ?>
		<?php echo $form->field($poHeaderVal, 'eTA')->widget(DatePicker::classname(), [
					'options' => ['placeholder' => 'Estimate Time Arrival ...'],
						'pluginOptions' => [
							'todayHighlight' => true,
							'autoclose'=>true
						],
						'pluginEvents'=>[
							'show' => "function(e) {show}",
						],
					]);
		?>
		<?php echo  $form->field($poHeaderVal, 'kD_PO')->hiddenInput(['value'=>$poHeader->KD_PO,'maxlength' => true, 'readonly' => true])->label(false); ?>		
		<div style="text-align: right;"">
			<?php echo Html::submitButton('simpan',['class' => 'btn btn-primary']); ?>
		</div>

    
	<?php ActiveForm::end(); ?>	

	





