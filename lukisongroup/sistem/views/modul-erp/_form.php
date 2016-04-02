<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\sistem\models\Modulerp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modulerp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'MODUL_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MODUL_DCRP')->textarea(['rows' => 6]) ?>

    <!-- $form->field($model, 'MODUL_STS')->textInput() ?> -->
    <?php
    if(!$model->isNewRecord)
    {
     ?>
      <?= $form->field($model, 'MODUL_STS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']) ?>

      <?php
    }
       ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
