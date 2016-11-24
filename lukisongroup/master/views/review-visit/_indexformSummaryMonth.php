<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use kartik\widgets\Select2;
use kartik\money\MaskMoney;
use kartik\widgets\DepDrop;


?>
<?php yii\widgets\Pjax::begin(['id' => 'detail-chek-summary-month']) ?>
	<?php
		$form = ActiveForm::begin([
				'id'=>$model->formName().'detail',
				'enableClientValidation' => false,
				'enableAjaxValidation'=>true,
				//'method' => 'post',
				'validationUrl'=>Url::toRoute('/master/review-visit/ambil-monthly'),	
				//'action' => ['/master/review-visit/ambil-tanggal'],
				'action' => ['/master/review-visit/index'],
		]);
	?>	
	<?= $form->field($model, 'tgl_detail_month')->widget(DatePicker::classname(), [
		'options' => [
			'placeholder' => 'Pilih  ...'
		],
		'pluginOptions' => [
		   'autoclose'=>true,
		   'format' => 'yyyy-mm-dd',
		]

		])->label('Tanggal')  ?>
		
	 <?= $form->field($model, 'USER_ID')->widget(Select2::classname(), [
        'data' => $arySalesUser,
        'options' => [
        'placeholder' => 'Pilih User..'],
        'pluginOptions' => [
            'allowClear' => true,
             ],


    ])?>
		<div style="text-align: right;"">
			<?php //echo Html::submitButton('Submit',['class' => 'btn btn-primary']); ?>
		</div>

    
	<?php ActiveForm::end(); ?>	
<?php yii\widgets\Pjax::end() ?>	
<?php
$url_dev = Url::base(true);
$this->registerJs("
	/**
	* Before Action Handling Modal.
	* Status : Fixed.
	* author piter novian [ptr.nov@gmail.com].
	*/
	$(".$model->formName().'detail'.").on('ajaxComplete',".$model->formName().'detail'.", function () {
		 var form = $(".$model->formName().'detail'.");
		 // return false if form still have some validation errors
		 if (form.find('.has-error').length) {
			  return false;
		 }; 		
		 var valTgl = $('#dynamicmodel-tgl_detail_month').val();
		 var valUser= $('#dynamicmodel-user_id').val();
		 console.log(valTgl);
		 console.log(valUser);
		 $.ajax({
			//url: 'http://lukisongroup.com/dashboard/rpt-esm-chart-salesmd/visit',
			url: '".$url_dev."/dashboard/rpt-esm-chart-salesmd/visit-per-sales',
			type: 'GET',
			//data: form.serialize(),
			data:'tgl='+valTgl+'&id='+valUser,
			success: function (response) {
				$('document').ready(function(){
					var revenueChart = new FusionCharts({
						type: 'msline',					
						renderAt: 'msline-monthly-salesmd-visit',
						width: '100%',	
						height:'500%',	
						dataFormat: 'json',
						dataSource: response
					}).render();
									
			
				})
			   console.log(valTgl);
			}
		});
		
		/* $.ajax({
			url: form.attr('action'),
			type: 'post',
			data: form.serialize(),
			//data:'tgl='+valTgl,
			success: function (response) {
			   //console.log(response);
			    $.pjax.reload({container:'#cust-visit-list'});
				$('#modal-review-tgl').modal('hide');
			}
		}); */
		 return false;
	});	
",$this::POS_READY);




