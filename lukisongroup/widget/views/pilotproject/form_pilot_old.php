<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
use kartik\daterange\DateRangePicker;
use softark\duallistbox\DualListbox;
use kartik\widgets\SwitchInput;


/* @var $this yii\web\View */
/* @var $model lukisongroup\models\widget\Pilotproject */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="pilotproject-form">

    <?php $form = ActiveForm::begin([
      'id'=> $model->formName(),
      'enableClientValidation'=> true,
       'enableAjaxValidation'=>true,
        'validationUrl'=>Url::toRoute('/widget/pilotproject/valid')

    ]); ?>

   
  
    <!-- panel -->
 <div class="panel panel-primary">
  <div class="panel-heading"></div>
    <div class="panel-body">

    <!-- row -->
	 <div class="row"> 
        <div class="col-sm-6">
	 <?= $form->field($model, 'TYPE')->widget(SwitchInput::classname(), [
     'pluginOptions' => [
        'onText' => 'Private',
        'offText' => 'Public',
    ]
   ]) ?>
   </div>
       <div class="col-sm-6" style="margin-top:3%">
    <?=  $form->field($model, 'parentpilot')->checkbox() ?>

     </div>
     </div>


    <div class="row">
        <div class="col-sm-6">
    <div id='prnt'>
    <?= $form->field($model, 'PARENT')->widget(Select2::classname(), [
        'data' => $parent,
        'options' => [
        'id'=>'pilotproject-parent',
        'placeholder' => 'Pilih...'],
        'pluginOptions' => [
            'allowClear' => true
             ],

    ]);
    ?>
    </div>

  
	  <?= $form->field($model, 'PILOT_NM')->textInput() ?>
    
	
    <?= $form->field($model, 'DSCRP')->textInput() ?>

    
    </div>

    <div class="col-sm-6">

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

     <?= $form->field($model, 'Sendto')->widget(Select2::classname(), [
         'data' => $dropemploy,
        'options' => [
        'placeholder' => 'Pilih Karyawan ...'],
        'pluginOptions' => [
            'allowClear' => true
             ],
        
    ]);?>

   
    </div>
    </div>

     <?php
     $options = [
        'multiple' => true,
        // 'size' => 100,
    ];
    // echo $form->field($model, $attribute)->listBox($items, $options);
    echo $form->field($model, 'DEP_SUB_ID')->widget(DualListbox::className(),[
        'items' => $dep,
        'options' => $options,
        'clientOptions' => [
            'moveOnSelect' => false,
            'selectedListLabel' => 'Selected Items',
            'nonSelectedListLabel' => 'Available Items',
        ],
    ]);
    ?>
    

    <?php
     $options = [
        'multiple' => true,
        // 'size' => 100,
    ];
    // echo $form->field($model, $attribute)->listBox($items, $options);
    echo $form->field($model, 'USER_CC')->widget(DualListbox::className(),[
        'items' => $dropemploy,
        'options' => $options,
        'clientOptions' => [
            'moveOnSelect' => false,
            'selectedListLabel' => 'Selected Items',
            'nonSelectedListLabel' => 'Available Items',
        ],
    ]);
    ?>


  
     <!--  $form->field($model, 'DEP_SUB_ID')->widget(Select2::classname(), [
         'data' => $dep,
        'options' => [
        'placeholder' => 'Pilih  ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'multiple'=>true
             ],
        
    ]);?> -->



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
    </div>


    <?php ActiveForm::end(); ?>

</div>
  </div>
  </div>

<?php
$this->registerJs("


$('#pilotproject-parentpilot').click(function(){
 var checkedValue = $('#pilotproject-parentpilot:checked').val();

  if(checkedValue == 1)
  {
    $('#prnt').hide();
  }
  else
  {
      $('#prnt').show();
  }

});


 ",$this::POS_READY);

