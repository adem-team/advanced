<?php
use yii\helpers\Html;
//use yii\bootstrap\ActiveForm;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
?>

	<?php
		$form = ActiveForm::begin([
				'id'=>'frm-etd-proccess',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/purchasing/purchase-order/etd-save'],
		]);
	?>	
		<?php //echo  $form->field($poHeaderVal, 'eTD')->textInput()->label('ETD (Estimete Time delivery)'); ?>
		<?php echo $form->field($poHeaderVal, 'eTD')->widget(DatePicker::classname(), [
					'options' => ['placeholder' => 'Estimate Time Delivery ...'],
						'pluginOptions' => [							
							'todayHighlight' => true,
							//'todayBtn' => true,
							'format' => 'yyyy-mm-dd',
							'autoclose'=>true,
							
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

	





