<?php
/* extensions */
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use yii\widgets\Pjax;
?>


<?php
/*
 * GRID BERITA ACARA
 * @author ptrnov  [piter@lukison.com]
 * @since 1.2
*/
$actionClass='btn btn-info btn-xs';
$attDinamik =[];
/*GRIDVIEW ARRAY FIELD HEAD*/
$headColomnBT=[
  ['ID' =>0, 'ATTR' =>['FIELD'=>'KD_BERITA','SIZE' => '10px','label'=>'KD_BERITA','align'=>'left','warna'=>'97, 211, 96, 0.3']],
  ['ID' =>1, 'ATTR' =>['FIELD'=>'JUDUL','SIZE' => '10px','label'=>'SUBJECT','align'=>'left','warna'=>'97, 211, 96, 0.3']],
  ['ID' =>2, 'ATTR' =>['FIELD'=>'KD_REF','SIZE' => '10px','label'=>'Kode Referensi','align'=>'left','warna'=>'97, 211, 96, 0.3']],
  ['ID' =>3, 'ATTR' =>['FIELD'=>'CREATE_AT','SIZE' => '10px','label'=>'Tanggal','align'=>'left','warna'=>'97, 211, 96, 0.3']],
  ['ID' =>4, 'ATTR' =>['FIELD'=>'corphistory','SIZE' => '10px','label'=>'CORP','align'=>'left','warna'=>'97, 211, 96, 0.3']],
  ['ID' =>5, 'ATTR' =>['FIELD'=>'depthistory','SIZE' => '10px','label'=>'DEPT','align'=>'left','warna'=>'97, 211, 96, 0.3']],
];
$gvHeadColomnBT = ArrayHelper::map($headColomnBT, 'ID', 'ATTR');

