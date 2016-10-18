<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use yii\helpers\Url;
use kartik\widgets\DateTimePicker;
?>
	
	<?php
		$form = ActiveForm::begin([
			'id'=> $model->formName(),
			'enableClientValidation'=> true,
			'enableAjaxValidation'=>true,
			'validationUrl'=>Url::toRoute('/widget/pilotproject/valid-pilot')
		]);
	?>
	<div>
	<?=$form->field($model,'parentpilot')->checkbox() ?>
	</div>

	<div id='tampilkan'>
	 <?= $form->field($model, 'PARENT')->widget(Select2::classname(), [
        'data' => $data,
        'options' => [
        'id'=>'pilotproject-parent',
        'placeholder' => 'Pilih...'],
        'pluginOptions' => [
            'allowClear' => true
             ],

    ]);
    ?>			
	</div>

	<?=$form->field($model, 'PILOT_NM')->textInput()  ?>

	<?= $form->field($model, 'PLAN_DATE1')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => 'Enter date ...'],
    'pluginOptions' => [
        'autoclose'=>true
    ],
    'pluginEvents' => [
                      'show' => "function(e) {show}",
    ],
]);?>

  

 <?= $form->field($model, 'PLAN_DATE2')->widget(DateTimePicker::classname(), [
    'options' => ['placeholder' => 'Enter date ...'],
    'pluginOptions' => [
        'autoclose'=>true
    ],
    'pluginEvents' => [
                      'show' => "function(e) {show}",
    ],
]);?>

    

<?= $form->field($model, 'DESTINATION_TO')->widget(Select2::classname(), [
         'data' => $dropemploy,
        'options' => [
        'placeholder' => 'Pilih Karyawan ...'],
        'pluginOptions' => [
            'allowClear' => true
             ],
        
    ]);?>	
		
	<div style="text-align: right;"">
		<?php echo Html::submitButton('Submit',['class' => 'btn btn-primary']); ?>
	</div>
	<?php ActiveForm::end(); ?>	

<?php	
$this->registerJs("

	$('#pilotproject-parentpilot').click(function(){
	 var checkedValue = $('#pilotproject-parentpilot:checked').val();

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






