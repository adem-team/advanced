<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


 ?>

<?php
$form = ActiveForm::begin([
  'id'=>$model->formName(),
  'enableClientValidation' => true,

]);
 ?>

<?= $form->field($model, 'NOMER_FAKTURPAJAK')->textinput()?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
