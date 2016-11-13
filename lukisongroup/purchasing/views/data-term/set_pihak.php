<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\Select2;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\data_term\models\Termheader */
/* @var $form yii\widgets\ActiveForm */

    /*pihak info*/
  $viewinfo=DetailView::widget([
    'model' => $model,
    'attributes' => [
     [ #nmCustomer
        'attribute' =>'nmCustomer',
        'label'=>'Nama Customer',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
      [ #nmprincipel
        'attribute' =>'nmprincipel',
        'label'=>'Nama Principel',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
      [ #nmDis
        'attribute' =>'nmDis',
        'label'=>'Nama Distributor',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
    ],
  ]);


    /*update data Term */
  $update_data_term = [
    [
      'group'=>true,
      'label'=>false,
      'rowOptions'=>['class'=>'info'],
      'groupOptions'=>['class'=>'text-left'] //text-center 
    ],
    [   #CUST_KD_PARENT
      'attribute' =>'CUST_KD_PARENT',
      'format'=>'raw',
      'value'=>$model->cus->CUST_NM,
      'type'=>DetailView::INPUT_SELECT2,
      'widgetOptions'=>[
        'data'=>$cus_data,
        'options'=>['placeholder'=>'Select ...'],
        'pluginOptions'=>['allowClear'=>true],
      ],  
    ],
     [   #PRINCIPAL_KD
      'attribute' =>'PRINCIPAL_KD',
      'format'=>'raw',
      'value'=>$model->corp->CORP_NM,
      'type'=>DetailView::INPUT_SELECT2,
     'widgetOptions'=>[
        'data'=>$corp,
        'options'=>['placeholder'=>'Select ...'],
        'pluginOptions'=>['allowClear'=>true],
      ],  
    ],
     [   #DIST_KD
      'attribute' =>'DIST_KD',
      'format'=>'raw',
      'value'=>$model->dis->NM_DISTRIBUTOR,
      'type'=>DetailView::INPUT_SELECT2,
      'widgetOptions'=>[
        'data'=>$cus_dis,
        'options'=>['placeholder'=>'Select ...'],
        'pluginOptions'=>['allowClear'=>true],
      ],  
    ],
  ];

  /* term data View Editing*/
  $edit_data_term=DetailView::widget([
    'id'=>'term-pihak-view-id',
    'model' => $model,
    'attributes'=>$update_data_term,
    'condensed'=>true,
    'hover'=>true,
    'mode'=>DetailView::MODE_VIEW,
    'buttons1'=>'{update}',
    'buttons2'=>'{view}{save}',
    'panel'=>[
          'heading'=>'<div style="float:left;margin-right:10px" class="fa fa-1x fa-list-alt"></div><div><h6 class="modal-title"><b>Data Term</b></h6></div>',
          'type'=>DetailView::TYPE_INFO,
        ],
  ]);

  ?>


<div style="height:100%;font-family: verdana, arial, sans-serif ;font-size: 8pt">
  <div class="row" >
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <?= $viewinfo ?> 
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <?= $edit_data_term ?>
    </div>
    </div>
  </div>


