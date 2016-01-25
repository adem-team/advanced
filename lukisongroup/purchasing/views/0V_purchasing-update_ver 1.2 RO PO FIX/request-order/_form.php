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

use lukisongroup\master\models\Barang;
use lukisongroup\master\models\Tipebarang;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\hrd\models\Corp;

$userCorp = ArrayHelper::map(Corp::find()->where('CORP_STS<>3')->all(), 'CORP_ID', 'CORP_NM');
$brgUnit = ArrayHelper::map(Unitbarang::find()->where('STATUS<>3')->orderBy('NM_UNIT')->all(), 'KD_UNIT', 'NM_UNIT');
$brgType = ArrayHelper::map(Tipebarang::find()->where('PARENT=0 AND STATUS<>3')->orderBy('NM_TYPE')->all(), 'KD_TYPE', 'NM_TYPE');
$brgKtg  = ArrayHelper::map(Kategori::find()->where('PARENT=0 AND STATUS<>3')->orderBy('NM_KATEGORI')->all(), 'KD_KATEGORI', 'NM_KATEGORI');
$brgUmum = ArrayHelper::map(Barang::find()->where('PARENT=0 AND STATUS<>3')->orderBy('NM_BARANG')->all(), 'KD_BARANG', 'NM_BARANG'); 

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
	
    <?= $form->field($roDetail, 'CREATED_AT',['template' => "{input}"])->hiddenInput(['value'=>date('Y-m-d H:i:s'),'readonly' => true]) ?>
	

    <?php
		echo $form->field($roDetail, 'KD_CORP')->dropDownList($userCorp,[
				'id'=>'rodetail-kd_corp',
				'prompt'=>' -- Pilih Salah Satu --',
			])->label('Perusahaan'); 
	
		echo $form->field($roDetail, 'KD_TYPE')->widget(DepDrop::classname(), [
			'type'=>DepDrop::TYPE_SELECT2,
			'data' => $brgType,
			'options' => ['id'=>'rodetail-kd_type'],
			'pluginOptions' => [
				'depends'=>['rodetail-kd_corp'],
				'url'=>Url::to(['/purchasing/request-order/corp-type']), /*Parent=0 barang Umum*/
				'initialize'=>true,
			], 		
		]);
		
		echo $form->field($roDetail, 'KD_KATEGORI')->widget(DepDrop::classname(), [
			'type'=>DepDrop::TYPE_SELECT2,
			'data' => $brgKtg,
			'options' => ['id'=>'rodetail-kd_kategori'],
			'pluginOptions' => [
				'depends'=>['rodetail-kd_corp','rodetail-kd_type'],
				'url'=>Url::to(['/purchasing/request-order/type-kat']),
				'initialize'=>true,
			], 		
		]);
		 
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
		
		echo $form->field($roDetail, 'NM_BARANG')->hiddenInput(['value' => ''])->label(false);
		/* echo $form->field($roDetail, 'UNIT')->widget(DepDrop::classname(), [
			'type'=>DepDrop::TYPE_DEFAULT,
			'data' => $brgUnit,
			'options' => ['id'=>'rodetail-unit','readonly'=>true,'selected'=>false],
			'pluginOptions' => [
				'depends'=>['rodetail-kd_kategori','rodetail-kd_barang'],
				'url'=>Url::to(['/purchasing/request-order/brgunit']),
				//'initialize'=>true, 
				'placeholder' => false,
			], 		
		]);  */
		echo $form->field($roDetail, 'UNIT')->widget(Select2::classname(), [
				'data' => $brgUnit,
				'options' => ['placeholder' => 'Pilih Unit Barang ...'],
				'pluginOptions' => [
					'allowClear' => true
				],
		]);
		
		echo  $form->field($roDetail, 'RQTY')->textInput(['maxlength' => true, 'placeholder'=>'Jumlah Barang']);
		echo $form->field($roDetail, 'NOTE')->textarea(array('rows'=>2,'cols'=>5))->label('Informasi');		
?>
    <div class="form-group">
        <?= Html::submitButton($roDetail->isNewRecord ? 'Create' : 'Update', ['class' => $roDetail->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    
	<?php ActiveForm::end(); ?>	

