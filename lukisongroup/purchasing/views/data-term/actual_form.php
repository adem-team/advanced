<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
	//print_r($term_id);
	//echo ($term_id);
	//print_r($actualModel);
	
use lukisongroup\master\models\Terminvest;

$investData = ArrayHelper::map(Terminvest::find()->all(), 'ID', 'INVES_TYPE');	
$config = ['template'=>"{input}\n{error}\n{hint}"];
?>
<div class="row">
	<?php
		/* $form = ActiveForm::begin([
				'id'=>'auth1Mdl_po',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/purchasing/purchase-order/sign-auth1-save'],
		]); */
		$form = ActiveForm::begin([
				'id'=>'acc-actual-input',
				'enableClientValidation' => true,
				'enableAjaxValidation' => true,
				'method' => 'post',
				'action' => ['/purchasing/data-term/actual-review-save'],
		]);
	?>
		<div class="col-lg-4">
			<?php echo  $form->field($actualModel, 'temId')->textInput(['value' => $termHeader->TERM_ID,'maxlength' => true, 'readonly' => true])->label('TERM ID'); ?>
		</div>
		<div class="col-lg-4">
			<?php echo  $form->field($actualModel, 'cusPerent')->textInput(['value' => $termHeader->CUST_KD_PARENT,'maxlength' => true, 'readonly' => true])->label('CUST.PARENT'); ?>
		</div>
		<div class="col-lg-12">
			<?= $form->field($actualModel, 'investId')->widget(Select2::classname(),[
					  'options'=>[  'placeholder' => 'Select Type Investasi ...'],
					  'data'=>$investData,
				])->label('INVESTATION TYPE');
			?>
			<?= $form->field($actualModel, 'invesProgram')->textArea([
				  'options'=>['rows'=>5]
				])->label('INVESTATION PROGRAM');
			?>
			<?=$form->field($actualModel, 'invoiceNo')->textInput(['maxlength' => true])->label('INVOICE'); ?>
			<?=$form->field($actualModel, 'faktureNo')->textInput(['maxlength' => true])->label('FAKTUR'); ?>
			<?=$form->field($actualModel, 'invesHarga')->textInput(['maxlength' => true])->label('COST'); ?>
		</div>
		<div class="col-lg-12 pull-right" style="text-align: right;">
			<?php echo Html::submitButton('save',['class' => 'btn btn-primary']); ?>
		</div>

	<?php ActiveForm::end(); ?>
</div>