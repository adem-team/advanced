<?php

use kartik\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\TouchSpin;
use lukisongroup\master\models\Customer;
use lukisongroup\esm\models\Barang;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model crm\salespromo\models\Stock_gudang */
/* @var $form yii\widgets\ActiveForm */

//$cust = ArrayHelper::map(Customer::find(), 'CUST_KD', 'CUST_NM');
/*TEST ARRAY*/
$data = [
    "red" => "red",
    "green" => "green",
    "blue" => "blue",
    "orange" => "orange",
    "white" => "white",
    "black" => "black",
    "purple" => "purple",
    "cyan" => "cyan",
    "teal" => "teal"
]; 
$cust = ArrayHelper::map(Customer::find()->orderBy('CUST_NM')->all(), 'CUST_KD', 'CUST_NM'); 
$esm_brg = ArrayHelper::map(Barang::find()->orderBy('NM_BARANG')->all(), 'KD_BARANG', 'NM_BARANG'); 

//$url = \yii\helpers\Url::to(['/salespromo/stock-gudang/cust-list']);

/* $this->registerJs("
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};			
    ",$this::POS_HEAD);
 */
?>

<div class="stock-gudang-form">

    <?php $form = ActiveForm::begin([
			'id'=>'afspgudang',
			'enableClientValidation' => true,
			'method' => 'post',
			'action' => ['/salespromo/stock-gudang/simpan'],
		]);
	?>
	<?php //= $form->errorSummary($model); ?>
	
    <?= $form->field($model, 'WAKTU',['template' => "{input}"])->textInput(['value'=>date('Y-m-d H:i:s'),'readonly' => true]) ?>

    <?= $form->field($model, 'CUST_KD')->widget(Select2::classname(), [		
			'data' => $cust,
			'options' => ['placeholder' => 'Search for a customer ...'],
			'pluginOptions' => [
				//'multiple' => true
				//'allowClear' => true
				//'maximumInputLength' => 3
			], 		
		])
	?>

    <?php //echo $form->field($model, 'CUST_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_BARANG')->widget(Select2::classname(), [		
			'data' => $esm_brg,
			'options' => ['placeholder' => 'Search for a Item Barang ...'],
			'pluginOptions' => [
				//'multiple' => true
				//'allowClear' => true
				'maximumInputLength' => 3
			], 		
		]) 
	?>

    <?php //= $form->field($model, 'NM_BARANG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STOCK_GUDANG_UNIT')->widget(TouchSpin::classname(), [
			'name' => 't4',
			'options' => ['placeholder' => 'Entry Jumlah Stok per Item Barang ...'],			
			'pluginOptions' => [
				'buttonup_class' => 'btn btn-primary', 
				'buttondown_class' => 'btn btn-info', 
				'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>', 
				'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>'
			]
		])
	?>
	<?= $form->field($model, 'STOCK_GUDANG_PCS')->widget(TouchSpin::classname(), [
			'name' => 't5',
			'options' => ['placeholder' => 'Entry Jumlah Stok per Item Barang ...'],			
			'pluginOptions' => [
				'buttonup_class' => 'btn btn-primary', 
				'buttondown_class' => 'btn btn-info', 
				'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>', 
				'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>'
			]
		])
	?>

    <?php //= $form->field($model, 'PRODAK_LINE')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'CORP_ID')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'KD_DISTRIBUTOR')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'KD_SUBDIST')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'CREATED_BY')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'UPDATED_BY')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'UPDATED_TIME')->textInput() ?>

    <?php //= $form->field($model, 'STATUS')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
