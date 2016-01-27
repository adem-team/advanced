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

use lukisongroup\master\models\Tipebarang;
use lukisongroup\master\models\Barang;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\hrd\models\Corp;

$brgUnit = ArrayHelper::map(Unitbarang::find()->orderBy('NM_UNIT')->all(), 'KD_UNIT', 'NM_UNIT');
$brgKtg = ArrayHelper::map(Kategori::find()->orderBy('NM_KATEGORI')->all(), 'KD_KATEGORI', 'NM_KATEGORI');
$brgAll = ArrayHelper::map(Barang::find()->orderBy('NM_BARANG')->all(), 'KD_BARANG', 'NM_BARANG'); 


$userCorp = ArrayHelper::map(Corp::find()->where('CORP_STS<>3')->all(), 'CORP_ID', 'CORP_NM');
$brgType = ArrayHelper::map(Tipebarang::find()->where('STATUS<>3')->orderBy('NM_TYPE')->all(), 'KD_TYPE', 'NM_TYPE');
$brgUnit = ArrayHelper::map(Unitbarang::find()->orderBy('NM_UNIT')->all(), 'KD_UNIT', 'NM_UNIT');
$brgKtg = ArrayHelper::map(Kategori::find()->where('STATUS<>3')->orderBy('NM_KATEGORI')->all(), 'KD_KATEGORI', 'NM_KATEGORI');
$brgAll = ArrayHelper::map(Barang::find()->where('STATUS<>3')->orderBy('NM_BARANG')->all(), 'KD_BARANG', 'NM_BARANG'); 


/* $this->registerJs("
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};			
    ",$this::POS_HEAD);
 */
	$aryParent= [
		  ['PARENT' => 0, 'PAREN_NM' => 'UMUM'],		  
		  ['PARENT' => 1, 'PAREN_NM' => 'PRODAK'],
	];	
	$valParent = ArrayHelper::map($aryParent, 'PARENT', 'PAREN_NM');
 
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
		 echo $form->field($poDetailValidation, 'pARENT_BRG')->dropDownList($valParent, [
			'id'=>'poplusvalidation-parent_brg'
			])->label('Parent Barang');
		 echo $form->field($poDetailValidation, 'kD_CORP')->dropDownList($userCorp,[
				'id'=>'poplusvalidation-kd_corp',
				'prompt'=>' -- Pilih Salah Satu --',
			])->label('Perusahaan'); 
	
		echo $form->field($poDetailValidation, 'kD_TYPE')->widget(DepDrop::classname(), [
			'type'=>DepDrop::TYPE_SELECT2,
			'data' => $brgType,
			'options' => ['id'=>'poplusvalidation-kd_type'],
			'pluginOptions' => [
				'depends'=>['poplusvalidation-kd_corp','poplusvalidation-parent_brg'],
				'url'=>Url::to(['/purchasing/purchase-order/corp-type']), /*Parent=0 barang Umum*/
				'initialize'=>true,
			], 		
		]);
		
		echo $form->field($poDetailValidation, 'kD_KATEGORI')->widget(DepDrop::classname(), [
			'type'=>DepDrop::TYPE_SELECT2,
			'data' => $brgKtg,
			'options' => ['id'=>'poplusvalidation-kd_kategori'],
			'pluginOptions' => [
				'depends'=>['poplusvalidation-kd_corp','poplusvalidation-kd_type'],
				'url'=>Url::to(['/purchasing/purchase-order/type-kat']),
				'initialize'=>true,
			], 		
		]);
		 
		echo $form->field($poDetailValidation, 'kD_BARANG')->widget(DepDrop::classname(), [
			'type'=>DepDrop::TYPE_SELECT2,
			'data' => $brgAll,
			'options' => ['id'=>'poplusvalidation-kd_barang'],
			'pluginOptions' => [
				'depends'=>['poplusvalidation-kd_kategori'],
				'url'=>Url::to(['/purchasing/purchase-order/brgkat']),
				'initialize'=>true,
			], 		
		]);
		
		echo $form->field($poDetailValidation, 'nM_BARANG')->hiddenInput(['value' => ''])->label(false);
		echo $form->field($poDetailValidation, 'uNIT')->widget(Select2::classname(), [
				'data' => $brgUnit,
				'options' => ['placeholder' => 'Pilih Unit Barang ...'],
				'pluginOptions' => [
					'allowClear' => true
				],
		]);
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 //echo $form->field($poDetailValidation, 'kD_KATEGORI')->dropDownList($brgKtg, ['id'=>'poplusvalidation-kd_kategori']);
		 
		 // echo $form->field($poDetailValidation, 'kD_KATEGORI')->widget(DepDrop::classname(), [
			// 'type'=>DepDrop::TYPE_SELECT2,
			// 'data' => $brgKtg,
			// 'options' => ['id'=>'poplusvalidation-kd_kategori'],
			// 'pluginOptions' => [
				// 'depends'=>['poplusvalidation-parent_brg'],
				// 'url'=>Url::to(['/purchasing/purchase-order/brgkat']),
				// 'initialize'=>true,
			// ], 		
		// ]);
		 
		 // echo $form->field($poDetailValidation, 'kD_BARANG')->widget(DepDrop::classname(), [
			// 'type'=>DepDrop::TYPE_SELECT2,
			// 'data' => $brgAll,
			// 'options' => ['id'=>'poplusvalidation-kd_barang'],
			// 'pluginOptions' => [
				// 'depends'=>['poplusvalidation-kd_kategori'],
				// 'url'=>Url::to(['/purchasing/purchase-order/cari-brg']),
				// 'initialize'=>true,
			// ], 		
		// ]);
				
		// echo $form->field($poDetailValidation, 'uNIT')->widget(Select2::classname(), [
				// 'data' => $brgUnit,
				// 'options' => ['placeholder' => 'Pilih Unit Barang ...'],
				// 'pluginOptions' => [
					// 'allowClear' => true
				// ],
		// ]);
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

