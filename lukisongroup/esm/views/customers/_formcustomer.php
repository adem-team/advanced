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
	'id'=>$model->formName(),
	
	
	
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
	


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		  <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php


// $this->registerJs("
        
   // $('form#{$model->formName()}').on('beforeSubmit',function(e)
    // {
        // var \$form = $(this);
        // $.post(
            // \$form.attr('action'),
            // \$form.serialize()

        // )
        
            // .done(function(result){
				// alert(result)
			        // if(result == 1 )
                                          // {
											    
                                             // $(document).find('#createcus').modal('hide');
                                             // $('form#customers').trigger('reset');
                                             // $.pjax.reload({container:'#axctive224'});
                                          // }
                                        // else{
                                           // console.log(result)
                                        // }
            
            // });
            
// return false;


// });

 
 // ",$this::POS_END);
 

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

