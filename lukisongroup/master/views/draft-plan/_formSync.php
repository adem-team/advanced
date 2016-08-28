<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
$profile=Yii::$app->getUserOpt->Profile_user();


	// $arrayStt= [
		  // ['status' => 0, 'DESCRIP' => 'PENDING'],
		  // ['status' => 1, 'DESCRIP' => 'SIGN'],
	// ];
	// $valStt = ArrayHelper::map($arrayStt, 'status', 'DESCRIP');
?>
<div>
	<?php
		$form = ActiveForm::begin([
				'id'=>'modelSync-id',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/master/draft-plan/set-sync'],
		]);
	?>
	
		<?=$form->field($model, 'empNm')->textInput(['value' => $profile->emp->EMP_NM .' '. $profile->emp->EMP_NM_BLK ,'maxlength' => true, 'readonly' => true])->label('Employee Name')->label(false); ?>
		<?=$form->field($model, 'tanggal1')->textInput(['value' => '2016-08-27', 'readonly' => true])->label('Start Date'); ?>
		<?php
			/* $form->field($model, 'tanggal1')->widget(DatePicker::classname(), [
				'name'=>'StartDate',
				'options' => [
					'value'=>'2016-08-27',//date("Y-m-d"),
					'readonly' => true,
					'disabled'=>true
				],
				'layout'=>'{picker} {input}',
				'pluginOptions' => [
					'autoclose'=>true,
					'format' => 'yyyy-mm-dd',
					'todayHighlight' => true,
					
				],
				'pluginEvents'=>[
					   'show' => "function(e) {errror}",
				],
				
			])->label('Start Date')  */ 
		?>
		<?= $form->field($model,'tanggal2')->widget(DatePicker::classname(), [
				'name'=>'EndDate',
				'options' => [
					//'value'=>'2016-08-27',//date("Y-m-d"),
					'readonly' => true,
					//'disabled'=>true
				],
				'layout'=>'{picker}{input}{remove}',
				'pluginOptions' => [
				   'autoclose'=>true,
				   'format' => 'yyyy-mm-dd',
				   'todayHighlight' => true,
				   
				],
				'pluginEvents'=>[
				   'show' => "function(e) {errror}",
				], 
			])->label('End Date')  
		?>
		<?php //=$form->field($model, 'status')->textInput(['value'=>100])->label("Status"); ?>
		<?=$form->field($model, 'password')->textInput(['type'=>'password','maxlength' => true])->label('Password'); ?>
		<div style="text-align: right;">
			<?= Html::submitButton('Sync',['class' => 'btn btn-primary']); ?>
		</div>


	<?php ActiveForm::end(); ?>
</div>