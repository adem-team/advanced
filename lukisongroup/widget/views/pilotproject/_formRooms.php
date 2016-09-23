<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
?>
	
	<?php
		$form = ActiveForm::begin([
			'id'=> $model->formName(),
			'enableClientValidation'=> true,
			'enableAjaxValidation'=>true,
			//'validationUrl'=>Url::toRoute('/widget/pilotproject/room-form')
		]);
	?>
	<div>
	<?=$form->field($model,'klikparent')->checkbox(['id'=>'test123']) ?>
	</div>
	<div id='tampilkan'>
		<?=$form->field($model, 'srcparent')->textInput()->label('Tanggal')  ?>		
		
	</div>
		
	<div style="text-align: right;"">
		<?php echo Html::submitButton('Submit',['class' => 'btn btn-primary']); ?>
	</div>
	<?php ActiveForm::end(); ?>	
<?php	
	$this->registerJs("
		$('#test123').click(function(){
		 var checkedValue = $('#test123:checked').val();

		  if(checkedValue == 1)
		  {
			$('#tampilkan').hide();
		  }
		  else
		  {
			  $('#tampilkan').show();
		  }

		});
	",$this::POS_READY);
?>




