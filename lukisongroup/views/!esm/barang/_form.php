<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;

use lukisongroup\models\esm\Unitbarang;
use lukisongroup\models\esm\Distributor;
use lukisongroup\models\esm\Barangmaxi;
use lukisongroup\models\master\Kategori;
use lukisongroup\models\master\Tipebarang;

use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\Barang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="barang-form">

    <?php $form = ActiveForm::begin([
			'type' => ActiveForm::TYPE_HORIZONTAL,
			'method' => 'post',
			'action' => ['esm/barang/simpan'],
			'options' => ['enctype' => 'multipart/form-data']
		]);
	?>

    <?= $form->field($model, 'NM_BARANG')->textInput(['maxlength' => true]) ?>
	
	
	<?php $drop = ArrayHelper::map(Tipebarang::find()->where(['STATUS' => 1])->all(), 'KD_TYPE', 'NM_TYPE'); ?>
    <?= $form->field($model, 'KD_TYPE')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --'])->label('Type Barang') ?>
	
	<?php $drop = ArrayHelper::map(Kategori::find()->where(['STATUS' => 1])->all(), 'KD_KATEGORI', 'NM_KATEGORI'); ?>
    <?= $form->field($model, 'KD_KATEGORI')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --'])->label('Kategori') ?>
	
	
	<?php
		$drop = ArrayHelper::map(Unitbarang::find()->all(), 'ID', 'NM_UNIT');
	?>
    <?= $form->field($model, 'KD_UNIT')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --']) ?>
	
	<?php
		$drop = ArrayHelper::map(Distributor::find()->all(), 'KD_DISTRIBUTOR', 'NM_DISTRIBUTOR');
	?>
    <?= $form->field($model, 'KD_DISTRIBUTOR')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --']) ?>

	
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

    <?= $form->field($model, 'CREATED_BY')->hiddenInput(['value'=>Yii::$app->user->identity->username])->label(false) ?>
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah Barang' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
