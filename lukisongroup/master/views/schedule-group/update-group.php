<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Schedulegroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schedulegroup-form">

    <?php $form = ActiveForm::begin([
      'id'=>$model->formName()
    ]); ?>

    <?= $form->field($model, 'CUST_NM')->textInput(['maxlength' => true]) ?>

     <!-- $form->field($model, 'custgrp.SCDL_GROUP_NM')->textarea(['rows' => 6]) ?> -->

    <?= $form->field($model, 'SCDL_GROUP')->widget(Select2::classname(), [
    'data' => $data,
    'language' => 'us',
    'options' => ['placeholder' => 'Select  ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]) ?>

    <?php
      if(!$model->IsNewRecord)
      {
          echo $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']);
      }

     ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
        'data' => [
            'confirm' => 'Are you sure Change Group?',
        ],]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
