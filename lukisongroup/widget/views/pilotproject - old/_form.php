<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\widget\Pilotproject */
/* @var $form yii\widgets\ActiveForm */


 $dropemploy = ArrayHelper::map(\lukisongroup\hrd\models\Employe::find()->all(), 
                                                                      'EMP_ID', 'EMP_NM');
 
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

    

  

<?= $form->field($model, 'DESTINATION_TO')->widget(Select2::classname(), [
         'data' => $dropemploy,
        'options' => [
//            'id'=>'parent',
        'placeholder' => 'Pilih Karyawan ...'],
        'pluginOptions' => [
            'allowClear' => true
             ],
        
    ]);?>

    <?=  $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => ' Aktif', '1' => 'Tidak Aktif']) ; ?>

   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
