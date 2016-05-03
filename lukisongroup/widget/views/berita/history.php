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
$actionLabel='Update';
$attDinamik =[];
/*GRIDVIEW ARRAY FIELD HEAD*/
$headColomnBT=[
  ['ID' =>0, 'ATTR' =>['FIELD'=>'KD_BERITA','SIZE' => '10px','label'=>'KD_BERITA','align'=>'left','warna'=>'97, 211, 96, 0.3']],
  ['ID' =>1, 'ATTR' =>['FIELD'=>'JUDUL','SIZE' => '10px','label'=>'SUBJECT','align'=>'left','warna'=>'97, 211, 96, 0.3']],
  ['ID' =>2, 'ATTR' =>['FIELD'=>'KD_CORP','SIZE' => '10px','label'=>'CORP','align'=>'left','warna'=>'97, 211, 96, 0.3']],
  ['ID' =>3, 'ATTR' =>['FIELD'=>'KD_DEP','SIZE' => '10px','label'=>'DEPT','align'=>'left','warna'=>'97, 211, 96, 0.3']],
];
$gvHeadColomnBT = ArrayHelper::map($headColomnBT, 'ID', 'ATTR');

/*GRIDVIEW ARRAY ACTION*/
$attDinamik[]=[
  'class'=>'kartik\grid\ActionColumn',
  'dropdown' => true,
  'template' => '{view}{review}{delete}',
  'dropdownOptions'=>['class'=>'pull-left dropdown','style'=>['disable'=>true]],
  'dropdownButton'=>[
    'class' => $actionClass,
    'label'=>$actionLabel,
    //'caret'=>'<span class="caret"></span>',
  ],
  'buttons' => [
    'view' =>function($url, $model, $key){
        return  '<li>' .Html::a('<span class="fa fa-random fa-dm"></span>'.Yii::t('app', 'Set Alias Customer'),
                      ['/sistem/personalia/view','id'=>$model->ID],[
                      'id'=>'alias-cust-id',
                      'data-toggle'=>"modal",
                      'data-target'=>"#alias-cust",
                      ]). '</li>' . PHP_EOL;
    },
    'review' =>function($url, $model, $key){
        return  '<li>' . Html::a('<span class="fa fa-retweet fa-dm"></span>'.Yii::t('app', 'Set Alias Prodak'),
                      ['/sistem/personalia/view','id'=>$model->ID],[
                      'id'=>'alias-prodak-id',
                      'data-toggle'=>"modal",
                      'data-target'=>"#alias-prodak",
                      ]). '</li>' . PHP_EOL;
    },
    'delete' =>function($url, $model, $key){
        return  '<li>' . Html::a('<span class="fa fa-retweet fa-dm"></span>'.Yii::t('app', 'new Customer'),
                      ['/sistem/personalia/view','id'=>$model->ID],[
                      'data-toggle'=>"modal",
                      'data-target'=>"#alias-prodak",
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
};

/*SHOW GRID VIEW LIST*/
echo GridView::widget([
  'id'=>'berita-acara-id',
  'dataProvider' => $dataProviderHistory,
  'filterModel' => $searchModelHistory,
  'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
  'columns' => $attDinamik,
  'pjax'=>true,
  'pjaxSettings'=>[
    'options'=>[
      'enablePushState'=>false,
      'id'=>'berita-acara-id',
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
