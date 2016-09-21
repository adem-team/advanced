<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\widget\Pilotproject */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pilotproject-form">

    <?php $form = ActiveForm::begin([
      'id'=> 'create',
      'enableClientValidation'=> true

    ]); ?>
	
	
	<?= $form->field($model, 'PILOT_NM')->textInput() ?>
	
    <?= $form->field($model, 'DSCRP')->textInput() ?>
	
 

     <?= $form->field($model, 'PLAN_DATE1')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Enter date ...'],
    'pluginOptions' => [
        'autoclose'=>true
    ],
    'pluginEvents' => [
                      'show' => "function(e) {show}",
    ],
]);?>


  

     <?= $form->field($model, 'PLAN_DATE2')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Enter date ...'],
    'pluginOptions' => [
        'autoclose'=>true
    ],
    'pluginEvents' => [
                      'show' => "function(e) {show}",
    ],
]);?>

    

     <!--$form->field($model, 'ACTUAL_DATE1')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Enter date ...'],
    'pluginOptions' => [
        'autoclose'=>true
    ],
    'pluginEvents' => [
                      'show' => "function(e) {show}",
    ],
]);?>-->

   


      <!--$form->field($model, 'ACTUAL_DATE2')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Enter date ...'],
    'pluginOptions' => [
        'autoclose'=>true
    ],
    'pluginEvents' => [
                      'show' => "function(e) {show}",
    ],
]);?>-->

    <?=  $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']) ; ?>

   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
