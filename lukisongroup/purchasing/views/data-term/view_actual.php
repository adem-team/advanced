<?php
/*extensions */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use kartik\detail\DetailView;

/* namespace model*/
use lukisongroup\master\models\Terminvest;



/*array */
$investData = ArrayHelper::map(Terminvest::find()->all(), 'ID', 'INVES_TYPE');
$data = [ 2=>'2 persen',
          4=>'4 persen ',
          10=>'10 persen',
          15=>'15 persen'];


$config = ['template'=>"{input}\n{error}\n{hint}"];

/*info*/
  $viewinfo=DetailView::widget([
    'model' => $model,
    'attributes' => [
     [ #NOMER_FAKTURPAJAK
        'attribute' =>'NOMER_FAKTURPAJAK',
        'label'=>'Nomer Faktur',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
      [ #NOMER_INVOCE
        'attribute' =>'NOMER_INVOCE',
        'label'=>'Nomer Invoce',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
      [ #term_id
        'attribute' =>'temr_Id',
        'value'=>$model->TERM_ID,
        'label'=>'Term Id',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
      [ #cus_Perent
        'attribute' =>'cus_Perent',
         'value'=>$model_header,
        'label'=>'Nama Customers',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
       [ #periode start
        'attribute' =>'PERIODE_START',
        'label'=>'Periode start',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
       [ #periode end
        'attribute' =>'PERIODE_END',
        'label'=>'periode end',
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
    
    [
    	 #NOMER_FAKTURPAJAK
      'attribute' =>'NOMER_FAKTURPAJAK',
      'type'=>DetailView::INPUT_TEXT,
    ],
     [
    	 #INVESTASI_TYPE
      'attribute' =>'INVESTASI_TYPE',
      'type'=>DetailView::INPUT_SELECT2,
      'value'=>$model->nminvest,
      'widgetOptions' => [
            'pluginOptions'=>['placeholder' => 'Select Type Investasi ...'],
            'data'=>$investData
        ],
    ],
    [
    	 #NOMER_INVOCE
      'attribute' =>'NOMER_INVOCE',
      'type'=>DetailView::INPUT_TEXT,
    ],
     [
    	 #HARGA
      'attribute' =>'HARGA',
      'type'=>DetailView::INPUT_MONEY,
    ],
     [
    	 #PPN
      'attribute' =>'PPN',
      'type'=>DetailView::INPUT_TEXT,
    ],
     [
    	 #PPH23
      'attribute' =>'PPH23',
      'type'=>DetailView::INPUT_SELECT2,
      'widgetOptions' => [
            'pluginOptions'=>['placeholder' => 'Select...'],
            'data'=>$data
        ],
    ],
    [
    	 #INVESTASI_PROGRAM
      'attribute' =>'INVESTASI_PROGRAM',
      'type'=>DetailView::INPUT_TEXTAREA,
      'widgetOptions' => [
            'pluginOptions'=>['rows'=>6],
        ],
    ],
    [   #PERIODE_END
      'attribute' =>'PERIODE_START',
      'format'=>'date',
      'type'=>DetailView::INPUT_DATE,
      'widgetOptions' => [
            'pluginOptions'=>['format'=>'yyyy-mm-dd'],
            'pluginEvents'=>[
                  'show' => "function(e) {errror}",
          ],
        ],
      ],
     [   #PERIODE_END
      'attribute' =>'PERIODE_END',
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
    'id'=>'term-actual-view-id',
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
    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
      <?= $viewinfo ?> 
    </div>
    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
    <?= $edit_data_term ?>
    </div>
    </div>
  </div>
