<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use yii\helpers\Url;

?>
<?php yii\widgets\Pjax::begin(['id' => 'issue-chek-tgl']) ?>
	<?php
		$form = ActiveForm::begin([
				'id'=>$model->formName().'issue',
				'enableClientValidation' => false,
				'enableAjaxValidation'=>true,
				'validationUrl'=>Url::toRoute('/master/review-visit/ambil-tanggal-issue'),	
				//'method' => 'post',
				'action' => ['/master/review-visit/index'],
		]);
	?>	
	<?= $form->field($model, 'tgl')->widget(DatePicker::classname(), [
		'options' => ['placeholder' => 'Pilih  ...'],
		'pluginOptions' => [
		   'autoclose'=>true,
		   'format' => 'yyyy-mm-dd',
		]
		])->label('Tanggal')  ?>
		
		<div style="text-align: right;"">
		<?php //echo Html::submitButton('Submit',['class' => 'btn btn-primary', 'data-pjax' =>1]); ?>
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
	$(".$model->formName().'issue'.").on('ajaxComplete',".$model->formName().", function () {
		 var form = $(".$model->formName().'issue'.");
		 // return false if form still have some validation errors
		 if (form.find('.has-error').length) {
			  return false;
		 }; 		
		$.ajax({
			url: form.attr('action'),
			type: 'post',
			data: form.serialize(),
			success: function (response) {
			   //console.log(response);
			    $.pjax.reload({container:'#gv-dashboard-issue'});
				$('#modal-issue-tgl').modal('hide');
			}
		});
		 return false;
	});	
",$this::POS_READY);
?>



