<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;
use lukisongroup\models\master\Perusahaan;
use lukisongroup\models\hrd\Corp;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\Suplier */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="suplier-form">

    <?php $form = ActiveForm::begin([
          'id' => 'updatesuplier',
          'enableClientValidation' => true,
    ]); ?>

    <?php
        $drop = ArrayHelper::map(Corp::find()->all(), 'CORP_ID', 'CORP_NM');
    ?>
    <?= $form->field($model, 'KD_CORP')->dropDownList($drop,['prompt'=>' -- Pilih Salah Satu --'])->label('Group Perusahaan') ?>
    
    <?= $form->field($model, 'NM_SUPPLIER')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALAMAT')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'KOTA')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TLP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MOBILE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FAX')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'EMAIL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'WEBSITE')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'IMAGE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']) ?>

   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
