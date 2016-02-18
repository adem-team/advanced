<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Termgeneral */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="termgeneral-form">

    <?php $form = ActiveForm::begin([
      'id'=>$model->formName(),
      'enableClientValidation' => true,
    ]); ?>

    <?= $form->field($model, 'SUBJECT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ISI_TERM')->textarea(['rows' => 6]) ?>

    <?php
      if(!$model->IsNewRecord)
      {
        	echo $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']);
      }

     ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
