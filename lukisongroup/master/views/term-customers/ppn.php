<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;

 ?>

<?php
$form = ActiveForm::begin([
  'id'=>$Model->formName(),

]);
 ?>

<?= $form->field($Model, 'PPN')->textinput()?>

<div class="form-group">
    <?= Html::submitButton($Model->isNewRecord ? 'Create' : 'Update', ['class' => $Model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
