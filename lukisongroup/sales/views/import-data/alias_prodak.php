<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
?>

	<?php
		$form = ActiveForm::begin([
				'id'=>'alias-prodak',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/sales/import-data/alias_prodak-save'],
		]);
	?>	
		
	<?php echo  $form->field($aliasCodeProdak, 'kD_BARANG_ALIAS')->textInput([
					'value' =>$tempDataImport->ITEM_ID_ALIAS ,
					'maxlength' => true, 
					'readonly' => true
				])->label('Alias.ID Product'); ?>
	<?php echo  $form->field($aliasCodeProdak, 'nM_BARANG_ALIAS')->textInput([
					'value' =>$tempDataImport->ITEM_NM_ALIAS  ,
					'maxlength' => true, 
					'readonly' => true
				])->label('Customer'); ?>
	<?php echo 	$form->field($aliasCodeProdak, 'kD_BARANG')->widget(Select2::classname(), [
					'data' => $aryBrgID,
					'options' => ['placeholder' => 'Search  Items ...'],
					'pluginOptions' => [
						'allowClear' => true
					 ],
				]);
	?>	
	<div style="text-align: right;"">
		<?php echo Html::submitButton('Update Alias Product',['class' => 'btn btn-primary']); ?>
	</div>
<?php ActiveForm::end(); ?>	

	





