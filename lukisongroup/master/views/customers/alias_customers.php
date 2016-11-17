<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use lukisongroup\master\models\barangalias;
use lukisongroup\master\models\Distributor;
use yii\helpers\Url;
use kartik\widgets\Select2;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Customersalias */
/* @var $form yii\widgets\ActiveForm */

    /*Customers alias info*/
  $cusviewinfo=DetailView::widget([
    'model' => $model,
    'attributes' => [
     [ # custnm
        'attribute' =>'KD_CUSTOMERS',
        'label'=>'Kd Customer',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
      [ # custnm
        'attribute' =>'custnm',
        'label'=>'Customer.NM',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
      [ # custpnma
        'attribute' =>'custpnma',
        'label'=>'Customers.parent',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
      [ #disnm
        'attribute' =>'disnm',
        // 'value'=>$model->custype->CUST_KTG_NM, 
        'label'=>'Nama Distributor',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
        [
          #KD_ALIAS
        'attribute' =>'KD_ALIAS',
        'label'=>'Alias Code :',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
      
    ],
  ]);

    /*update customers alias*/
  $attalias = [
    [
      'group'=>true,
      'label'=>false,
      'rowOptions'=>['class'=>'info'],
      'groupOptions'=>['class'=>'text-left'] //text-center 
    ],
    [   #KD_PARENT
      'attribute' =>'KD_PARENT',
      'format'=>'raw',
      'value'=>$model->cusp->CUST_NM,
      'type'=>DetailView::INPUT_SELECT2,
      'widgetOptions'=>[
        'data'=>$cus_data,
        'options'=>['placeholder'=>'Select ...'],
        'pluginOptions'=>['allowClear'=>true],
      ],  
    ],
     [   #KD_CUSTOMERS
      'attribute' =>'KD_CUSTOMERS',
      'format'=>'raw',
      'value'=>$model->cus->CUST_NM,
      'type'=>DetailView::INPUT_DEPDROP,
      'widgetOptions'=>[
          'options' => ['id'=>'customers-city_id',
          'placeholder' => 'Select Kota'],
      'type' => DepDrop::TYPE_SELECT2,
      'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
      'pluginOptions'=>[
        'depends'=>['customersalias-kd_parent'],
        'url' => Url::to(['/master/customers/lis-child-cus']),
        'loadingText' => 'Loading data ...',
        ]
      ],  
    ],
     [   # KD_DISTRIBUTOR
      'attribute' =>'KD_DISTRIBUTOR',
      'format'=>'raw',
      'value'=>$model->dis->NM_DISTRIBUTOR,
      'type'=>DetailView::INPUT_SELECT2,
      'widgetOptions'=>[
        'data'=>$cus_dis,
        'options'=>['placeholder'=>'Select ...'],
        'pluginOptions'=>['allowClear'=>true],
      ],  
    ],
    
    [   # CUST_KD_ALIAS
      'attribute' =>'KD_ALIAS',
      'label'=>'alias code',
      'type'=>DetailView::INPUT_TEXT,
      'labelColOptions' => ['style' => 'text-align:right;width: 15px']
    ],
  ];

  /* Customers alias View Editing*/
  $alias=DetailView::widget([
    'id'=>$model->formName(),
    'model' => $model,
    'attributes'=>$attalias,
    'condensed'=>true,
    'hover'=>true,
    'mode'=>DetailView::MODE_VIEW,
    'buttons1'=>'{update}',
    'buttons2'=>'{view}{save}',
    
    'panel'=>[
          'heading'=>'<div style="float:left;margin-right:10px" class="fa fa-1x fa-list-alt"></div><div><h6 class="modal-title"><b>Alias Customers</b></h6></div>',
          'type'=>DetailView::TYPE_INFO,
        ],
        'formOptions'=>[
        'id'=>$model->formName(),
                    'enableAjaxValidation'=>true,
                    'enableClientValidation' => true,
                      'validationUrl'=>Url::toRoute('/master/customers/valid-alias-update'),
                ],
  ]);

  ?>


<div style="height:100%;font-family: verdana, arial, sans-serif ;font-size: 8pt">
  <div class="row" >
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <?= $cusviewinfo ?> 
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <?= $alias ?>
    </div>
    </div>
  </div>


