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
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\DepDrop;


/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\Customerskat */
/* @var $form yii\widgets\ActiveForm */
  
     $dropdis = ArrayHelper::map(\lukisongroup\esm\models\Distributor::find()->all(), 'KD_DISTRIBUTOR', 'NM_DISTRIBUTOR');
         $config = ['template'=>"{input}\n{error}\n{hint}"];  
// $dropparent = ArrayHelper::map(\lukisongroup\esm\models\Kategori::find()->all(),'CUST_KTG_PARENT', 'CUST_KTG_NM'); 
   $no = 0;
   $dropparentkategori = ArrayHelper::map(Kategoricus::find()->where(['CUST_KTG_PARENT'=>$no])
                                                             ->asArray()  
                                                             ->all(),'CUST_KTG', 'CUST_KTG_NM');

                                                             
     
	$droppro = ArrayHelper::map(Province::find()->asArray() 
                                              ->all(),'PROVINCE_ID','PROVINCE');
	// $dropcity = ArrayHelper::map(Kota::find()->all(),'POSTAL_CODE','CITY_NAME');
// print_r( $dropparentkategori);
// die();
    // Modal::begin([
    //          'header'=>'<h4>Vlookup</h4>',
    //          'id'=> 'modal',
    //          'size'=>'modal-lg',
    //      ]);
    //      echo"<div id='modalcalon'></div>";
    //      modal::end();
 
?>

<div class="customerskat-form">

    <?php $form = ActiveForm::begin([
	'id'=>'createkat',
	'enableClientValidation' => true
	
	
	]); ?>



    

	  <?= $form->field($model, 'CUST_NM', $config)->widget(LabelInPlace::classname());?>

    <?= $form->field($model, 'CUST_GRP')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'TLP2', $config)->widget(LabelInPlace::classname());?>
    
    <?= $form->field($model, 'FAX')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'EMAIL', $config)->widget(LabelInPlace::classname());?>
    
    <?= $form->field($model, 'TLP1', $config)->widget(LabelInPlace::classname());?>
    

   <?=  $form->field($model, 'PARENT')->widget(Select2::classname(), 

    [
    'options'=>[  'placeholder' => 'Select Customers parent ...'
    ],
    'data' => $dropparentkategori


]);?>
  

   <?= $form->field($model, 'CUST_KTG')->widget(DepDrop::classname(), [
    'options' => [//'id'=>'customers-cust_ktg',
    'placeholder' => 'Select Customers kategory'],
    'type' => DepDrop::TYPE_SELECT2,
    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
    'pluginOptions'=>[
        'depends'=>['customers-parent'],
        'url' => Url::to(['/esm/customers/lisdata']),
      'loadingText' => 'Loading data ...',
    ]
]);?>
	
	   <?=  $form->field($model, 'PROVINCE_ID')->widget(Select2::classname(), 

    [
    'options'=>[  'placeholder' => 'Select provinsi ...'
    ],
    'data' => $droppro


]);?>
	


   <?= $form->field($model, 'CITY_ID')->widget(DepDrop::classname(), [
    'options' => [//'id'=>'customers-cust_ktg',
    'placeholder' => 'Select Kota'],
    'type' => DepDrop::TYPE_SELECT2,
    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
    'pluginOptions'=>[
        'depends'=>['customers-province_id'],
        'url' => Url::to(['/esm/customers/lisarea']),
      'loadingText' => 'Loading data ...',
    ]
]);?>
	
	<!-- $form->field($model, 'CITY_ID')->widget(Select2::classname(), [
        // 'data' => $dropcity,
        'options' => [
        'placeholder' => 'Pilih kota ...'],
        'pluginOptions' => [
            'allowClear' => true,
             ],

        
    ]);?>
     -->
  
    
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
 

     <!-- $form->field($model, 'ALAMAT', $config)->widget(LabelInPlace::classname());?> -->

    <?= $form->field($model, 'WEBSITE', $config)->widget(LabelInPlace::classname());?>

    <?= $form->field($model, 'NOTE', $config)->widget(LabelInPlace::classname());?>

      <?= $form->field($model, 'NPWP', $config)->widget(LabelInPlace::classname());?>
	  
	<?=$form->field($model, 'STT_TOKO')->dropDownList(['' => ' -- Silahkan Pilih --',
                                                     '0' => 'sewa',
                                                     '1' => 'hak milik']) ; ?>


    <?= $form->field($model, 'DATA_ALL')->textInput(['maxlength' => true]) ?>
	
	<?php

	if(!$model->isNewRecord )
	{
		echo $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']) ;
	}
	
	
	?>
	
    <?= $form->field($model, 'ALAMAT')->textInput(['maxlength' => true]) ?> 

   <?= $form->field($model, 'MAP_LNG')->hiddenInput()->label(false) ?>
   
    <?= $form->field($model, 'MAP_LAT')->hiddenInput()->label(false) ?>
	<!-- $form->field($model, 'MAP_LNG')->textInput(['maxlength' => true,'readonly'=>true]) ?> -->
	 <!-- $form->field($model, 'MAP_LAT')->textInput(['maxlength' => true,'readonly'=>true]) ?> -->
       <!-- Html::button('...', ['value'=>Url::to('/esm/customers/lokasi'),'class' => 'btn btn-success','id'=>'modalcp']);?> -->

   <!-- <button type="button" class="btn btn-info btn-lg" id="myBtn">Open Modal</button> -->

  <!-- Modal -->
  <!-- <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-Modal content-->
     <!--  <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div> -->
        <!-- <div class="modal-body"> --> 
      
    <!-- $form->field($model, 'ALAMAT')->textInput(['maxlength' => true]) ?>  -->

    <!--  echo \pigolab\locationpicker\LocationPickerWidget::widget([
       // 'key' => 'http://maps.google.com/maps/api/js?sensor=false&libraries=places', // optional , Your can also put your google map api key
       'options' => [
       // 'id'=>'tes',
        // 'enableSearchBox' => true,
            'style' => 'width: 100%; height: 400px',
            'enableSearchBox' => true, // Optional , default is true
        'searchBoxOptions' => [ // searchBox html attributes
            'style' => 'width: 300px;', // Optional , default width and height defined in css coordinates-picker.css
                    ], // map canvas width and height
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
                'locationNameInput' => new JsExpression("$('#customers-alamat')")
            ],
            'enableAutocomplete' => true,
        ]        
    ]);
 
