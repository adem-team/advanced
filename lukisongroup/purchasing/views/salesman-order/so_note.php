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

    <?= $form->field($model, 'ID')->hiddenInput(['value'=>$model->ID,'maxlength' => true,'readonly'=>true])->label(false) ?>

    <?= $form->field($model, 'NOTE')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ])->label(false) ?>

  
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
