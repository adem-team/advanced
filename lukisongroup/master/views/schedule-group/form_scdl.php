<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Schedulegroup */
/* @var $form yii\widgets\ActiveForm */
if(count($field_group_nm) == 0)
{
  $group = "anda belum memilih group";
  $btn = Html::a('Back', ['index'], ['class' => 'btn btn-success']);
}else{
  $group =  $field_group_nm->SCDL_GROUP_NM;
  $btn = Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
}

?>

<div class="schedulegroup-form">

    <?php $form = ActiveForm::begin([
      'id'=>$model->formName()
    ]); ?>

     <!-- $form->field($model, 'CusT')->widget(Select2::classname(), [
   'data' => $cari_group,
   'options' => ['placeholder' => 'Select ...'],
   'pluginOptions' => [
       'allowClear' => true
      ],
   ]); ?> -->

    <?= $form->field($model, 'CusT')->textInput(['value' =>$group,'readonly'=>true]) ?>

   <?= $form->field($model, 'GruPCusT')->widget(Select2::classname(), [
   'data' => $cari_cus,
   'options' => ['placeholder' => 'Select ...'],
   'pluginOptions' => [
       'allowClear' => true
   ],
]); ?>


    <div class="form-group">
        <?= $btn ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