?> -->
   
<!-- 
 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  -->

  
  
   <?php echo \pigolab\locationpicker\LocationPickerWidget::widget([
       // 'key' => 'http://maps.google.com/maps/api/js?sensor=false&libraries=places', // optional , Your can also put your google map api key
       'options' => [

            
        // 'enableSearchBox' => true,
            'style' => 'width: 100%; height: 400px',
            'enableSearchBox' => true, // Optional , default is true
        'searchBoxOptions' => [ // searchBox html attributes
            'style' => 'width: 300px;', // Optional , default width and height defined in css coordinates-picker.css
                    ], // map canvas width and height
        ] ,
        // 'ClientEvents' =>
        // [
        //      $('#us6').locationpicker('autosize')
        // ],
          

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
                'locationNameInput' => new JsExpression("$('#customers-alamat')")
            ],
            'enableAutocomplete' => true,
        ]        
    ]);
?>
 <!-- $form->field($model, 'ALAMAT')->widget('\pigolab\locationpicker\CoordinatesPicker' , [
        // 'key' => 'abcabcabc...' ,   // optional , Your can also put your google map api key
        'valueTemplate' => '{latitude},{longitude}' , // Optional , this is default result format
        'options' => [
            'style' => 'width: 100%; height: 400px',  // map canvas width and height
        ] ,
        'enableSearchBox' => true , // Optional , default is true
        'searchBoxOptions' => [ // searchBox html attributes
            'style' => 'width: 300px;', // Optional , default width and height defined in css coordinates-picker.css
        ],
        'enableMapTypeControl' => true , // Optional , default is true
        'clientOptions' => [
            'radius'    => 300,
            'location' => [
                'latitude'  => -6.214620,
                'longitude' => 106.845130 
        ],
        ]
    ]);
?> -->


    


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		  <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php

$script = <<<SKRIPT

 // $('#form').on('shown.bs.modal', function () {
 //                $('#tes').locationpicker('autosize');
 //            });
// $(document).ready(function(){
   
//     $("#myBtn").click(function(){
//         $('#tes').locationpicker('autosize')
//         $("#myModal").modal()

//     }); 
// });

// $(function(){
//      $('#tes').locationpicker('autosize');
// $('#modalcp').click(function() {
//     $('#modal').modal('show')
//         .find('#modalcalon')
//         .load($(this).attr('value'));

//     })
//         });
	
	 // $('select#customers-province_id').change(function(){
  //       var id = $(this).val();
	
		
  //        $.get('/esm/customers/lisarea',{id : id},
  //            function( data ) {
  //    $( 'select#customers-city_id' ).html( data );
  //          // alert(data);
  //                       });
  //                   });
	
        
   
SKRIPT;

$this->registerJs($script);

