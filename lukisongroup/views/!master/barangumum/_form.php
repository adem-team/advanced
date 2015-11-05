<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\widgets\SwitchInput;
use yii\helpers\ArrayHelper;
	
use lukisongroup\models\master\Kategori;
use lukisongroup\models\master\Unitbarang;
use lukisongroup\models\master\Suplier;
//use lukisongroup\models\master\Perusahaan;
use lukisongroup\models\master\Tipebarang;
use lukisongroup\models\hrd\Corp;

use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\master\Barangumum */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="barangumum-form">

    <?php $form = ActiveForm::begin([
		'type' => ActiveForm::TYPE_HORIZONTAL,
		'method' => 'post',
		'action' => ['master/barangumum/simpan'],
		'options' => ['enctype' => 'multipart/form-data']
		]);
	?>

    <?php $drop = ArrayHelper::map(Corp::find()->all(), 'CORP_ID', 'CORP_NM'); ?>
    <?= $form->field($model, 'KD_CORP')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --'])->label('Group Perusahaan') ?>
    
    <?= $form->field($model, 'NM_BARANG')->textInput(['maxlength' => true]) ?>

	<?php $drop = ArrayHelper::map(Tipebarang::find()->where(['STATUS' => 1])->all(), 'KD_TYPE', 'NM_TYPE'); ?>
    <?= $form->field($model, 'KD_TYPE')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --'])->label('Type Barang') ?>

	<?php $drop = ArrayHelper::map(Kategori::find()->where(['STATUS' => 1])->all(), 'KD_KATEGORI', 'NM_KATEGORI'); ?>
    <?= $form->field($model, 'KD_KATEGORI')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --'])->label('Kategori') ?>

	<?php $drop = ArrayHelper::map(Unitbarang::find()->where(['STATUS' => 1])->all(), 'KD_UNIT', 'NM_UNIT'); ?>
    <?= $form->field($model, 'KD_UNIT')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --'])->label('Unit') ?>

	<?php $drop = ArrayHelper::map(Suplier::find()->where(['STATUS' => 1])->all(), 'KD_SUPPLIER', 'NM_SUPPLIER'); ?>
    <?= $form->field($model, 'KD_SUPPLIER')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --'])->label('Supplier') ?>

    <!-- ?= $form->field($model, 'KD_DISTRIBUTOR')->textInput(['maxlength' => true]) ? -->

    <?= $form->field($model, 'PARENT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'HPP')->textInput() ?>

    <?= $form->field($model, 'HARGA')->textInput() ?>

    <?= $form->field($model, 'BARCODE')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'image')->widget(FileInput::classname(), [
    'options'=>['accept'=>'image/*'],
    'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']]
	]);
	?>

    <?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'KD_CAB')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KD_DEP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']) ?>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah Barang' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
    </div>

    <?= $form->field($model, 'CREATED_BY')->hiddenInput(['value'=>Yii::$app->user->identity->username])->label(false) ?>
    <?= $form->field($model, 'CREATED_AT')->hiddenInput(['value'=>date('Y-m-d H:i:s')])->label(false) ?>
    
    <?php ActiveForm::end(); ?>

</div>
