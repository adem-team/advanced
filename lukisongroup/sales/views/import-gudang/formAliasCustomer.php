<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
?>

	<?php
		$form = ActiveForm::begin([
				'type' => ActiveForm::TYPE_HORIZONTAL,
				'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
				'id'=>'alias-customer',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/sales/import-gudang/alias_cust_save'],
		]);
		//print_r($test);
	?>	
		<?php echo  $form->field($AliasCustomer, 'nM_CUST_ALIAS')->textInput([
						'value' =>$tempDataImport->CUST_NM_ALIAS,
						'maxlength' => true, 
						'readonly' => true
					])->label('Customer :'); ?>
		<?php echo  $form->field($AliasCustomer, 'kD_CUST_ALIAS')->textInput([
						'value' =>$tempDataImport->CUST_KD_ALIAS ,
						'maxlength' => true, 
						'readonly' => true
					])->label('Customer.ID :'); 
		?>		
		<?php echo  $form->field($AliasCustomer, 'kD_REF')->textInput([
						'value' =>$tempDataImport->DIS_REF ,
						'maxlength' => true, 
						'readonly' => true
					])->label('Distribution'); 
		?>
		<?php echo  $form->field($AliasCustomer, 'kD_REF_NM')->textInput([
						'value' =>$tempDataImport->DIS_REF_NM ,
						'maxlength' => true, 
						'readonly' => true
					])->label('Distribution'); 
		?>
		<?php echo $form->field($AliasCustomer, 'kD_CUST')->widget(Select2::classname(), [
					'data' => $aryCustID,
					'options' => ['placeholder' => 'Search  Customer ...'],
					'pluginOptions' => [
						'allowClear' => true
					 ],
				])->label('Own Customer');
		?>
		<div style="text-align: right;"">
			<?php echo Html::submitButton('Sync Alias Customer',['class' => 'btn btn-primary']); ?>
		</div>    
<?php ActiveForm::end(); ?>	

	





