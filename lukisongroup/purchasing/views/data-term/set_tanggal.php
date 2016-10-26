<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\Select2;
use kartik\detail\DetailView;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model lukisongroup\data_term\models\Termheader */
/* @var $form yii\widgets\ActiveForm */

    /*info*/
  $viewinfo=DetailView::widget([
    'model' => $model,
    'attributes' => [
     [ #PERIOD_START
        'attribute' =>'tgl_dibuat',
        'value'=>$model->PERIOD_START,
        'label'=>'Tanggal Term dibuat',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
      [ #PERIOD_END
        'attribute' =>'tgl_berakhir',
         'value'=>$model->PERIOD_END,
        'label'=>'Tanggal Term berakhir',
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
    [   #PERIOD_START
      'attribute' =>'PERIOD_START',
      'format'=>'date',
      'type'=>DetailView::INPUT_DATE,
      'widgetOptions' => [
            'pluginOptions'=>['format'=>'yyyy-mm-dd'],
            'pluginEvents'=>[
                  'show' => "function(e) {errror}",
          ],
        ],
      ],
     [   #PERIOD_END
      'attribute' =>'PERIOD_END',
      'format'=>'raw',
      'format'=>'date',
      'type'=>DetailView::INPUT_DATE,
      'widgetOptions' => [
            'pluginOptions'=>['format'=>'yyyy-mm-dd'],
            'pluginEvents'=>[
                  'show' => "function(e) {errror}",
          ],
       ],
    ],
  ];

  /* term data View Editing*/
  $edit_data_term=DetailView::widget([
    'id'=>'term-tgl-view-id',
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


