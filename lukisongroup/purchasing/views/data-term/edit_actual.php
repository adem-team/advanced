<?php
/*extensions */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;

/* namespace model*/
use lukisongroup\master\models\Terminvest;

/*array */
$investData = ArrayHelper::map(Terminvest::find()->all(), 'ID', 'INVES_TYPE');
$data = [ 2=>'2 persen',
          4=>'4 persen ',
          10=>'10 persen',
          15=>'15 persen'];


$config = ['template'=>"{input}\n{error}\n{hint}"];
?>
<div class="row">
	<?php
		$form = ActiveForm::begin([
				'id'=>$model->formName(),
				'enableClientValidation' => true,
		]);
	?>
		<div class="col-lg-4">
			<?php echo  $form->field($model, 'temr_Id')->textInput(['value' => $model_header->TERM_ID,'maxlength' => true, 'readonly' => true])->label('TERM ID'); ?>
		</div>
		<div class="col-lg-4">
			<?php echo  $form->field($model, 'cus_Perent')->textInput(['value' => $cari_customers->CUST_NM,'maxlength' => true, 'readonly' => true])->label('CUST.PARENT'); ?>
		</div>
		<div class="col-lg-12">
			<?= $form->field($model, 'INVESTASI_TYPE')->widget(Select2::classname(),[
					  'options'=>[  'placeholder' => 'Select Type Investasi ...'],
					  'data'=>$investData,
				])->label('INVESTATION TYPE');
			?>
			<?= $form->field($model, 'INVESTASI_PROGRAM')->textArea([
				  'options'=>['rows'=>5]
				])->label('INVESTATION PROGRAM');
			?>
			</div>
				<div class="col-sm-6">
			<?=$form->field($model, 'NOMER_INVOCE')->textInput(['maxlength' => true])->label('INVOICE'); ?>

			<?=$form->field($model, 'NOMER_FAKTURPAJAK')->textInput(['maxlength' => true])->label('FAKTUR'); ?>

			<?=$form->field($model, 'HARGA')->textInput(['maxlength' => true])->label('COST'); ?>

			 <?= $form->field($model, 'PERIODE_START')->widget(DatePicker::classname(), [
			    'options' => ['placeholder' => 'Enter date  ...'],
			    'pluginOptions' => [
                            'todayHighlight' => true,
                            'autoclose'=>true,
                              'format' => 'yyyy-m-dd'
                        ],
                        'pluginEvents'=>[
                            'show' => "function(e) {show}",
                        ],
				]) ?>

				</div>
				<div class="col-sm-6">
					<?= $form->field($model, 'PPH23')->widget(Select2::classname(), [
					     'data' => $data,
					     'options' => ['placeholder' => 'Pilih Percentage ...'],
					     'pluginOptions' => [
					       'allowClear' => true
					     ],
					 ])?>
				</div>

				<div class="col-sm-6">
					<?= $form->field($model, 'PPN')->textinput()?>

					<?= $form->field($model, 'PERIODE_END')->widget(DatePicker::classname(), [
			    'options' => ['placeholder' => 'Enter date  ...'],
			    'pluginOptions' => [
                            'todayHighlight' => true,
                            'autoclose'=>true,
                              'format' => 'yyyy-m-dd'
                        ],
                        'pluginEvents'=>[
                            'show' => "function(e) {show}",
                        ],
				]) ?>
				</div>

		<div class="col-lg-12 pull-right" style="text-align: right;">
			<?php echo Html::submitButton('save',['class' => 'btn btn-primary']); ?>
		</div>

	<?php ActiveForm::end(); ?>
</div>
