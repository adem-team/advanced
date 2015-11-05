<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\SwitchInput

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\master\Unitbarang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unitbarang-form">

    <?php $form = ActiveForm::begin([
		'type' => ActiveForm::TYPE_HORIZONTAL,
		'method' => 'post',
		'action' => ['master/unitbarang/simpan'],]); ?>

    <?php //= $form->field($model, 'KD_UNIT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NM_UNIT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SIZE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'WIGHT')->textInput() ?>

    <?= $form->field($model, 'COLOR')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'CREATED_BY')->hiddenInput(['value'=>Yii::$app->user->identity->username])->label(false) ?>
    <?= $form->field($model, 'CREATED_AT')->hiddenInput(['value'=>date('Y-m-d H:i:s')])->label(false) ?>
    <?= $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']) ?>
    <?php //= $form->field($model, 'STATUS')->textInput() ?>

  <div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah Unit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
