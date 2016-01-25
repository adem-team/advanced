<?php

use \Yii;
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\helpers\Url;
use kartik\builder\Form;
use kartik\widgets\TouchSpin;
use yii\web\JsExpression;
use yii\data\ActiveDataProvider;

use lukisongroup\purchasing\models\ro\RodetailSearch;

use lukisongroup\master\models\Tipebarang;
use lukisongroup\master\models\Barang;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\hrd\models\Corp;

$userCorp = ArrayHelper::map(Corp::find()->all(), 'CORP_ID', 'CORP_NM');
$brgType = ArrayHelper::map(Tipebarang::find()->where(['PARENT'=>0])->orderBy('NM_TYPE')->all(), 'KD_TYPE', 'NM_TYPE');
$brgUnit = ArrayHelper::map(Unitbarang::find()->orderBy('NM_UNIT')->all(), 'KD_UNIT', 'NM_UNIT');
$brgKtg = ArrayHelper::map(Kategori::find()->where(['PARENT'=>0,'STATUS'=>1])->orderBy('NM_KATEGORI')->all(), 'KD_KATEGORI', 'NM_KATEGORI');
$brgUmum = ArrayHelper::map(Barang::find()->where(['PARENT'=>0,'STATUS'=>1])->orderBy('NM_BARANG')->all(), 'KD_BARANG', 'NM_BARANG'); 
?>
	<?php
	/*
	 * DESCRIPTION FORM AddItem
	 * Form Add Items Hanya ada pada Form Edit | ACTION addItem
	 * Items Barang tidak bisa di input Duplicated. | Unix by KD_RO dan KD_BARANG
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	?>
	
	<div  style="padding-top:20">
		<!-- Render create form -->  
			<?php 		
			/* echo $this->render('_form', [   					
						'roDetail' => $roDetail,
					]); */
			?>
			<?php
				$form = ActiveForm::begin([
					'id'=>'additem-update',
					'enableClientValidation' => true,
					'enableAjaxValidation' => true,
					'method' => 'post',
					'action' => ['/purchasing/request-order/additem_saved'],
				]);
				
			
			echo $form->field($roDetail, 'kD_CORP')->dropDownList($userCorp,[
				'id'=>'additemvalidation-kd_corp',
				'prompt'=>' -- Pilih Salah Satu --',
			])->label('Perusahaan'); 
			
			echo $form->field($roDetail, 'kD_TYPE')->widget(DepDrop::classname(), [
				'type'=>DepDrop::TYPE_SELECT2,
				'data' => $brgType,
				'options' => ['id'=>'additemvalidation-kd_type'],
				'pluginOptions' => [
					'depends'=>['additemvalidation-kd_corp'],
					'url'=>Url::to(['/purchasing/request-order/corp-type']), /*Parent=0 barang Umum*/
					'initialize'=>true,
				], 		
			]);
			
			echo $form->field($roDetail, 'kD_KATEGORI')->widget(DepDrop::classname(), [
				'type'=>DepDrop::TYPE_SELECT2,
				'data' => $brgKtg,
				'options' => ['id'=>'additemvalidation-kd_kategori'],
				'pluginOptions' => [
					'depends'=>['additemvalidation-kd_corp','additemvalidation-kd_type'],
					'url'=>Url::to(['/purchasing/request-order/type-kat']),
					'initialize'=>true,
				], 		
			]);
			?>
			<?php  echo $form->field($roDetail, 'cREATED_AT',['template' => "{input}"])->hiddenInput(['value'=>date('Y-m-d H:i:s'),'readonly' => true]) ?>
			<?php  echo $form->field($roDetail, 'kD_RO',['template' => "{input}"])->textInput(['value'=>$roHeader->KD_RO,'type' =>'hidden']) ?>

			<?php
				echo $form->field($roDetail, 'hARGA')->hiddenInput(['value' => ''])->label(false);
				echo $form->field($roDetail, 'kD_BARANG')->widget(DepDrop::classname(), [
					'type'=>DepDrop::TYPE_SELECT2,
					'data' => $brgUmum,
					'options' => ['id'=>'additemvalidation-kd_barang'],
					'pluginOptions' => [
						'depends'=>['additemvalidation-kd_kategori'],
						'url'=>Url::to(['/purchasing/request-order/brgkat']),
						'initialize'=>true,
					], 		
				]); 
				
				/* echo $form->field($roDetail, 'uNIT')->widget(DepDrop::classname(), [
					'type'=>DepDrop::TYPE_DEFAULT,
					'data' => $brgUnit,
					'options' => ['id'=>'unit-id','readonly'=>true,'selected'=>false],
					'pluginOptions' => [
						'depends'=>['additemvalidation-kd_kategori','additemvalidation-kd_barang'],
						'url'=>Url::to(['/purchasing/request-order/brgunit']),
						'initialize'=>true, 
						'placeholder' => false,
					], 		
				]);   */
				
				echo $form->field($roDetail, 'uNIT')->widget(Select2::classname(), [
						'data' => $brgUnit,
						'options' => ['placeholder' => 'Pilih Unit Barang ...'],
						'pluginOptions' => [
							'allowClear' => true
						],
					]);
				
				
			?>
		
			<?php echo  $form->field($roDetail, 'rQTY')->textInput(['maxlength' => true, 'placeholder'=>'Jumlah Barang']); ?>

			<?php echo $form->field($roDetail, 'nOTE')->textarea(array('rows'=>2,'cols'=>5))->label('Informasi');?>

		    <div class="form-group">
				<?php //echo Html::submitButton($roDetail->isNewRecord ? 'Save' : 'Update', ['class' => $roDetail->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
				<?php echo Html::submitButton('SAVE',['class' => 'btn btn-primary']); ?>
			</div>			
			<?php ActiveForm::end(); ?>
			</div>		
</div>

