<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Schedulegroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="schedulegroup-form">

    <?php $form = ActiveForm::begin([
      'id'=>$model->formName()
    ]); ?>

    <?= $form->field($model, 'SCDL_GROUP_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KETERANGAN')->textarea(['rows' => 6]) ?>

    <?php
      if(!$model->IsNewRecord)
      {
          echo $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']);
      }

     ?>

    <!-- $form->field($model, 'CREATE_BY')->textInput(['maxlength' => true]) ?> -->

     <!-- $form->field($model, 'CREATE_AT')->textInput() ?> -->

     <!-- $form->field($model, 'UPDATE_BY')->textInput(['maxlength' => true]) ?> -->

     <!-- $form->field($model, 'UPDATE_AT')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
