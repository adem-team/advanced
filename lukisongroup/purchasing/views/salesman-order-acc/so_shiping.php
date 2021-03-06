<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\po\Purchaseorder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchaseorder-form">

     <?php $form = ActiveForm::begin([
			'id'=>$model->formName(),
			'enableClientValidation' => true,
			//'enableAjaxValidation' => true,
		]);
	?>

    <?= $form->field($model, 'kd_sodm')->textInput(['value'=>$kode_som,'maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($model, 'ALAMAT_KIRIM')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>

  
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
