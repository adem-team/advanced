<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use ptrnov\fusionchart\Chart;
use ptrnov\fusionchart\ChartAsset;
ChartAsset::register($this);


?>
<?php yii\widgets\Pjax::begin(['id' => 'chartmd-chek-tgl']) ?>
	<?php
		$form = ActiveForm::begin([
				'id'=>$model->formName().'md',
				'enableClientValidation' => false,
				'enableAjaxValidation'=>true,
				'validationUrl'=>Url::toRoute('/dashboard/rpt-esm/ambil-tanggal-chart'),	
				//'method' => 'post',
				//'action' => ['/master/review-visit/index'],
		]);
	?>	
	<?= $form->field($model, 'tglchartmd')->widget(DatePicker::classname(), [
		'options' => ['placeholder' => 'Pilih  ...'],
		'pluginOptions' => [
		   'autoclose'=>true,
		   'format' => 'yyyy-mm-dd',
		]
		])->label('Tanggal')
	?>		
	<?php ActiveForm::end(); ?>	
<?php yii\widgets\Pjax::end() ?>	

<?php
$this->registerJs("
	/**
	* Before Action Handling Modal.
	* Status : Fixed.
	* author piter novian [ptr.nov@gmail.com].
	*/
	$(".$model->formName().'md'.").on('ajaxComplete',".$model->formName().'md'.", function () {
		 var form = $(".$model->formName().'md'.");
		 // return false if form still have some validation errors
		 if (form.find('.has-error').length) {
			  return false;
		 }; 		
		var valTgl = $('#dynamicmodel-tglchartmd').val();
		$.ajax({
			url: 'http://lukisongroup.com/dashboard/rpt-esm-chart-salesmd/visit',
			type: 'GET',
			//data: form.serialize(),
			data:'tgl='+valTgl,
			success: function (response) {
				$('document').ready(function(){
					var revenueChart = new FusionCharts({
						type: 'msline',					
						renderAt: 'msline-dashboard-salesmd-visit',
						width: '100%',	
						height:'500%',	
						dataFormat: 'json',
						dataSource: response
					}).render();
									
			
				})
			   //console.log(valTgl);
			}
		});
		
		$.ajax({
			url: 'http://lukisongroup.com/dashboard/rpt-esm-chart-salesmd/visit-stock',
			type: 'GET',
			data:'tgl='+valTgl,
			success: function (response_stock) {
				$('document').ready(function(){
					var revenueChart = new FusionCharts({
						type: 'mscolumn3d',					
						renderAt: 'msline-dashboard-salesmd-visit-stock',
						width: '100%',	
						height:'500%',	
						dataFormat: 'json',
						dataSource: response_stock
					}).render();
									
			
				})
			   //console.log(valTgl);
			}
		});
		
		$.ajax({
			url: 'http://lukisongroup.com/dashboard/rpt-esm-chart-salesmd/visit-request',
			type: 'GET',
			data:'tgl='+valTgl,
			success: function (response_stock) {
				$('document').ready(function(){
					var revenueChart = new FusionCharts({
						type: 'mscolumn3d',					
						renderAt: 'msline-dashboard-salesmd-visit-request',
						width: '100%',	
						height:'500%',	
						dataFormat: 'json',
						dataSource: response_stock
					}).render();
									
			
				})
			   //console.log(valTgl);
			}
		});
		
		
		
		
		
		return false;
	});	
",$this::POS_READY);
?>



