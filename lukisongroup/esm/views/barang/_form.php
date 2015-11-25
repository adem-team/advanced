<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

use lukisongroup\esm\models\Unitbarang;
use lukisongroup\esm\models\Distributor;
use lukisongroup\esm\models\Barangmaxi;
use lukisongroup\master\models\Kategori;
use lukisongroup\master\models\Tipebarang;

use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\Barang */
/* @var $form yii\widgets\ActiveForm */


$droptype = ArrayHelper::map(Tipebarang::find()->where(['STATUS' => 1])->all(), 'KD_TYPE', 'NM_TYPE');
$dropdistrubutor = ArrayHelper::map(Distributor::find()->all(), 'KD_DISTRIBUTOR', 'NM_DISTRIBUTOR');
$dropkat = ArrayHelper::map(Kategori::find()->where(['STATUS' => 1])->all(), 'KD_KATEGORI', 'NM_KATEGORI'); 
$dropunit = ArrayHelper::map(Unitbarang::find()->all(), 'KD_UNIT', 'NM_UNIT');
?>

<div class="barang-form">

    <?php $form = ActiveForm::begin([
			'type' => ActiveForm::TYPE_HORIZONTAL,
			'method' => 'post',
			 'id'=>'form-umum',
             'enableClientValidation' => true,
			'options' => ['enctype' => 'multipart/form-data']
		]);
	?>

    <?= $form->field($model, 'NM_BARANG')->textInput(['maxlength' => true]) ?>
	
	
	  <?= $form->field($model, 'KD_TYPE')->widget(Select2::classname(), [
        'data' => $droptype,
        'options' => ['placeholder' => 'Pilih KD TYPE ...'],
        'pluginOptions' => [
            'allowClear' => true
             ],
    ]);?>
	
	
    
	 <?= $form->field($model, 'KD_KATEGORI')->widget(Select2::classname(), [
        'data' => $dropkat,
        'options' => ['placeholder' => 'Pilih  KD_KATEGORI ...'],
        'pluginOptions' => [
            'allowClear' => true
             ],
    ]);?>
	
	
	
	
      <?= $form->field($model, 'KD_UNIT')->widget(Select2::classname(), [
        'data' => $dropunit,
        'options' => ['placeholder' => 'Pilih KD UNIT ...'],
        'pluginOptions' => [
            'allowClear' => true
             ],
    ]);?>
	
	

	    <?= $form->field($model, 'KD_DISTRIBUTOR')->widget(Select2::classname(), [
        'data' => $dropdistrubutor,
        'options' => ['placeholder' => 'Pilih KD DISTRIBUTOR  ...'],
        'pluginOptions' => [
            'allowClear' => true
             ],
    ]);?>

	
	<?php echo $form->field($model, 'image')->widget(FileInput::classname(), [
	'options'=>['accept'=>'image/*'],
	'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']]
	]);
	?>

    <?= $form->field($model, 'HPP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'HARGA')->textInput() ?>

    <?= $form->field($model, 'BARCODE')->textInput() ?>

    <?= $form->field($model, 'NOTE')->textInput() ?>

    <?= $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']) ?>

 
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah Barang' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
