<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use yii\helpers\Url;



?>
<?php yii\widgets\Pjax::begin(['id' => 'detail-chek-tgl']) ?>
	<?php
		$form = ActiveForm::begin([
				'id'=>$model->formName().'detail',
				'enableClientValidation' => false,
				'enableAjaxValidation'=>true,
				//'method' => 'post',
				'validationUrl'=>Url::toRoute('/master/review-visit/ambil-tanggal-issue'),	
				//'action' => ['/master/review-visit/ambil-tanggal'],
				'action' => ['/master/review-visit/index'],
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

		])->label('Tanggal')  ?>
		
		<div style="text-align: right;"">
			<?php //echo Html::submitButton('Submit',['class' => 'btn btn-primary']); ?>
		</div>

    
	<?php ActiveForm::end(); ?>	
<?php yii\widgets\Pjax::end() ?>	
<?php
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
		 return false;
	});	
",$this::POS_READY);




