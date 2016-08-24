<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use lukisongroup\master\models\DraftPlan;
Use ptrnov\salesforce\Jadwal;
  
/*
 * GRID draft_plan
 * @author wawan  [aditiya@lukison.com]
 * @since 1.2
*/

$actionClass='btn btn-info btn-xs';
$actionLabel='Update';
$attDinamik =[];
/*GRIDVIEW ARRAY FIELD HEAD*/

$headColomnBT=[
	['ID' =>0, 'ATTR' =>['FIELD'=>'IdDinamikScdl','SIZE' => '30px','label'=>'AUTO GROUP','center'=>'left','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>1, 'ATTR' =>['FIELD'=>'CUST_KD','SIZE' => '30px','label'=>'CUST.ID','align'=>'left','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>2, 'ATTR' =>['FIELD'=>'CustNm','SIZE' => '200px','label'=>'CUSTOMER','align'=>'left','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>3, 'ATTR' =>['FIELD'=>'GeoNm','SIZE' => '10px','label'=>'GEO','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>4, 'ATTR' =>['FIELD'=>'GeoSub','SIZE' => '10px','label'=>'SUB','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>5, 'ATTR' =>['FIELD'=>'LayerNm','SIZE' => '10px','label'=>'LAYER','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>6, 'ATTR' =>['FIELD'=>'DayNm','SIZE' => '10px','label'=>'DAY','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>7, 'ATTR' =>['FIELD'=>'GanjilGenap','SIZE' => '10px','label'=>'WEEK','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>8, 'ATTR' =>['FIELD'=>'DAY_ID','SIZE' => '80px','label'=>'SETUP','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>9, 'ATTR' =>['FIELD'=>'YEAR','SIZE' => '10px','label'=>'YEAR','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>10, 'ATTR' =>['FIELD'=>'STATUS','SIZE' => '10px','label'=>'Status','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
];
$gvHeadColomnBT = ArrayHelper::map($headColomnBT, 'ID', 'ATTR');


$attDinamik[] =[
  'class' => '\kartik\grid\CheckboxColumn',
  //'contentOptions'=>['class'=>'kartik-sheet-style'],
  'width'=>'10px',
  // 'header'=>'No.',
  'checkboxOptions' => function ($model, $key, $index, $column){

  },
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
  if($value[$key]['FIELD'] == 'STATUS')
  {
    $attDinamik[]=[
		'attribute'=>$value[$key]['FIELD'],
		'label'=>$value[$key]['label'],
		'filterType'=>GridView::FILTER_SELECT2,
		'filter' => $valStt,
		'filterWidgetOptions'=>[
		  'pluginOptions'=>['allowClear'=>true],
		],
		'filterInputOptions'=>['placeholder'=>'Pilih'],
		 'format' => 'raw',
		'value'=>function($model){
				   if ($model->STATUS == 1) {
						return Html::a('<i class="fa fa-check"></i> &nbsp;Approve', '',['class'=>'btn btn-success btn-xs', 'title'=>'Approve']);
					} else if ($model->STATUS == 0) {
						return Html::a('<i class="fa fa-close"></i> &nbsp;DRAFT', '',['class'=>'btn btn-danger btn-xs', 'title'=>'Deactive']);
					}
				},
		'hAlign'=>'right',
		'vAlign'=>'middle',
		'noWrap'=>true,
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
				'width'=>$value[$key]['SIZE'],
				'text-align'=>$value[$key]['align'],
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
			]
		],
    ];
  }elseif($value[$key]['FIELD'] == 'CustNm'){
    $attDinamik[]=[
    'attribute'=>$value[$key]['FIELD'],
    'label'=>$value[$key]['label'],
    'filterType'=>GridView::FILTER_SELECT2,
    'filter' =>$dropcus,
    'filterWidgetOptions'=>[
      'pluginOptions'=>['allowClear'=>true],
    ],
    'filterInputOptions'=>['placeholder'=>'Pilih'],
    'hAlign'=>'right',
    'vAlign'=>'middle',
    'noWrap'=>true,
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
        'width'=>$value[$key]['SIZE'],
        'text-align'=>$value[$key]['align'],
        'font-family'=>'tahoma, arial, sans-serif',
        'font-size'=>'8pt',
      ]
    ],
    ];
  }elseif($value[$key]['FIELD'] == 'YEAR'){
    $attDinamik[]=[
    'attribute'=>$value[$key]['FIELD'],
    'label'=>$value[$key]['label'],
    'filterType'=>GridView::FILTER_SELECT2,
    'filter' => DraftPlan::getYearsList(),
    'filterWidgetOptions'=>[
      'pluginOptions'=>['allowClear'=>true],
    ],
    'filterInputOptions'=>['placeholder'=>'Pilih'],
    'hAlign'=>'right',
    'vAlign'=>'middle',
    'noWrap'=>true,
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
        'width'=>$value[$key]['SIZE'],
        'text-align'=>$value[$key]['align'],
        'font-family'=>'tahoma, arial, sans-serif',
        'font-size'=>'8pt',
      ]
    ],
    ];
  }elseif($value[$key]['FIELD'] == 'GanjilGenap'){
    $attDinamik[]=[
    'attribute'=>$value[$key]['FIELD'],
    'label'=>$value[$key]['label'],
    'filterType'=>GridView::FILTER_SELECT2,
    'filter' => $pekan,
    'filterWidgetOptions'=>[
      'pluginOptions'=>['allowClear'=>true],
    ],
    'filterInputOptions'=>['placeholder'=>'Pilih'],
    'hAlign'=>'right',
    'vAlign'=>'middle',
    'noWrap'=>true,
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
        'width'=>$value[$key]['SIZE'],
        'text-align'=>$value[$key]['align'],
        'font-family'=>'tahoma, arial, sans-serif',
        'font-size'=>'8pt',
      ]
    ],
    ];
  }elseif($value[$key]['FIELD'] == 'LayerNm'){
    $attDinamik[]=[
    'attribute'=>$value[$key]['FIELD'],
    'label'=>$value[$key]['label'],
    'filterType'=>GridView::FILTER_SELECT2,
    'filter' => $layer,
    'filterWidgetOptions'=>[
      'pluginOptions'=>['allowClear'=>true],
    ],
    'filterInputOptions'=>['placeholder'=>'Pilih'],
    'hAlign'=>'right',
    'vAlign'=>'middle',
    'noWrap'=>true,
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
        'width'=>$value[$key]['SIZE'],
        'text-align'=>$value[$key]['align'],
        'font-family'=>'tahoma, arial, sans-serif',
        'font-size'=>'8pt',
      ]
    ],
    ];
  }elseif($value[$key]['FIELD'] == 'GeoNm'){
    $attDinamik[]=[
    'attribute'=>$value[$key]['FIELD'],
    'label'=>$value[$key]['label'],
    'filterType'=>GridView::FILTER_SELECT2,
    'filter' => $drop,
    'filterWidgetOptions'=>[
      'pluginOptions'=>['allowClear'=>true],
    ],
    'filterInputOptions'=>['placeholder'=>'Pilih'],
    'hAlign'=>'right',
    'vAlign'=>'middle',
    'noWrap'=>true,
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
        'width'=>$value[$key]['SIZE'],
        'text-align'=>$value[$key]['align'],
        'font-family'=>'tahoma, arial, sans-serif',
        'font-size'=>'8pt',
      ]
    ],
    ];
  }elseif($value[$key]['FIELD'] == 'DayNm'){
    $attDinamik[]=[
    'attribute'=>$value[$key]['FIELD'],
    'label'=>$value[$key]['label'],
    'filterType'=>GridView::FILTER_SELECT2,
    'filter' => DraftPlan::getDay(),
    'filterWidgetOptions'=>[
      'pluginOptions'=>['allowClear'=>true],
    ],
    'filterInputOptions'=>['placeholder'=>'Pilih'],
    'hAlign'=>'right',
    'vAlign'=>'middle',
    'noWrap'=>true,
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
        'width'=>$value[$key]['SIZE'],
        'text-align'=>$value[$key]['align'],
        'font-family'=>'tahoma, arial, sans-serif',
        'font-size'=>'8pt',
      ]
    ],
    ];
  }elseif($value[$key]['FIELD'] == 'DAY_ID'){
      # code...
      $attDinamik[]=[
        'attribute'=>$value[$key]['FIELD'],
        'label'=>$value[$key]['label'],
        'filter'=>true,
        'hAlign'=>'right',
        'vAlign'=>'middle',
        'format' =>'raw',
        'value'=>function($model){
            //$label = $model->DAY_ID != ''?$model->DAY_ID:'Day';
			if (!$model->GEO_ID OR !$model->LAYER_ID){
				$label = 'Data Not Compelte';
				return	$label;			
			}else{
				$label = 'SETUP SCHEDULE';
				return Html::a(Yii::t('app',$label,['modelClass' => 'DayName',]), 
								['/master/draft-plan/set-scdl-fday','id'=>$model->ID],
								['data-toggle'=>"modal",
								'data-target'=>"#modal-day-draft",
								'class' => 'btn btn-default btn-xs',
								// 'style'=>'width:50px;height:40px'
								]
						);
			}
           
        },
        'noWrap'=>true,
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
			'width'=>$value[$key]['SIZE'],
            'text-align'=>$value[$key]['align'],
            'font-family'=>'tahoma, arial, sans-serif',
            'font-size'=>'8pt',
          ]
        ],
      ];


  }else{
      # code...
      $attDinamik[]=[
        'attribute'=>$value[$key]['FIELD'],
        'label'=>$value[$key]['label'],
        'filter'=>true,
        'hAlign'=>'right',
        'vAlign'=>'middle',
        'noWrap'=>true,
		//'group'=>$value[$key]['grp'],
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
			'width'=>$value[$key]['SIZE'],
            'text-align'=>$value[$key]['align'],
            'font-family'=>'tahoma, arial, sans-serif',
            'font-size'=>'8pt',
          ]
        ],
      ];

    }



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
$gvNewPlan=GridView::widget([
  'id'=>'gv-new-id',
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
  'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
  'columns' => $attDinamik,
  'pjax'=>true,
  'pjaxSettings'=>[
    'options'=>[
		'enablePushState'=>false,
		'id'=>'gv-new-id',
    ],
  ],
  'panel' => [
        'heading'=>false,
        'type'=>'info',
      	'before'=> Html::a('<i class="fa fa-sign-in"></i> '.Yii::t('app', 'Start Draft Plan',
                                  ['modelClass' => 'DraftPlan',]),'/master/draft-plan/create',[
                                      'data-toggle'=>"modal",
                                          'data-target'=>"#modal-create-draft",
                                              'class' => 'btn btn-success'
                                                          ]).' '.
          Html::a('<i class="fa fa-trash"></i> '.Yii::t('app', 'Clear',
                                  ['modelClass' => 'DraftPlan',]),'',[
                                      'data-toggle-delete'=>"delete-draft-plan",
                                        'data-pjax'=>true,
                                      'id'=>'delete-erp-planning',
                                              'class' => 'btn btn-danger'
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
<?=$gvNewPlan?>
<?php

/** 
    *js Approve 
    *if click then delete 
    *@author adityia@lukison.com
    *@since 1.1.0  

**/
$this->registerJs("
$(document).on('click', '[data-toggle-delete]', function(e){

  e.preventDefault();

  var keysSelect = $('#gv-new-id').yiiGridView('getSelectedRows');

  if(keysSelect == '')
  {
    alert('sorry your not selected item')
  }else{

  $.ajax({
           url: '/master/draft-plan/delete-plan',
           //cache: true,
           type: 'POST',
           data:{keysSelect:keysSelect},
           dataType: 'json',
           success: function(response) {
             if (response == true ){
                  $.pjax.reload({container:'#gv-new-id'});
             }
            }
          });
        }

})


",$this::POS_READY);



$this->registerJs("
         $.fn.modal.Constructor.prototype.enforceFocus = function(){};
         $('#modal-create-draft').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var modal = $(this)
            var title = button.data('title')
            var href = button.attr('href')
            //modal.find('.modal-title').html(title)
            modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
            $.post(href)
                .done(function( data ) {
                    modal.find('.modal-body').html(data)
                });
            })
    ",$this::POS_READY);
    Modal::begin([
        'id' => 'modal-create-draft',
        'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-search-plus"></div><div><h4 class="modal-title">GEOGRAFIS FILTER</h4></div>',
        'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
                'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
        ],
    ]);
    Modal::end();

    $this->registerJs("
         $.fn.modal.Constructor.prototype.enforceFocus = function(){};
         $('#modal-day-draft').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var modal = $(this)
            var title = button.data('title')
            var href = button.attr('href')
            //modal.find('.modal-title').html(title)
            modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
            $.post(href)
                .done(function( data ) {
                    modal.find('.modal-body').html(data)
                });
            })
    ",$this::POS_READY);
    Modal::begin([
        'id' => 'modal-day-draft',
        'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-search-plus"></div><div><h4 class="modal-title">GEOGRAFIS FILTER To PLAN MAINTAIN</h4></div>',
        'headerOptions'=>[
                'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
        ],
    ]);
    Modal::end();

