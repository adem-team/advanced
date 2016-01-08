<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

use lukisongroup\master\models\Nmperusahaan;
$addressCorp = ArrayHelper::map(Nmperusahaan::find()->orderBy('NM_ALAMAT')->all(), 'ID', 'NM_ALAMAT');
?>

	<?php
		$form = ActiveForm::begin([
				'id'=>'frm-bil-proccess',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/purchasing/purchase-order/billing-save'],
		]);
	?>	
		<?php //echo  $form->field($poHeaderVal, 'bILLING')->textInput()->label('Billing'); 
			  echo $form->field($poHeaderVal, 'bILLING')->widget(Select2::classname(), [
					'data' => $addressCorp,
					'options' => ['placeholder' => 'Select Address for Billing ...'],
					'pluginOptions' => [
						'allowClear' => true
					],
			]);
		?>
		<?php echo  $form->field($poHeaderVal, 'kD_PO')->hiddenInput(['value'=>$poHeader->KD_PO,'maxlength' => true, 'readonly' => true])->label(false); ?>		
		<div style="text-align: right;"">
			<?php echo Html::submitButton('simpan',['class' => 'btn btn-primary']); ?>
		</div>
    
	<?php ActiveForm::end(); ?>	

	