/*GRIDVIEW ARRAY ACTION*/
$attDinamik[]=[
  'class'=>'kartik\grid\ActionColumn',
  'dropdown' => true,
  'template' => '{view}',
  'dropdownOptions'=>['class'=>'pull-left dropdown','style'=>['disable'=>true]],
  'dropdownButton'=>[
    'class' => $actionClass,
    //'caret'=>'<span class="caret"></span>',
  ],
  'buttons' => [
    'view' =>function($url, $model, $key){
        return  '<li>' .Html::a('<span class="fa fa-random fa-dm"></span>'.Yii::t('app', 'view'),
                      ['/widget/berita/detail-berita','KD_BERITA'=>$model->KD_BERITA],[
                      'id'=>'berita-acara-view-id-history',
                      ]). '</li>' . PHP_EOL;
    },
  ],
  'headerOptions'=>[
    'style'=>[
      'text-align'=>'center',
      'width'=>'10px',
      'font-family'=>'tahoma, arial, sans-serif',
      'font-size'=>'9pt',
      'background-color'=>'rgba(97, 211, 96, 0.3)',
    ]
  ],
  'contentOptions'=>[
    'style'=>[
      'text-align'=>'center',
      'width'=>'10px',
      'height'=>'10px',
      'font-family'=>'tahoma, arial, sans-serif',
      'font-size'=>'9pt',
    ]
  ],
];
/*GRIDVIEW ARRAY ROWS*/
foreach($gvHeadColomnBT as $key =>$value[]){
  if($value[$key]['FIELD'] == 'corphistory')
  {
    $attDinamik[]=[
      'attribute'=>$value[$key]['FIELD'],
      'label'=>$value[$key]['label'],
      'filterType'=>GridView::FILTER_SELECT2,
        'filter' => $selectCorp,
        'filterWidgetOptions'=>[
          'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'select kd corp'],
      'hAlign'=>'right',
      'vAlign'=>'middle',
      'noWrap'=>true,
      'headerOptions'=>[
          'style'=>[
          'text-align'=>'center',
          'width'=>$value[$key]['FIELD'],
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
          'background-color'=>'rgba('.$value[$key]['warna'].')',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>$value[$key]['align'],
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
        ]
      ],
            'width'=>'12px',
    ];
  }elseif($value[$key]['FIELD'] == 'depthistory'){
    $attDinamik[]=[
      'attribute'=>$value[$key]['FIELD'],
      'label'=>$value[$key]['label'],
      'filterType'=>GridView::FILTER_SELECT2,
        'filter' => $selectdept,
        'filterWidgetOptions'=>[
          'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'select departemen'],
      'hAlign'=>'right',
      'vAlign'=>'middle',
      'noWrap'=>true,
      'headerOptions'=>[
          'style'=>[
          'text-align'=>'center',
          'width'=>$value[$key]['FIELD'],
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
          'background-color'=>'rgba('.$value[$key]['warna'].')',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>$value[$key]['align'],
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
        ]
      ],
            'width'=>'12px',
    ];
  }elseif($value[$key]['FIELD'] == 'CREATE_AT'){
    $attDinamik[]=[
      'attribute'=>$value[$key]['FIELD'],
      'label'=>$value[$key]['label'],
      'value'=>function($model){
        /*
         * max String Disply
         * @author ptrnov <piter@lukison.com>
        */
        return $model->CREATED_ATCREATED_BY;
      },
      'filterType' => GridView::FILTER_DATETIME,
             'filterWidgetOptions' => [
                 'pluginOptions' => [
                     'autoclose' => true,
                     'todayHighlight' => true,
                 ]
             ],
      'hAlign'=>'right',
      'vAlign'=>'middle',
      'noWrap'=>true,
      'headerOptions'=>[
          'style'=>[
          'text-align'=>'center',
          'width'=>$value[$key]['FIELD'],
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
          'background-color'=>'rgba('.$value[$key]['warna'].')',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>$value[$key]['align'],
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
        ]
      ],
            'width'=>'12px',
    ];
  }else{
    $attDinamik[]=[
      'attribute'=>$value[$key]['FIELD'],
      'label'=>$value[$key]['label'],
      'filter'=>true,
      'hAlign'=>'right',
      'vAlign'=>'middle',
      //'mergeHeader'=>true,
      'noWrap'=>true,
      'headerOptions'=>[
          'style'=>[
          'text-align'=>'center',
          'width'=>$value[$key]['FIELD'],
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
          //'background-color'=>'rgba(97, 211, 96, 0.3)',
          'background-color'=>'rgba('.$value[$key]['warna'].')',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>$value[$key]['align'],
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
        ]
      ],
      //'pageSummaryFunc'=>GridView::F_SUM,
      //'pageSummary'=>true,
      // 'pageSummaryOptions' => [
        // 'style'=>[
            // 'text-align'=>'right',
            'width'=>'12px',
            // 'font-family'=>'tahoma',
            // 'font-size'=>'8pt',
            // 'text-decoration'=>'underline',
            // 'font-weight'=>'bold',
            // 'border-left-color'=>'transparant',
            // 'border-left'=>'0px',
        // ]
      // ],
    ];
  }
};

/*SHOW GRID VIEW LIST*/
echo GridView::widget([
  'id'=>'berita-acara-history-id',
  'dataProvider' => $dataProviderHistory,
  'filterModel' => $searchModelHistory,
  'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
  'columns' => $attDinamik,
  'pjax'=>true,
  'pjaxSettings'=>[
    'options'=>[
      'enablePushState'=>false,
      'id'=>'berita-acara-history-id',
    ],
  ],
  'panel' => [
        'heading'=>'<h3 class="panel-title">LIST BERITA ACARA </h3>',
        'type'=>'warning',
        'showFooter'=>false,
  ],
  'toolbar'=> [
    //'{items}',
  ],
  'hover'=>true, //cursor select
  'responsive'=>true,
  'responsiveWrap'=>true,
  'bordered'=>true,
  'striped'=>true,
]);




 ?>
