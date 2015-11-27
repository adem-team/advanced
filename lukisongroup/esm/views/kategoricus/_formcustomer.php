<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\label\LabelInPlace;
use lukisongroup\esm\models\Kategoricus;

/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\Customerskat */
/* @var $form yii\widgets\ActiveForm */
  
   $dropparentkategori = ArrayHelper::map(Kategoricus::find()
                                                                 ->where(['CUST_KTG_PARENT'=>0])
                                                                ->all(),'CUST_KTG', 'CUST_KTG_NM');
 
?>

<div class="customerskat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CUST_KD')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_KD_ALIAS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_GRP')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'parent')->widget(Select2::classname(), [
        
        'data' => $dropparentkategori,
         
        'options' => [
             
//            'id'=>"tes",
        'placeholder' => 'Pilih Parent ...',
            'onchange'=>'
						$.get("/../advanced/lukisongroup/esm/kategoricus/liscus&id="+$(this).val(), function( data ) {
                      $( "select#tes" ).html( data );
                    });'
            ],
         
        'pluginOptions' => [
            
            'allowClear' => true,
             ],

        
    ]);?>
     <?= $form->field($model, 'CUST_KTG')->widget(Select2::classname(), [

        'options' => [
            'id'=>'tes',
        'placeholder' => 'Pilih KD TYPE ...'],
        'pluginOptions' => [
            'allowClear' => true
             ],
        
    ]);?>

   <?= $form->field($model, 'JOIN_DATE')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Enter date ...'],
    'pluginOptions' => [
        'autoclose'=>true
    ]
]);?>

    <?= $form->field($model, 'MAP_LAT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MAP_LNG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PIC')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALAMAT')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'TLP1')->textInput() ?>

    <?= $form->field($model, 'TLP2')->textInput() ?>

    <?= $form->field($model, 'FAX')->textInput() ?>

    <?= $form->field($model, 'EMAIL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'WEBSITE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'NPWP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STT_TOKO')->textInput() ?>

    <?= $form->field($model, 'DATA_ALL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
