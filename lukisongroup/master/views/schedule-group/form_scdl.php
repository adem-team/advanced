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

    <?= $form->field($model, 'CusT')->widget(Select2::classname(), [
   'data' => $cari_group,
   'options' => ['placeholder' => 'Select ...'],
   'pluginOptions' => [
       'allowClear' => true
      ],
   ]); ?>

   <?= $form->field($model, 'GruPCusT')->widget(Select2::classname(), [
   'data' => $cari_cus,
   'options' => ['placeholder' => 'Select ...'],
   'pluginOptions' => [
       'allowClear' => true
   ],
]); ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
