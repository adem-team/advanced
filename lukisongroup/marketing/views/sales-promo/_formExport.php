<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use kartik\widgets\Select2;

	$aryStt= [
		  ['STATUS' => 0, 'STT_NM' => 'DISABLE'],		  
		  ['STATUS' => 1, 'STT_NM' => 'ENABLE'],
		  ['STATUS' => 2, 'STT_NM' => 'PANDING'],
		  ['STATUS' => 3, 'STT_NM' => 'ALL'],
	];	
	$valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');
?>

	<?php
		$form = ActiveForm::begin([
				'id'=>$model->formName(),
				'enableClientValidation' => true,
				'enableAjaxValidation'=>true,
				//'method' => 'post',
				'validationUrl'=>Url::toRoute('/marketing/sales-promo/export-excel'),	
				//'action' => ['/master/review-visit/ambil-tanggal'],
				'action' => ['/marketing/sales-promo/export-excel'],
		]);
	?>	
	<?= $form->field($model, 'STATUS')->widget(Select2::classname(), [
			'data' =>$valStt ,
			'options' => ['placeholder' => 'Pilih Status...'],
			'pluginOptions' => [
				'allowClear' => true
			],
		]);
	?>
	<?php
		// $form->field($model, 'tgl_detail')->widget(DatePicker::classname(), [
		// 'options' => [
			// 'placeholder' => 'Pilih  ...'
		// ],
		// 'pluginOptions' => [
		   // 'autoclose'=>true,
		   // 'format' => 'yyyy-mm-dd',
		// ]

		// ])->label('Tanggal')  
	?>
	
	<div style="text-align: right;"">
		<?=Html::submitButton('Submit',['class' => 'btn btn-primary']); ?>
	</div>

    
<?php ActiveForm::end(); ?>	



