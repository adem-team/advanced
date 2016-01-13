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

use lukisongroup\master\models\Barangumum;
use lukisongroup\esm\models\Barang;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Unitbarang;

$brgUnit = ArrayHelper::map(Unitbarang::find()->orderBy('NM_UNIT')->all(), 'KD_UNIT', 'NM_UNIT');
$brgKtg = ArrayHelper::map(Kategori::find()->orderBy('NM_KATEGORI')->all(), 'KD_KATEGORI', 'NM_KATEGORI');
$brgUmum = ArrayHelper::map(Barangumum::find()->orderBy('NM_BARANG')->all(), 'KD_BARANG', 'NM_BARANG'); 

/* $this->registerJs("
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};			
    ",$this::POS_HEAD);
 */

 
?>


    <?php $form = ActiveForm::begin([
			'id'=>'poplus-Input',
			'enableClientValidation' => true,
			'enableAjaxValidation' => true,
			'method' => 'post',
			'action' => ['/purchasing/purchase-order/poplus-additem-save'],
		]);
	?>
	<?php //= $form->errorSummary($model); ?>
	
    <?php //$form->field($poDetailValidation, 'CREATED_AT',['template' => "{input}"])->textInput(['value'=>date('Y-m-d H:i:s'),'readonly' => true]) ?>

    <?php
		 echo $form->field($poDetailValidation, 'kD_PO')->hiddenInput(['value' =>$kdpo])->label(false);
		 //echo $form->field($poDetailValidation, 'nM_BARANG')->hiddenInput(['value' =>$brgUmum->NM_BARANG])->label(false);
		 echo $form->field($poDetailValidation, 'kD_KATEGORI')->dropDownList($brgKtg, ['id'=>'poplusvalidation-kd_kategori']);
		 
		 echo $form->field($poDetailValidation, 'kD_BARANG')->widget(DepDrop::classname(), [
			'type'=>DepDrop::TYPE_SELECT2,
			'data' => $brgUmum,
			'options' => ['id'=>'poplusvalidation-kd_barang'],
			'pluginOptions' => [
				'depends'=>['poplusvalidation-kd_kategori'],
				'url'=>Url::to(['/purchasing/purchase-order/brgkat']),
				'initialize'=>true,
			], 		
		]);
		
		echo $form->field($poDetailValidation, 'uNIT')->widget(Select2::classname(), [
				'data' => $brgUnit,
				'options' => ['placeholder' => 'Pilih Unit Barang ...'],
				'pluginOptions' => [
					'allowClear' => true
				],
		]);
	?>

    <?php echo  $form->field($poDetailValidation, 'qTY')->textInput(['maxlength' => true, 'placeholder'=>'Jumlah Barang']); ?>

    <?php echo $form->field($poDetailValidation, 'nOTE')->textarea(array('rows'=>2,'cols'=>5))->label('Informasi');?>

    <div class="form-group">
        <?php // Html::submitButton($poDetailValidation->isNewRecord ? 'Create' : 'Update', ['class' => $poDetailValidation->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
	<div style="text-align: right;"">
		<?php echo Html::submitButton('Add',['class' => 'btn btn-primary']); ?>
	</div>
    
	<?php ActiveForm::end(); ?>	

