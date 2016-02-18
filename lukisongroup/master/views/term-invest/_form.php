<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Terminvest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="terminvest-form">

    <?php $form = ActiveForm::begin([
      'id'=>$model->formName(),
      'enableClientValidation'=>true
    ]); ?>

    <?= $form->field($model, 'INVES_TYPE')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'KETERANGAN')->textarea(['rows' => 6]) ?>

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
