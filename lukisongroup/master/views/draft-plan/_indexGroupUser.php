<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use lukisongroup\master\models\DraftPlan;
Use ptrnov\salesforce\Jadwal;


?>
<?php
      
/*
 * GRID draft_plan
 * @author wawan  [aditiya@lukison.com]
 * @since 1.2
*/

$actionClass='btn btn-info btn-xs';
$actionLabel='Update';
$attDinamik =[];
/*GRIDVIEW ARRAY FIELD HEAD*/
$headColomn=[
	['ID' =>0, 'ATTR' =>['FIELD'=>'username','SIZE' => '10px','label'=>'GROUP CODE','align'=>'left','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>1, 'ATTR' =>['FIELD'=>'id','SIZE' => '20px','label'=>'GROUP_PRN','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],	
];
$gvHeadColomnBT = ArrayHelper::map($headColomn, 'ID', 'ATTR');


$attDinamik[] =[
  'class'=>'kartik\grid\SerialColumn',
  //'contentOptions'=>['class'=>'kartik-sheet-style'],
  'width'=>'10px',
  'header'=>'No.',
  'headerOptions'=>[
    'style'=>[
      'text-align'=>'center',
      'width'=>'10px',
      'font-family'=>'verdana, arial, sans-serif',
      'font-size'=>'9pt',
      'background-color'=>'rgba(73, 162, 182, 1)',
    ]
  ],
  'contentOptions'=>[
    'style'=>[
      'text-align'=>'center',
      'width'=>'10px',
      'font-family'=>'tahoma, arial, sans-serif',
      'font-size'=>'9pt',
    ]
  ],
];


/*GRIDVIEW ARRAY ROWS*/
foreach($gvHeadColomnBT as $key =>$value[]){
  if($value[$key]['FIELD'] != 'STATUS')
  {
      # code...
      $attDinamik[]=[
        'attribute'=>$value[$key]['FIELD'],
        'label'=>$value[$key]['label'],
        'filter'=>true,
        'hAlign'=>'right',
        'vAlign'=>'middle',
        'noWrap'=>true,
		'group'=>$value[$key]['grp'],
        'headerOptions'=>[
            'style'=>[
            'text-align'=>'center',
            'width'=>$value[$key]['SIZE'],
            'font-family'=>'tahoma, arial, sans-serif',
            'font-size'=>'8pt',
            'background-color'=>'rgba('.$value[$key]['warna'].')',
          ]
        ],
        'contentOptions'=>[
          'style'=>[
            'text-align'=>$value[$key]['align'],
			'width'=>$value[$key]['SIZE'],
            'font-family'=>'tahoma, arial, sans-serif',
            'font-size'=>'8pt',
          ]
        ],
      ];

    }else{}
  };

   /*GRIDVIEW ARRAY ACTION*/
   /*  $attDinamik[]=[
      'class'=>'kartik\grid\ActionColumn',
      'dropdown' => true,
      'dropdownOptions'=>['class'=>'pull-left dropup','style'=>['disable'=>true]],
      'dropdownButton'=>[
        'class' => $actionClass,
      ],
      'buttons' => [
        'view' =>function($url, $model, $key){
            return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
                          ['view','id'=>$model->ID],[
                          'id'=>'gv-grid-draft-id',
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
    ]; */



/*SHOW GRID VIEW LIST*/
$gvGroupUser=GridView::widget([
   'id'=>'gv-group-user-id',
  'dataProvider' => $dataProviderUser,
  'filterModel' => $searchModelUser,
  'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
  'columns' => $attDinamik,
  'pjax'=>true,
  'pjaxSettings'=>[
    'options'=>[
      'enablePushState'=>false,
      'id'=>'gv-group-user-id',
    ],
  ],
  'panel' => [
       'heading'=>false,
        'type'=>'info',
       'before'=> Html::a('<i class="fa fa-sign-in"></i> '.Yii::t('app', 'Start Plan',
                            ['modelClass' => 'DraftPlan',]),'/master/draft-plan/create',[
                                'data-toggle'=>"modal",
                                    'data-target'=>"#modal-create",
                                        'class' => 'btn btn-success'
                                                    ]).' '.
                Html::a('<i class="fa fa-paper-plane"></i> '.Yii::t('app', 'Send Draft',
                            ['modelClass' => 'DraftPlan',]),'/master/draft-plan/send-draft',[
                                        'class' => 'btn btn-info'
                                                    ]),
        'showFooter'=>false,
  ],
  'export' =>['target' => GridView::TARGET_BLANK],
  'exportConfig' => [
    GridView::PDF => [ 'filename' => 'kategori'.'-'.date('ymdHis') ],
    GridView::EXCEL => [ 'filename' => 'kategori'.'-'.date('ymdHis') ],
  ],
  'toolbar'=> [
        '{export}',
    //'{items}',
  ],
  'hover'=>true, //cursor select
  'responsive'=>true,
  'responsiveWrap'=>true,
  'bordered'=>true,
  'striped'=>true,
]);
?>
<?=$gvGroupUser?>

