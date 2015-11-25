<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\Unitbarang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unitbarang-form">

    <?php $form = ActiveForm::begin([
			'type' => ActiveForm::TYPE_HORIZONTAL,
			'id'=>'form-umum',
            'enableClientValidation' => true,
			'method' => 'post',
		
		]);
	?>

    <?= $form->field($model, 'NM_UNIT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QTY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SIZE')->textInput() ?>

    <?= $form->field($model, 'WEIGHT')->textInput() ?>

    <?= $form->field($model, 'COLOR')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']) ?>

    <?php //= $form->field($model, 'STATUS')->textInput() ?>

     
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
