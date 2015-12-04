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
use yii\web\JsExpression;


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
	// $dropcity = ArrayHelper::map(Kota::find()->all(),'POSTAL_CODE','CITY_NAME');
// print_r( $dropparentkategori);
// die();
 
?>

<div class="customerskat-form">

    <?php $form = ActiveForm::begin([
	'id'=>'createkat',
	'enableClientValidation' => true
	
	
	]); ?>



    <?= $form->field($model, 'CUST_KD_ALIAS')->textInput(['maxlength' => true]) ?>

	  <?= $form->field($model, 'CUST_NM', $config)->widget(LabelInPlace::classname());?>

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
        // 'data' => $dropcity,
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
 

    <?= $form->field($model, 'ALAMAT', $config)->widget(LabelInPlace::classname());?>

    <?= $form->field($model, 'WEBSITE', $config)->widget(LabelInPlace::classname());?>

    <?= $form->field($model, 'NOTE', $config)->widget(LabelInPlace::classname());?>

      <?= $form->field($model, 'NPWP', $config)->widget(LabelInPlace::classname());?>
	  
	  

    <?= $form->field($model, 'STT_TOKO')->textInput() ?>

    <?= $form->field($model, 'DATA_ALL')->textInput(['maxlength' => true]) ?>
	
	<?php
	if(!$model->isNewRecord )
	{
		echo $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']) ;
	}
	
	
	?>
	
	<?= $form->field($model, 'MAP_LNG')->textInput(['maxlength' => true,'readonly'=>true]) ?>
	<?= $form->field($model, 'MAP_LAT')->textInput(['maxlength' => true,'readonly'=>true]) ?>
   <?php
   
    echo \pigolab\locationpicker\LocationPickerWidget::widget([
       // 'key' => 'http://maps.google.com/maps/api/js?sensor=false&libraries=places', // optional , Your can also put your google map api key
       'options' => [
            'style' => 'width: 100%; height: 400px', // map canvas width and height
        ] ,
        'clientOptions' => [
            'location' => [
                'latitude'  => -6.214620,
                'longitude' => 106.845130 ,
			
            ],
            'radius'    => 300,
            'inputBinding' => [
                'latitudeInput'     => new JsExpression("$('#customers-map_lat')"),
                 'longitudeInput'    => new JsExpression("$('#customers-map_lng')"),
                // 'radiusInput'       => new JsExpression("$('#us2-radius')"),
                // 'locationNameInput' => new JsExpression("$('#us2-address')")
            ]
        ]        
    ]);
?>

     
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php

$script = <<<SKRIPT
	
	 $('select#customers-province_id').change(function(){
        var id = $(this).val();
	
		
         $.get('/esm/customers/lisarea',{id : id},
             function( data ) {
     $( 'select#customers-city_id' ).html( data );
           // alert(data);
                        });
                    });
	
        
    $('#slect').change(function(){
        var id = $(this).val();
        $.get('/esm/customers/lis',{id : id},
            function( data ) {
     $( 'select#customers-cust_ktg' ).html( data );
 
                        });
                    });
SKRIPT;

$this->registerJs($script);

