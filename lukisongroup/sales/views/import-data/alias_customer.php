<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
?>

	<?php
		$form = ActiveForm::begin([
				'id'=>'alias-customer',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/sales/import-data/alias_cust_save'],
		]);
		print_r($test);
	?>	
		
		<?php echo  $form->field($aliasCodeCustomer, 'kD_CUST_ALIAS')->textInput([
						'value' =>$tempDataImport->CUST_KD_ALIAS ,
						'maxlength' => true, 
						'readonly' => true
					])->label('Alias.ID Customer'); ?>
		<?php echo  $form->field($aliasCodeCustomer, 'nM_CUST_ALIAS')->textInput([
						'value' =>$tempDataImport->CUST_NM_ALIAS,
						'maxlength' => true, 
						'readonly' => true
					])->label('Customer Alias'); ?>
		<?php echo $form->field($aliasCodeCustomer, 'kD_CUST')->widget(Select2::classname(), [
					'data' => $aryCustID,
					'options' => ['placeholder' => 'Search  Customer ...'],
					'pluginOptions' => [
						'allowClear' => true
					 ],
				])->label('Customer');
		?>
		<?php 
		// echo $form->field($aliasCodeCustomer, 'kD_DIST')->hiddenInput([
					// 'value' =>$tempDataImport->KD_DISTRIBUTOR ,
					// 'maxlength' => true, 
					// 'readonly' => true
				// ])->label(false);
		// ?>
		<div style="text-align: right;"">
			<?php echo Html::submitButton('Update Alias Customer',['class' => 'btn btn-primary']); ?>
		</div>    
<?php ActiveForm::end(); ?>	

	





