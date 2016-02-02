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
			'id'=>'po-note-Input',
			'enableClientValidation' => true,
			//'enableAjaxValidation' => true,
			'method' => 'post',
			'action' => ['/purchasing/purchase-order/po-note-save','kdpo'=>$poHeader->KD_PO],
		]);
	?>

    <?= $form->field($poHeader, 'KD_PO')->textInput(['value'=>$poHeader->KD_PO,'maxlength' => true,'readonly'=>true]) ?>

    <?= $form->field($poHeader, 'NOTE')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>

    <div style="text-align: right;"">
		<?php echo Html::submitButton('Save',['class' => 'btn btn-primary']); ?>
	</div>

    <?php ActiveForm::end(); ?>

</div>
