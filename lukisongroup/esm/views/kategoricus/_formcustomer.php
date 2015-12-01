<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\label\LabelInPlace;
use lukisongroup\esm\models\Kategoricus;
use lukisongroup\esm\models\Province;
use lukisongroup\esm\models\Kota;


/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\Customerskat */
/* @var $form yii\widgets\ActiveForm */
  
     $dropdis = ArrayHelper::map(\lukisongroup\esm\models\Distributor::find()->all(), 'KD_DISTRIBUTOR', 'NM_DISTRIBUTOR');
         $config = ['template'=>"{input}\n{error}\n{hint}"];  
// $dropparent = ArrayHelper::map(\lukisongroup\esm\models\Kategori::find()->all(),'CUST_KTG_PARENT', 'CUST_KTG_NM'); 
   $no = 0;
   $dropparentkategori = ArrayHelper::map(Kategoricus::find()
                                                                ->where(['CUST_KTG_PARENT'=>$no])
                                                                ->all(),'CUST_KTG', 'CUST_KTG_NM');
	$droppro = ArrayHelper::map(Province::find()->all(),'PROVINCE_ID','PROVINCE');
	$dropcity = ArrayHelper::map(Kota::find()->all(),'POSTAL_CODE','CITY_NAME');
// print_r( $dropparentkategori);
// die();
 
?>

<div class="customerskat-form">

    <?php $form = ActiveForm::begin([
	'id'=>'createkat',
	'enableClientValidation' => true
	
	
	]); ?>



    <?= $form->field($model, 'CUST_KD_ALIAS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CUST_GRP')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'TLP2', $config)->widget(LabelInPlace::classname());?>
    
    <?= $form->field($model, 'FAX')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'EMAIL', $config)->widget(LabelInPlace::classname());?>
    
    <?= $form->field($model, 'TLP1', $config)->widget(LabelInPlace::classname());?>
    
     <?= $form->field($model, 'parent')->widget(Select2::classname(), [
        'data' => $dropparentkategori,
        'options' => [
         'id'=>"slect",
        'placeholder' => 'Pilih Parent ...'],
        'pluginOptions' => [
            'allowClear' => true,
             ],

        
    ]);?>
	
	   <?= $form->field($model, 'CUST_KTG')->widget(Select2::classname(), [

        'options' => [
//            'id'=>'parent',
        'placeholder' => 'Pilih customer kategory ...'],
        'pluginOptions' => [
            'allowClear' => true
             ],
        
    ]);?>
	
	<?= $form->field($model, 'PROVINCE_ID')->widget(Select2::classname(), [
        'data' => $droppro,
        'options' => [
        'placeholder' => 'Pilih Provinci ...'],
        'pluginOptions' => [
            'allowClear' => true,
             ],

        
    ]);?>
	
	<?= $form->field($model, 'CITY_ID')->widget(Select2::classname(), [
        'data' => $dropcity,
        'options' => [
        'placeholder' => 'Pilih kota ...'],
        'pluginOptions' => [
            'allowClear' => true,
             ],

        
    ]);?>
    
  
    
     <?= $form->field($model, 'PIC', $config)->widget(LabelInPlace::classname());?>

 <?= $form->field($model, 'JOIN_DATE')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Enter date ...'],
    'pluginOptions' => [
        'autoclose'=>true
    ],
	'pluginEvents' => [
			          'show' => "function(e) {show}",
	],
]);?>


  <?= $form->field($model, 'KD_DISTRIBUTOR')->widget(Select2::classname(), [
		     'data' => $dropdis,
        'options' => [
//            'id'=>'parent',
        'placeholder' => 'Pilih Distributor ...'],
        'pluginOptions' => [
            'allowClear' => true
             ],
        
    ]);?>
 

    <?= $form->field($model, 'ALAMAT')->textarea(['rows' => 6]) ?>



    <?= $form->field($model, 'WEBSITE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NOTE')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'NPWP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STT_TOKO')->textInput() ?>

    <?= $form->field($model, 'DATA_ALL')->textInput(['maxlength' => true]) ?>
   
 

   <?= $form->field($model, 'MAP_LAT')->textInput(['maxlength' => true,'readonly'=>true]) ?>
    
     <?= $form->field($model, 'MAP_LNG')->textInput(['maxlength' => true,'readonly'=>true]) ?>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<<SKRIPT
        
    $('#slect').change(function(){
        var id = $(this).val();
        $.get('/esm/kategoricus/lis',{id : id},
            function( data ) {
     $( 'select#customerskat-cust_ktg' ).html( data );
//            alert(data);
                        });
                    });
SKRIPT;

$this->registerJs($script);

