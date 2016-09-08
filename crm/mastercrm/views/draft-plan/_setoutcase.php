<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
use kartik\widgets\DepDrop;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftPlan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="draft-plan-form">

    <?php $form = ActiveForm::begin(['id'=>$model->formName(),
    	'enableClientValidation' => true,
        'enableAjaxValidation'=>true,
        'validationUrl'=>Url::toRoute('/master/draft-plan/valid-set-out-case')
    ]); ?>

     <?= $form->field($model, 'USER_ID')->textInput(['value' => $user,'disabled'=>true])->label('user') ?>

      <?= $form->field($model, 'SCDL_GROUP')->textInput(['value' => $group,'disabled'=>true])->label('GROUP') ?>

      <?= $form->field($model, 'TGL')->textInput(['value' => $tgl,'readonly'=>true]) ?>
<!-- 
     $form->field($model, 'TGL')->widget(DatePicker::classname(), [
		'options' => ['placeholder' => 'Pilih  ...'],
		'pluginOptions' => [
		   'autoclose'=>true,
		   'format' => 'yyyy-mm-dd',
		],
		'pluginEvents'=>[
		       'show' => "function(e) {errror}",
		           ],

		])->label('Tanggal')  ?> -->

    <?= $form->field($model, 'Cus_Kd')->widget(Select2::classname(), [
					'data' => $cus,
					'options' => ['placeholder' => 'Pilih ...'],
					'pluginOptions' => [
						'allowClear' => true
						 ],
				])->label('Parent Customers') ?>

	<?= $form->field($model, 'CUST_ID')->widget(DepDrop::classname(), [
	    'type'=>DepDrop::TYPE_SELECT2,
	    'options'=>['id'=>'scheduledetail-cust_id', 'placeholder'=>'Select ...'],
	    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
	    'pluginOptions'=>[
	        'depends'=>['scheduledetail-cus_kd'],
	        'url'=>Url::to(['/master/draft-plan/parent-cus']),
	    ]
	])->label('Customers') ?>

	<!--  $form->field($model, 'USER_ID')->widget(Select2::classname(), [
					'data' => $user,
					'options' => ['placeholder' => 'Pilih  ...'],
					'pluginOptions' => [
						'allowClear' => true
						 ],
				])->label('User') ?> -->

	<!--  $form->field($model, 'SCDL_GROUP')->widget(Select2::classname(), [
					'data' => $group,
					'options' => ['placeholder' => 'Pilih  ...'],
					'pluginOptions' => [
						'allowClear' => true
						 ],
				])->label('Group') ?> -->


	<?= $form->field($model, 'NOTE')->widget(Select2::classname(), [
					'data' => $note,
					'options' => ['placeholder' => 'Pilih  ...'],
					'pluginOptions' => [
						'allowClear' => true
						 ],
				])->label('Atas Perintah') ?>

   


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Tambah', ['class' => $model->isNewRecord ? 'btn btn-info' : 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

