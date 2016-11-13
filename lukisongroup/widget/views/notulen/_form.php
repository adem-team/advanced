<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;


/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\Notulen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notulen-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--  $form->field($model, 'start')->textInput() ?>

     $form->field($model, 'end')->textInput() ?> -->

    <?= $form->field($model, 'title')->textArea(['maxlength' => true]) ?>

     <!-- $form->field($model, 'USER_ID')->textInput(['maxlength' => true]) ?> -->

     <!-- $form->field($model, 'MODUL')->textInput(['maxlength' => true]) ?> -->

      <?=  $form->field($model, 'USER_ID')->widget(Select2::classname(), [
        'data' => $data_emp,
        'options' => ['placeholder' => 'Select ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    
    <!-- Usage with ActiveForm and model -->
    <?=  $form->field($model, 'MODUL')->widget(Select2::classname(), [
        'data' => $data_modul,
        'options' => ['placeholder' => 'Select ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?php if(!$model->isNewRecord) { ?>
    <?= $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']) ?>
    <?php }?>
     <!-- $form->field($model, 'STATUS')->textInput() ?> -->

   <!--   $form->field($model, 'CREATE_BY')->textInput(['maxlength' => true]) ?>

     $form->field($model, 'CREATE_AT')->textInput() ?>

    $form->field($model, 'UPDATE_BY')->textInput(['maxlength' => true]) ?>

     $form->field($model, 'UPDATE_AT')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
