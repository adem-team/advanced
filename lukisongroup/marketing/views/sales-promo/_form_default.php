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

use lukisongroup\master\models\Customers;
$cus_data=ArrayHelper::map(Customers::find()->where('CUST_KD = CUST_GRP')->andwhere('STATUS<>3')->all(), 'CUST_GRP','CUST_NM');

?>

<div class="sales-promo-form">

 <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
	//'enableClientValidation'=> true,
	//'enableAjaxValidation'=>true, 															//true = harus beda url action controller dengan post saved  url controller.
	//'validationUrl'=>Url::toRoute('/master/customers/valid-alias-customers'),
	]); ?>
	
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
	<?= $form->field($model, 'STATUS')->widget(Select2::classname(), [
			'data' =>Yii::$app->gv->gvStatusArray(),
			'options' => ['placeholder' => 'Pilih Status...'],
		]);
	?>
	<?=$form->field($model, 'MEKANISME')->textarea(['rows' => 6]) ?>

    <?=$form->field($model, 'KOMPENSASI')->textarea(['rows' => 6]) ?>

    <?=$form->field($model, 'KETERANGAN')->textarea(['rows' => 6]) ?>
	

    <div class="form-group">
        <?php // Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs("

	$('#grp').show();
	

 ",$this::POS_READY);
 ?>