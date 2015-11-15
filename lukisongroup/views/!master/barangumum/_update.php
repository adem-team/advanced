<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;


use lukisongroup\models\master\Kategori;
use lukisongroup\models\master\Unitbarang;
use lukisongroup\models\master\Suplier;
use lukisongroup\models\master\Perusahaan;
use lukisongroup\models\master\Tipebarang;
use lukisongroup\models\hrd\Corp;

use kartik\widgets\FileInput;
/* @var $this yii\web\View */
/* @var $model lukisongroup\models\master\Barangumum */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="barangumum-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL,'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php
        $drop = ArrayHelper::map(Corp::find()->all(), 'CORP_ID', 'CORP_NM');
    ?>
    <?= $form->field($model, 'KD_CORP')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --','disabled'=>true])->label('Group Perusahaan') ?>
    
    <?= $form->field($model, 'KD_BARANG')->textInput(['maxlength' => true, 'readonly'=>true]) ?>

    <?= $form->field($model, 'NM_BARANG')->textInput(['maxlength' => true]) ?>

	<?php
		$drop = ArrayHelper::map(Tipebarang::find()->where(['STATUS' => 1])->all(), 'KD_TYPE', 'NM_TYPE');
	?>
    <?= $form->field($model, 'KD_TYPE')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --'])->label('Type Barang') ?>
	

	<?php
		$drop = ArrayHelper::map(Kategori::find()->where(['STATUS' => 1])->all(), 'KD_KATEGORI', 'NM_KATEGORI');
	?>
    <?= $form->field($model, 'KD_KATEGORI')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --'])->label('Kategori') ?>

	<?php
		$drop = ArrayHelper::map(Unitbarang::find()->where(['STATUS' => 1])->all(), 'KD_UNIT', 'NM_UNIT');
	?>
    <?= $form->field($model, 'KD_UNIT')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --'])->label('Unit') ?>

	<?php
		$drop = ArrayHelper::map(Suplier::find()->where(['STATUS' => 1])->all(), 'KD_SUPPLIER', 'NM_SUPPLIER');
	?>
    <?= $form->field($model, 'KD_SUPPLIER')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --'])->label('Supplier') ?>

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

    <?= $form->field($model, 'UPDATED_BY')->hiddenInput(['value'=>Yii::$app->user->identity->username])->label(false) ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <?= Html::submitButton('<i class="fa fa-pencil"></i>&nbsp;&nbsp; Ubah Barang Umum', ['class' => 'btn btn-primary']) ?>
        </div>
    </div><br/><br/>

    <?php ActiveForm::end(); ?>

</div>
