<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\label\LabelInPlace;
use kartik\widgets\Select2;
use yii\helpers\Url;
use kartik\widgets\DepDrop;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Province */
/* @var $form yii\widgets\ActiveForm */

   $config = ['template'=>"{input}\n{error}\n{hint}"];  
   
  
                                                               
?>

<div class="province-form">

    <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
	'enableClientValidation'=> true,
	'enableAjaxValidation'=>true, 															//true = harus beda url action controller dengan post saved  url controller.
	'validationUrl'=>Url::toRoute('/master/customers/valid-alias-customers'),
	]); ?>
	
	 <?= $form->field($model, 'KD_PARENT')->widget(Select2::classname(), [
      'data' =>$cus_data ,
      'options' => ['placeholder' => 'Pilih Customers Parent...'],
      'pluginOptions' => [
        'allowClear' => true
         ],
    ]);?>
	
	<?= $form->field($model, 'KD_CUSTOMERS')->widget(DepDrop::classname(), [
    'options' => [//'id'=>'customers-cust_ktg',
    'placeholder' => 'Select Customers '],
    'type' => DepDrop::TYPE_SELECT2,
    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
    'pluginOptions'=>[
        'depends'=>['customersalias-kd_parent'],
        'url' => Url::to(['/master/customers/lis-child-cus']),
      'loadingText' => 'Loading data ...',
    ]
]);?>
	
	

	
	
	 <?= $form->field($model, 'KD_DISTRIBUTOR')->widget(Select2::classname(), [
      'data' => $cus_dis,
      'options' => ['placeholder' => 'Pilih  DISTRIBUTOR ...'],
      'pluginOptions' => [
        'allowClear' => true
         ],
    ]);?>
	
	<?= $form->field($model, 'KD_ALIAS', $config)->widget(LabelInPlace::classname());?>
	

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
