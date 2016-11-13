<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Terminvest */

 /*Terminvest info*/
  $viewinfo=DetailView::widget([
    'model' => $model,
    'attributes' => [
     [ # INVES_TYPE
        'attribute' =>'INVES_TYPE',
        'label'=>'Type Investasi',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
      [ # KETERANGAN
        'attribute' =>'KETERANGAN',
        'label'=>'Keterangan',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
      [ # STATUS
        'attribute' =>'status_info',
        'format'=>'raw',
        'value'=> $model->STATUS ? '<span class="label label-success">Inactive</span>' : '<span class="label label-danger">active</span>',
        'label'=>'Status Customers',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ], 
    ],
  ]);


    /*update Term Invest*/
  $update_term = [
    [
      'group'=>true,
      'label'=>false,
      'rowOptions'=>['class'=>'info'],
      'groupOptions'=>['class'=>'text-left'] //text-center 
    ],
    [   #INVES_TYPE
      'attribute' =>'INVES_TYPE',
    ],
     [   #KETERANGAN
      'attribute' =>'KETERANGAN',
      'type'=>DetailView::INPUT_TEXTAREA, 
       'options'=>['rows'=>4]
    ],
     [   #STATUS
      'attribute' =>'STATUS',
       'format'=>'raw',
       'value'=>$model->STATUS ? '<span class="label label-success">Inactive</span>' : '<span class="label label-danger">Active</span>',
        'type'=>DetailView::INPUT_SWITCH,
        'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => 'Inactive',
                        'offText' => 'Active',
                    ]
                ],
        'valueColOptions'=>['style'=>'width:30%']
    ],
  ];

  /* Term Invest View Editing*/
  $Terminvest=DetailView::widget([
    'id'=>'term-invest-view-id',
    'model' => $model,
    'attributes'=>$update_term,
    'condensed'=>true,
    'hover'=>true,
    'mode'=>DetailView::MODE_VIEW,
    'buttons1'=>'{update}',
    'buttons2'=>'{view}{save}',
    'panel'=>[
          'heading'=>'<div style="float:left;margin-right:10px" class="fa fa-1x fa-list-alt"></div><div><h6 class="modal-title"><b>Term Investasi</b></h6></div>',
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
    <?= $Terminvest ?>
    </div>
    </div>
  </div>

