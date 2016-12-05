<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use dosamigos\ckeditor\CKEditor;
use lukisongroup\master\models\Distributor;

	$listDistibutor = ArrayHelper::map(Distributor::find()->where('STATUS<>3')->all(), 'KD_DISTRIBUTOR', 'NM_DISTRIBUTOR');
?>

<div class="purchaseorder-form">
     <?php $form = ActiveForm::begin([
			'id'=>$model->formName(),
			'enableClientValidation' => true,
			//'enableAjaxValidation' => true,
		]);
	?>

	<?= $form->field($model, 'ID')->hiddenInput(['value'=>$model->ID,'maxlength' => true,'readonly'=>true])->label(false) ?>
	<?= $form->field($model, 'DESTINATION')->dropDownList($listDistibutor,[
			'promt' =>'Destination Handle',
		])->label('Destination Handling');?>
	<div style="text-align: right;">
		<?php echo Html::submitButton('Save',['class' => 'btn btn-primary btn-xs']); ?>
	</div>

    <?php ActiveForm::end(); ?>

</div>
