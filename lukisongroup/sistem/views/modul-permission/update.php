<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\password\PasswordInput;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\system\erpmodul\Mdlpermission */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mdlpermission-form">

    <?php $form = ActiveForm::begin([
      'id'=>$model->formName(),
      'enableClientValidation'=>true
    ]); ?>

     <?= $form->field($model, 'username')->textInput()?>

     <!-- $form->field($model, 'old_pass')->textInput()?> -->

      <!-- $form->field($model, 'password_hash')->passwordInput()?> -->
    <?= $form->field($model, 'new_pass')->widget(PasswordInput::classname()) ?>
    <?php
      if(!$model->IsNewRecord)
      {
          echo $form->field($model, 'status')->dropDownList(['' => ' -- Silahkan Pilih --', '1' => 'Tidak Aktif', '10' => 'Aktif']);
      }

     ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
