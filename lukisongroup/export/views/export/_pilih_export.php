<?php

/*extensions*/
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use softark\duallistbox\DualListbox;


/*namespace models*/
use lukisongroup\master\models\Kategoricus;


/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\Kategoricus */
/* @var $form yii\widgets\ActiveForm */

 $dropparentkategori = ArrayHelper::map(Kategoricus::find()->where('CUST_KTG_PARENT = CUST_KTG')
                                                                   ->asArray()
                                                                   ->all(),'CUST_KTG', 'CUST_KTG_NM');

?>



<div class="kategoricus-form">

    <?php $form = ActiveForm::begin([
	  'id'=>$model->formName(),
      'enableClientValidation' => true,

	]); ?>
    
    <?= $form->field($model, 'cus_Type')->widget(Select2::classname(),[
      'options'=>['placeholder' => 'Select Category ...'
      ],
      'data' => $dropparentkategori
    ])->label('Kategori');
        ?>

  <?= $form->field($model, 'cust_ktg')->widget(DepDrop::classname(), [
    'type'=>DepDrop::TYPE_SELECT2,
    'options'=>['placeholder'=>'Select ...'],
    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
    'pluginOptions'=>[
        'depends'=>['customers-cus_type'],
         'initialize' => true,
          'loadingText' => 'Loading  ...',
        'url' => Url::to(['/master/customers/lisdata']),
    ]
])->label('Type') ?>

 <!-- $form->field($model, 'CUST_GRP')->widget(DepDrop::classname(), [
    'type'=>DepDrop::TYPE_SELECT2,
    'options'=>['placeholder'=>'Select ...'],
    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
    'pluginOptions'=>[
        'depends'=>['customers-cust_ktg'],
         // 'initialize' => true,
         'loadingText' => 'Loading  ...',
        'url'=>Url::to(['/master/customers/lis-cus']),
    ]
]) ?> -->

  <?= $form->field($model, 'CUST_GRP')->widget(Select2::classname(),[
      'options'=>['placeholder' => 'Select  ...',
       'multiple' => true,
       // 'style'=>['border'=>false],
       
      ],
        'pluginOptions' => [
        'allowClear' => true,
        // 'style'=>'display:block',
    ],
      // 'data' => $dropparentkategori
    ]);
        ?>
<?php
// $options = [
//        'multiple' => true,
//        'size' => 20,
//        'id'=>'customers-cust_grp'
//    ];
// //    // echo Html::activeListBox($model, $attribute, $items, $options);
//    echo DualListbox::widget([
//        'model' => $model,
//        'attribute' => 'CUST_GRP',
//        // 'items' => $items,
//        'options' => $options,
//        'clientOptions' => [
//            'moveOnSelect' => false,
//            'selectedListLabel' => 'Selected Items',
//            'nonSelectedListLabel' => 'Available Items',
//        ],
//    ]);
   ?>

  
   
    <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Print' : 'Print', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

/** *js getting table values using ajax
    *@author adityia@lukison.com

**/
$this->registerJs("
$('#customers-cust_ktg').on('change',function(e){
e.preventDefault();
var idx = $(this).val();
   $.ajax({   
        url: '/master/customers/lis-cus-box',
        dataType: 'json',
        type: 'GET',
        data:{id:idx},
        success: function (data, textStatus, jqXHR) {            $('#customers-cust_grp').html(data);
        },
    });
  
})
// bootstrap-duallistbox-nonselected-list_Customers[CUST_GRP][]
",$this::POS_READY);

$script = <<< JS
$(document).ready(function() {
    setInterval(function(){ $("#customers-cust_grp").click(); }, 1000);
});
JS;
$this->registerJs($script);
