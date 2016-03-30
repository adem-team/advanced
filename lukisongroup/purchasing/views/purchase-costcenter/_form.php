<?php

use \Yii;
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\builder\Form;
use kartik\widgets\TouchSpin;
use yii\web\JsExpression;
use yii\data\ActiveDataProvider;

use lukisongroup\esm\models\Barang;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Unitbarang;

$brgUnit = ArrayHelper::map(Unitbarang::find()->orderBy('NM_UNIT')->all(), 'KD_UNIT', 'NM_UNIT');
$brgKtg = ArrayHelper::map(Kategori::find()->orderBy('NM_KATEGORI')->all(), 'KD_KATEGORI', 'NM_KATEGORI');
$brgProdak = ArrayHelper::map(Barang::find()->orderBy('NM_BARANG')->all(), 'KD_BARANG', 'NM_BARANG'); 

/* $this->registerJs("
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};			
    ",$this::POS_HEAD);
 */

 
?>


    <?php $form = ActiveForm::begin([
			'id'=>'sa-input',
			'enableClientValidation' => true,
			'method' => 'post',
			'action' => ['/purchasing/sales-order/simpanfirst'],
		]);
	?>
	<?php //= $form->errorSummary($model); ?>
	
    <?= $form->field($Detailsa, 'CREATED_AT',['template' => "{input}"])->textInput(['value'=>date('Y-m-d H:i:s'),'readonly' => true]) ?>

    <?php
		 echo $form->field($Detailsa, 'NM_BARANG')->hiddenInput(['value' => ''])->label(false);
		 echo $form->field($Detailsa, 'KD_KATEGORI')->dropDownList($brgKtg, ['id'=>'rodetail-kd_kategori']);
		 
		 echo $form->field($Detailsa, 'KD_BARANG')->widget(DepDrop::classname(), [
			'type'=>DepDrop::TYPE_SELECT2,
			'data' => $brgProdak,
			'options' => ['id'=>'rodetail-kd_barang'],
			'pluginOptions' => [
				'depends'=>['rodetail-kd_kategori'],
				'url'=>Url::to(['/purchasing/sales-order/brgkat']),
				'initialize'=>true,
			], 		
		]);
		
		/* echo $form->field($Detailsa, 'UNIT')->widget(DepDrop::classname(), [
			'type'=>DepDrop::TYPE_DEFAULT,
			'data' => $brgUnit,
			'options' => ['id'=>'rodetail-unit','readonly'=>true,'selected'=>false],
			'pluginOptions' => [
				'depends'=>['rodetail-kd_kategori','rodetail-kd_barang'],
				'url'=>Url::to(['/purchasing/sales-order/brgunit']),
				//'initialize'=>true, 
				'placeholder' => false,
			], 		
		]);  */
		echo $form->field($Detailsa, 'UNIT')->widget(Select2::classname(), [
				'data' => $brgUnit,
				'options' => ['placeholder' => 'Pilih Unit Barang ...'],
				'pluginOptions' => [
					'allowClear' => true
				],
		]);
	?>

    <?php echo  $form->field($Detailsa, 'RQTY')->textInput(['maxlength' => true, 'placeholder'=>'Jumlah Barang']); ?>

    <?php echo $form->field($Detailsa, 'NOTE')->textarea(array('rows'=>2,'cols'=>5))->label('Informasi');?>

    <div class="form-group">
        <?= Html::submitButton($Detailsa->isNewRecord ? 'Create' : 'Update', ['class' => $Detailsa->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    
	<?php ActiveForm::end(); ?>	

