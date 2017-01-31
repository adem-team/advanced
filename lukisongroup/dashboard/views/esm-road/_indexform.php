<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use kartik\widgets\Select2;


?>
<?php yii\widgets\Pjax::begin(['id' => 'detail-chek-tgl']) ?>
	<?php
		$form = ActiveForm::begin([
				'id'=>$model->formName(),
				'enableClientValidation' => true,
				'enableAjaxValidation'=>true,
				//'method' => 'post',
				'validationUrl'=>Url::toRoute('/dashboard/esm-road/ambil-tanggal'),	
				//'action' => ['/master/review-visit/ambil-tanggal'],
				'action' => ['/dashboard/esm-road/index'],
		]);
	?>	
	<?= $form->field($model, 'tgl_detail')->widget(DatePicker::classname(), [
		'options' => [
			'placeholder' => 'Pilih  ...'
		],
		'pluginOptions' => [
		   'autoclose'=>true,
		   'format' => 'yyyy-mm-dd',
		]

		])->label('Tanggal')  
	?>
	
	<?= $form->field($model, 'USER_ID')->widget(Select2::classname(), [
        'data' => $arySalesUser,
        'options' => [
			'placeholder' => 'Pilih User..'
		],
        'pluginOptions' => [
            'allowClear' => true,
             ],


		])
	?>
	
		<div style="text-align: right;"">
			<?php //echo Html::submitButton('Submit',['class' => 'btn btn-primary']); ?>
		</div>

    
	<?php ActiveForm::end(); ?>	
<?php yii\widgets\Pjax::end() ?>	
<?php
$url_dev = Url::base(true);
$this->registerJs("
	/**
	* Before Action Handling Modal - GRIDVIEW RELOAD.
	* Status : Fixed.
	* author piter novian [ptr.nov@gmail.com].
	*/
	$(".$model->formName().").on('ajaxComplete',".$model->formName().", function () {
		 var form = $(".$model->formName().");
		/*  // return false if form still have some validation errors
		 if (form.find('.has-error').length) {
			  return false;
		 }; 		
		 //var valTgl = $('#DynamicModel-tgl-kvdate').val();
		$.ajax({
			url: form.attr('action'),
			type: 'post',
			data: form.serialize(),
			//data:'tgl='+valTgl,
			success: function (response) {
			   //console.log(response);
			    $.pjax.reload({container:'#cust-visit-list'});
				$('#modal-review-tgl').modal('hide');
			}
		});
		 return false; */
		 
		 // return false if form still have some validation errors
		 if (form.find('.has-error').length) {
			  return false;
		 }; 		
		 var valTgl = $('#dynamicmodel-tgl_detail').val();
		 var valUser= $('#dynamicmodel-user_id').val();
		 console.log(valTgl);
		 console.log(valUser);
		 $.ajax({
			//url: 'http://lukisongroup.com/dashboard/rpt-esm-chart-salesmd/chart',
			url: '".$url_dev."/dashboard/esm-road/chart',
			type: 'GET',
			//data: form.serialize(),
			data:'tgl='+valTgl+'&id='+valUser,
			success: function (response) {
				$('document').ready(function(){
					var revenueChart = new FusionCharts({
						type: 'stackedcolumn3d',					
						renderAt: 'msline-road-visit',
						'width':'100%',
						'height':'300px',	
						dataFormat: 'json',
						dataSource: response
					}).render();
					//$('#modal-cari-tgl').modal('hide');				
			
				})
				//document.write('<?php $abc=1 ;?>');
				//$result='<div id='result'>test</div>';
				//var xx ='asdasd';
			   console.log(valTgl);
			}
		});
		
		$.ajax({
			//url: 'http://lukisongroup.com/dashboard/rpt-esm-chart-salesmd/pie',
			url: '".$url_dev."/dashboard/esm-road/pie',
			type: 'GET',
			//data: form.serialize(),
			data:'tgl='+valTgl+'&id='+valUser,
			success: function (response) {
				$('document').ready(function(){
					var revenueChart = new FusionCharts({
						type: 'pie3d',					
						renderAt: 'pie-road-sales',
						'width':'100%',
						'height':'300px',	
						dataFormat: 'json',
						dataSource: response
					}).render();
					//$('#modal-cari-tgl').modal('hide');				
			
				});
				$('document').ready(function(){
					var revenueChart = new FusionCharts({
						type: 'bar3d',					
						renderAt: 'bar-road-sales',
						'width':'100%',
						'height':'450px',	
						dataFormat: 'json',
						dataSource: response
					}).render();
					//$('#modal-cari-tgl').modal('hide');				
			
				})
				//document.write('<?php $abc=1 ;?>');
				//$result='<div id='result'>test</div>';
				//var xx ='asdasd';
			   console.log(valTgl);
			}
		});
		
		 return false;
	});	
",$this::POS_READY);




