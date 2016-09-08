<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
use kartik\daterange\DateRangePicker;
use kartik\widgets\SwitchInput;


/* @var $this yii\web\View */
/* @var $model lukisongroup\models\widget\Pilotproject */
/* @var $form yii\widgets\ActiveForm */
$gv_id = Yii::$app->getUserOpt->Profile_user()->emp->GF_ID;

$dep_id = Yii::$app->getUserOpt->Profile_user()->emp->DEP_ID;

  if($gv_id <= 4  && $model->DEP_ID == $dep_id || $model->CREATED_BY == $created && $model->TYPE == 1)
    {
      $btn_close = Html::a('CLOSE', ['/widget/pilotproject/close','id'=>$model->ID,'parent'=>$model->PARENT,'sort'=>$sort], ['class'=>'btn btn-danger','data-confirm'=>'are you sure ?']);
    }else{
      $btn_close = '';
    }
?>

<div class="pilotproject-form">

    <?php $form = ActiveForm::begin([
      'id'=> $model->formName(),
      // 'enableClientValidation'=> true,
      //  'enableAjaxValidation'=>true,
      //   'validationUrl'=>Url::toRoute('/widget/pilotproject/valid')

    ]); ?>
	


  
	  <?= $form->field($model, 'PILOT_NM')->textInput() ?>
    
	
    <?= $form->field($model, 'DSCRP')->textInput() ?>


   <!--  $form->field($model, 'DESTINATION_TO')->widget(Select2::classname(), [
         'data' => $dropemploy,
        'options' => [
        'placeholder' => 'Pilih Karyawan ...'],
        'pluginOptions' => [
            'allowClear' => true
             ],
        
    ]);?> -->
	
    <?php
    if($model->CREATED_BY == $created )
        {

      ?>
    <?= $form->field($model, 'PLAN_DATE1')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Enter...',
            'value'=>$tgl
          ],
        'pluginOptions' => [
            'autoclose'=>true
        ],
        'pluginEvents' => [
                          'show' => "function(e) {show}",
        ],
    ]);?>


    <?= $form->field($model, 'PLAN_DATE2')->widget(DatePicker::classname(), [
         'options' => ['placeholder' => 'Enter...',
            'value'=>$tgl_1
          ],
        'pluginOptions' => [
            'autoclose'=>true
        ],
        'pluginEvents' => [
                          'show' => "function(e) {show}",
        ],
    ]);?>

    <?php
      }

    ?>

   

      <!--$form->field($model, 'ACTUAL_DATE2')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Enter date ...'],
    'pluginOptions' => [
        'autoclose'=>true
    ],
    'pluginEvents' => [
                      'show' => "function(e) {show}",
    ],
]);?>-->

     <!--  $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']) ; ?> -->

   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?= $btn_close ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


