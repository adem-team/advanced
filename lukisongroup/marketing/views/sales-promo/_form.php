<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\label\LabelInPlace;
use kartik\widgets\Select2;
use yii\helpers\Url;
use kartik\widgets\DepDrop;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use kartik\widgets\DatePicker;
use kartik\widgets\TouchSpin;

use lukisongroup\master\models\Customers;
$cus_data=ArrayHelper::map(Customers::find()->where('CUST_KD = CUST_GRP')->andwhere('STATUS<>3')->all(), 'CUST_GRP','CUST_NM');

?>


 <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
	'enableClientValidation'=> true,
	'enableAjaxValidation'=>true, 															//true = harus beda url action controller dengan post saved  url controller.
	'validationUrl'=>Url::toRoute('/marketing/sales-promo/valid'),
	]); ?>
<div style="height:100%;font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div class="row" >
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">	
			<?= $form->field($model, 'KD_PARENT')->widget(Select2::classname(), [
					'data' =>$cus_data ,
					'options' => ['placeholder' => 'Pilih Customers Parent...'],
					// 'pluginOptions' => [
						// 'allowClear' => true
					// ],
				]);
			?>
			<?= $form->field($model, 'CUST_ID')->widget(DepDrop::classname(), [
					'options' => ['id'=>'salespromo-cust_id',
					'placeholder' => 'Select Customers '],
					'type' => DepDrop::TYPE_SELECT2,
					//Select2Plugin
					'select2Options'=>[
						'pluginOptions'=>[
							'allowClear'=>true
						]
					],
					//DepDrop plugin
					'pluginOptions'=>[
						'depends'=>['salespromo-kd_parent'],
						'url' => Url::to(['/marketing/sales-promo/lis-child-cus']),
					  'loadingText' => 'Loading data ...',
					]	
				]);
			?>
			<div id="grp">
				<?= $form->field($model, 'CUST_NM')->widget(DepDrop::classname(), [		
						'options' => [
							'id'=>'customers-cust_ktg',
							'placeholder' => 'Select Customers ',
						],
						'type' => DepDrop::TYPE_SELECT2,
						//Select2Plugin
						'select2Options'=>[
							'hideSearch' => true,
							'disabled' => true,
							'readonly'=>true,
							'pluginOptions'=>[
								//'allowClear'=>true
							]
						],
						//DepDrop plugin
						'pluginOptions'=>[
							'depends'=>['salespromo-kd_parent','salespromo-cust_id'],
							'url' => Url::to(['/marketing/sales-promo/lis-child-cusnm']),
							'initialize'=>true,
							 'params'=>['alespromo-cust_id']
						]	
					]);
				?>
			</div>
			<?=$form->field($model, 'PROMO')->textarea(['rows' => 2]) ?>
			<?=$form->field($model, 'TGL_START')->widget(DatePicker::classname(), [
					'options' => ['placeholder' => 'Enter Resign date ...'],
					'pluginOptions' => Yii::$app->gv->gvPliginDate()
				])
			?>
			<?=$form->field($model, 'TGL_END')->widget(DatePicker::classname(), [
					'options' => ['placeholder' => 'Enter Resign date ...'],
					'pluginOptions' => Yii::$app->gv->gvPliginDate()
				])
			?>
			<?= $form->field($model, 'OVERDUE')->widget(TouchSpin::classname(), [
					'name' => 'overdue',
					'options' => ['placeholder' => 'Jumlah Hari ...'],			
					'pluginOptions' => [
						'buttonup_class' => 'btn btn-primary', 
						'buttondown_class' => 'btn btn-info', 
						'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>', 
						'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>'
					]
				])
			?>		
			<?= $form->field($model, 'STATUS')->widget(Select2::classname(), [
					'data' =>Yii::$app->gv->gvStatusArray(),
					'options' => ['placeholder' => 'Pilih Status...'],
				]);
			?>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">		
			<?=$form->field($model, 'MEKANISME')->textarea(['rows' => 5]) ?>
			<?=$form->field($model, 'KOMPENSASI')->textarea(['rows' => 5]) ?>
			<?=$form->field($model, 'KETERANGAN')->textarea(['rows' => 5]) ?>
		</div>

		<div  class="col-lg-12" style="text-align: right;">
			<?php //echo Html::submitButton('Save',['class' => 'btn btn-primary']); ?>
			 <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

		</div>
	
    </div>
	
    <?php ActiveForm::end(); ?>


<?php
$this->registerJs("
	 $(document).ready(function () {
		// $('#grp').show();
		$('#grp').hide();
	 });

 ",$this::POS_READY);
 ?>