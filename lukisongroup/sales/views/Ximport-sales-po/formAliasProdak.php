<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

?>

	<?php
		$form = ActiveForm::begin([
				'id'=>'alias-prodak-cust',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/sales/import-sales-po/alias_prodak_save']
		]);
	?>	
		
	<?php echo  $form->field($AliasProdak, 'kD_BARANG_ALIAS')->textInput([
					'value' =>$tempDataImport->ITEM_ID_ALIAS ,
					'maxlength' => true, 
					'readonly' => true
				])->label('Alias.ID Product'); ?>
	<?php echo  $form->field($AliasProdak, 'nM_BARANG_ALIAS')->textInput([
					'value' =>$tempDataImport->ITEM_NM_ALIAS  ,
					'maxlength' => true, 
					'readonly' => true
				])->label('Customer'); ?>
	<?php echo  $form->field($AliasProdak, 'kD_REF')->hiddenInput([
					'value' =>$tempDataImport->DIS_REF,
					'maxlength' => true, 
					'readonly' => true
				])->label(false); ?>
	<?php echo 	$form->field($AliasProdak, 'kD_BARANG')->widget(Select2::classname(), [
					'data' => $aryBrgID,
					'options' => ['placeholder' => 'Search  Items ...'],
					'pluginOptions' => [
						'allowClear' => true
					 ],
				]);
	?>
	
	<div style="text-align: right;"">
		<?php echo Html::submitButton('Sync Alias Product',['class' => 'btn btn-primary']); ?>
	</div>
<?php ActiveForm::end(); ?>	

	





