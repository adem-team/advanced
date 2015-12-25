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
			'id'=>'roInput',
			'enableClientValidation' => true,
			'method' => 'post',
			'action' => ['/purchasing/request-order/simpanfirst'],
		]);
	?>
	<?php //= $form->errorSummary($model); ?>
	
    <?= $form->field($roDetail, 'CREATED_AT',['template' => "{input}"])->textInput(['value'=>date('Y-m-d H:i:s'),'readonly' => true]) ?>

    <?php
		 echo $form->field($roDetail, 'NM_BARANG')->hiddenInput(['value' => ''])->label(false);
		 echo $form->field($roDetail, 'KD_KATEGORI')->dropDownList($brgKtg, ['id'=>'rodetail-kd_kategori']);
		 
		 echo $form->field($roDetail, 'KD_BARANG')->widget(DepDrop::classname(), [
			'type'=>DepDrop::TYPE_SELECT2,
			'data' => $brgUmum,
			'options' => ['id'=>'rodetail-kd_barang'],
			'pluginOptions' => [
				'depends'=>['rodetail-kd_kategori'],
				'url'=>Url::to(['/purchasing/request-order/brgkat']),
				'initialize'=>true,
			], 		
		]);
		
		echo $form->field($roDetail, 'UNIT')->widget(DepDrop::classname(), [
			'type'=>DepDrop::TYPE_DEFAULT,
			'data' => $brgUnit,
			'options' => ['id'=>'rodetail-unit','readonly'=>true,'selected'=>false],
			'pluginOptions' => [
				'depends'=>['rodetail-kd_kategori','rodetail-kd_barang'],
				'url'=>Url::to(['/purchasing/request-order/brgunit']),
				//'initialize'=>true, 
				'placeholder' => false,
			], 		
		]); 
	?>

    <?php echo  $form->field($roDetail, 'RQTY')->textInput(['maxlength' => true, 'placeholder'=>'Jumlah Barang']); ?>

    <?php echo $form->field($roDetail, 'NOTE')->textarea(array('rows'=>2,'cols'=>5))->label('Informasi');?>

    <div class="form-group">
        <?= Html::submitButton($roDetail->isNewRecord ? 'Create' : 'Update', ['class' => $roDetail->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    
	<?php ActiveForm::end(); ?>	

