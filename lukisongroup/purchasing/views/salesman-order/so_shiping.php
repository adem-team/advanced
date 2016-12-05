<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\po\Purchaseorder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchaseorder-form">
	<div class="row">
		 <?php $form = ActiveForm::begin([
				'id'=>$model->formName(),
				'enableClientValidation' => true,
				//'enableAjaxValidation' => true,
			]);
		?>
		<div class="col-lg-4">
			<?= $form->field($model, 'CUST_KD')->textInput(['value'=>$model->CUST_KD,'maxlength' => true,'readonly'=>true]) ?>
		</div>
		<div class="col-lg-8">
			<?= $form->field($model, 'CUST_NM')->textInput(['value'=>$model->CUST_NM,'maxlength' => true,'readonly'=>true]) ?>
		</div>
		<div class="col-lg-4">
			<?= $form->field($model, 'PIC')->textInput() ?>
		</div>
		<div class="col-lg-4">
			<?= $form->field($model, 'TLP1')->textInput()->label('TLP') ?>
		</div>
		<div class="col-lg-4">
			<?= $form->field($model, 'FAX')->textInput() ?>
		</div>
		<div class="col-lg-12">
			<?= $form->field($model, 'ALAMAT_KIRIM')->widget(CKEditor::className(), [
				'options' => ['rows' => 6],
				'preset' => 'basic'
			]) ?>
	  
		
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary btn-xs']) ?>
		
		<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
