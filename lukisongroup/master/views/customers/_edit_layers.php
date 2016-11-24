<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\Select2;
use kartik\detail\DetailView;




 /*update data layers */
  $update_layers = [
    [
      'group'=>true,
      'label'=>false,
      'rowOptions'=>['class'=>'info'],
      'groupOptions'=>['class'=>'text-left'] //text-center 
    ],
    [   # LAYER_ID
      'attribute' =>'LAYER_ID',
      'displayOnly'=>true,
    ],
     [   # LAYER_NM
      'attribute' =>'LAYER_NM',
    ],
     [   #JEDA_PEKAN
      'attribute' =>'JEDA_PEKAN',
       'type'=>DetailView::INPUT_SPIN ,
    ],
    [   #JEDA_PEKAN
      'attribute' =>'DCRIPT',
       'type'=>DetailView::INPUT_TEXTAREA,
    ],
  ];

  /* term data View Editing*/
  $edit_data_layers=DetailView::widget([
    'id'=>'layers-edit-id',
    'model' => $model,
    'attributes'=>$update_layers,
    'condensed'=>true,
    'hover'=>true,
    'mode'=>DetailView::MODE_EDIT,
    'buttons1'=>'{update}',
    'buttons2'=>'{view}{save}',
    'panel'=>[
          'heading'=>'<div style="float:left;margin-right:10px" class="fa fa-1x fa-list-alt"></div><div><h6 class="modal-title"><b>Data Layers</b></h6></div>',
          'type'=>DetailView::TYPE_INFO,
        ],
  ]);

  ?>

  <?= $edit_data_layers ?>