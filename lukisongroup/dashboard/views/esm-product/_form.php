<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;
use kartik\widgets\DepDrop;
use yii\helpers\Url;

use lukisongroup\master\models\Tipebarang;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\master\models\Suplier;
use lukisongroup\hrd\models\Corp;


$drop = ArrayHelper::map(Corp::find()->where('CORP_STS=1 AND CORP_ID="ESM"')->all(), 'CORP_ID', 'CORP_NM');
$droptype = ArrayHelper::map(Tipebarang::find()->where('STATUS<>3 and PARENT=1')->all(), 'KD_TYPE', 'NM_TYPE');
$dropkat = ArrayHelper::map(Kategori::find()->where('STATUS<>3 and PARENT=1')->all(), 'KD_KATEGORI', 'NM_KATEGORI'); 
$dropunit = ArrayHelper::map(Unitbarang::find()->all(), 'KD_UNIT', 'NM_UNIT');
$dropsup = ArrayHelper::map(Suplier::find()->all(), 'KD_SUPPLIER', 'NM_SUPPLIER');
?>

<div class="barang-form">

    <?php $form = ActiveForm::begin([
			'type' => ActiveForm::TYPE_HORIZONTAL,
			'method' => 'post',
			'id'=>'form-prodak-id',
            'enableClientValidation' => true,
			'options' => ['enctype' => 'multipart/form-data']
		]);
	?>
		<?= $form->field($model, 'PARENT')->hiddenInput(['value'=>1,'maxlength' => true])->label(false) ?>
		<?php 
			
			echo $form->field($model, 'KD_CORP')->dropDownList($drop,[
				'id'=>'barang-kd_corp','readonly'=>true,
				])->label('Perusahaan'); 
		
			echo $form->field($model, 'KD_TYPE')->widget(DepDrop::classname(), [
				'type'=>DepDrop::TYPE_SELECT2,
				'data' => $droptype,
				'options' => ['id'=>'barang-kd_type'],
				'pluginOptions' => [
					'depends'=>['barang-kd_corp'],
					'url'=>Url::to(['/dashboard/esm-product/prodak-corp-type']), /*Parent=0 barang Umum*/
					'initialize'=>true,
				], 		
			]);
			
			echo $form->field($model, 'KD_KATEGORI')->widget(DepDrop::classname(), [
				'type'=>DepDrop::TYPE_SELECT2,
				'data' => $dropkat,
				'options' => ['id'=>'barang-kd_kategori'],
				'pluginOptions' => [
					'depends'=>['barang-kd_corp','barang-kd_type'],
					'url'=>Url::to(['/dashboard/esm-product/prodak-type-kat']),
					'initialize'=>true,
				], 				
			]);
		?>
		<?= $form->field($model, 'NM_BARANG')->textInput(['maxlength' => true]) ?>
		<?= $form->field($model, 'KD_UNIT')->widget(Select2::classname(), [
			'data' => $dropunit,
			'options' => ['placeholder' => 'Pilih KD UNIT ...'],
			'pluginOptions' => [
				'allowClear' => true
				 ],
		]);?>
		
		<?= $form->field($model, 'KD_SUPPLIER')->widget(Select2::classname(), [
			'data' => $dropsup,
			'options' => ['placeholder' => 'Pilih  Nama Supplier ...'],
			'pluginOptions' => [
				'allowClear' => true
				 ],
		]);?>
		
		
		<?php /* $form->field($model, 'KD_DISTRIBUTOR')->widget(Select2::classname(), [
			'data' => $dropdistrubutor,
			'options' => ['placeholder' => 'Pilih KD DISTRIBUTOR  ...'],
			'pluginOptions' => [
				'allowClear' => true
				 ],
		]); */ ?>
		<?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>
		<?= $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']) ?>
		<?php echo $form->field($model, 'image')->widget(FileInput::classname(), [
		'options'=>['accept'=>'image/*'],
		'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']]
		]);
		?>	 
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah Barang' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</div>
		</div>

    <?php ActiveForm::end(); ?>

</div>
