<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use lukisongroup\master\models\DraftPlan;
use lukisongroup\master\models\DraftPlanGroup;
Use ptrnov\salesforce\Jadwal;
use kartik\widgets\Spinner;
$ptr_spiner1=Spinner::widget(['id'=>'spn-gv-maintain','preset' => 'large', 'align' => 'center', 'color' => 'blue','hidden'=>false]);	

$actionClass='btn btn-info btn-xs';
$actionLabel='Update';
$attDinamik =[];
/*GRIDVIEW ARRAY FIELD HEAD*/
$headColomn=[
	['ID' =>0, 'ATTR' =>['FIELD'=>'SCDL_GROUP','SIZE' => '10px','label'=>'AUTO GROUP','align'=>'left','warna'=>'73, 162, 182, 1','grp'=>true]],
	['ID' =>1, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '20px','label'=>'DATE','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>2, 'ATTR' =>['FIELD'=>'dayofDate','SIZE' => '30px','label'=>'DAY.NM','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>3, 'ATTR' =>['FIELD'=>'weekofDate','SIZE' => '20px','label'=>'WEEK','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>4, 'ATTR' =>['FIELD'=>'custlayernm','SIZE' => '10px','label'=>'LAYER','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>5, 'ATTR' =>['FIELD'=>'CUST_ID','SIZE' => '50px','label'=>'CUST.ID','align'=>'center','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>6, 'ATTR' =>['FIELD'=>'custNm','SIZE' => '200px','label'=>'CUSTOMER','align'=>'left','warna'=>'73, 162, 182, 1','group'=>true]],
	['ID' =>7, 'ATTR' =>['FIELD'=>'SalesNm','SIZE' => '20px','label'=>'SALES.NM','align'=>'left','warna'=>'73, 162, 182, 1','grp'=>false]],
	['ID' =>8, 'ATTR' =>['FIELD'=>'UseridNm','SIZE' => '20px','label'=>'USER.ID','align'=>'left','warna'=>'73, 162, 182, 1','grp'=>false]],
  ['ID' =>9, 'ATTR' =>['FIELD'=>'STATUS','SIZE' => '20px','label'=>'Status','align'=>'left','warna'=>'73, 162, 182, 1','grp'=>false]],
	
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

$attDinamik[] =[
  'class' => '\kartik\grid\CheckboxColumn',
  //'contentOptions'=>['class'=>'kartik-sheet-style'],
  'width'=>'10px',
  // 'header'=>'No.',
  'checkboxOptions' => function ($model, $key, $index, $column){

  $check_user = DraftPlanGroup::find()->where(['SCL_NM'=>$model->SCDL_GROUP_NM])->one();
  
    if($check_user->USER_ID == "")
    {
      return ['checked' =>'', 'hidden'=>true];
    }elseif($model->STATUS == 1){
      return ['checked' =>'','hidden'=>true];
    }
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

    }elseif($value[$key]['FIELD'] == 'custNm'){

      $attDinamik[]=[
      'attribute'=>$value[$key]['FIELD'],
      'label'=>$value[$key]['label'],
      'filterType'=>GridView::FILTER_SELECT2,
      'filter' => $dropcus,
      'filterWidgetOptions'=>[
        'pluginOptions'=>['allowClear'=>true],
      ],

      'filterInputOptions'=>['placeholder'=>'Pilih Customers'],
      'hAlign'=>'right',
      'vAlign'=>'middle',
      'noWrap'=>true,
      'group'=>false,
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

    }elseif($value[$key]['FIELD'] == 'SCDL_GROUP'){

      $attDinamik[]=[
      'attribute'=>$value[$key]['FIELD'],
      'label'=>$value[$key]['label'],
      'filterType'=>GridView::FILTER_SELECT2,
      'filter' => $scdl_group,
      'filterWidgetOptions'=>[
        'pluginOptions'=>['allowClear'=>true],
      ],

      'filterInputOptions'=>['placeholder'=>'Pilih '],
      'hAlign'=>'right',
      'vAlign'=>'middle',
      'noWrap'=>true,
      'group'=>false,
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

    }elseif($value[$key]['FIELD'] == 'weekofDate'){
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
  }elseif($value[$key]['FIELD'] == 'custlayernm'){
    $attDinamik[]=[
    'attribute'=>$value[$key]['FIELD'],
    'label'=>$value[$key]['label'],
    'filterType'=>GridView::FILTER_SELECT2,
    'filter' => $layer_nm,
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
  }elseif($value[$key]['FIELD'] == 'TGL'){
    $attDinamik[]=[

    'attribute'=>$value[$key]['FIELD'],
    'label'=>$value[$key]['label'],
    'filterType' => GridView::FILTER_DATE,
        'filterWidgetOptions' => [
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
                'todayHighlight' => true,
                     
                 ]
             ],
      'filter'=>true,
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
    'width'=>'20%',
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
   }
 }

/*SHOW GRID VIEW LIST*/
$gvDraftPlan=GridView::widget([
   'id'=>'gv-maintain-id',
  'dataProvider' => $dataProviderMaintain,
  'filterModel' => $searchModelMaintain,
  'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
  'columns' => $attDinamik,
  'pjax'=>true,
  'pjaxSettings'=>[
    'options'=>[
      'enablePushState'=>false,
      'id'=>'gv-maintain-id',
    ],
  ],
  'panel' => [
       'heading'=>false,
        'type'=>'info',
           'before'=>$ptr_spiner1.
		   Html::a('<i class="fa fa-check-circle"></i> '.Yii::t('app', 'Approve'),'/master/draft-plan/approve-all',
                    [
                        'data-toggle-approve-all'=>"approve-plan-erp",
                        'id'=>'approvemodal-erp-plan',
                        // 'data-pjax' => true,
                        'class' => 'btn btn-success btn-sm'
                     
                    ]
              ).' '.
                // Html::a('<i class="fa fa-paper-plane"></i> '.Yii::t('app', 'Approve',
                //             ['modelClass' => 'DraftPlan',]),'/master/draft-plan/pilih-approve',[
                //                     'data-toggle'=>"modal",
                //                     'data-target'=>"#modal-day",
                //                         'class' => 'btn btn-info'
                //                                     ]).' '.
                Html::a('<i class="fa fa-trash"></i> '.Yii::t('app', 'Pilih Delete',
                            ['modelClass' => 'DraftPlanDetail',]),'',[
                                'data-toggle-delete-all'=>"delete-plan-erp-all",
                                'id'=>'delete-erp-plan-all',
                                  'class' => 'btn btn-danger btn-sm'
                                                    ]).' '.
               Html::a('<i class="fa fa-mail-reply-all"></i> '.Yii::t('app', 'Reschedule Draft',
                            ['modelClass' => 'DraftPlan',]),'/master/draft-plan/ganti-jadwal',[
                                'data-toggle'=>"modal",
                                    'data-target'=>"#modal-day",
                                        'class' => 'btn btn-info btn-sm'
                                                    ]),

        'showFooter'=>false,
  ],
  // 'export' =>['target' => GridView::TARGET_BLANK],
  // 'exportConfig' => [
    // GridView::PDF => [ 'filename' => 'kategori'.'-'.date('ymdHis') ],
    // GridView::EXCEL => [ 'filename' => 'kategori'.'-'.date('ymdHis') ],
  // ],
  'toolbar'=> [
        // '{export}',
    //'{items}',
  ],
  'hover'=>true, //cursor select
  'responsive'=>true,
  'responsiveWrap'=>true,
  'bordered'=>true,
  'striped'=>true,
]);
?>
<?=$gvDraftPlan?>
<?php

/** 
    *js Approve 
    *if click then approve 
    *@author adityia@lukison.com
    *@since 1.1.0  

**/
$this->registerJs("
$(document).on('click', '[data-toggle-delete-all]', function(e){

  e.preventDefault();

  var keysSelect = $('#gv-maintain-id').yiiGridView('getSelectedRows');

  if(keysSelect == '')
  {
    alert('sorry your not selected item')
  }else{

  $.ajax({
           url: '/master/draft-plan/pilih-delete',
           //cache: true,
           type: 'POST',
           data:{keysSelect:keysSelect},
           dataType: 'json',
           success: function(response) {
             if (response == true ){
                  $.pjax.reload({container:'#gv-maintain-id'});
             }
            }
          });
        }

})


",$this::POS_READY);

/** 
    *js Approve 
    *if click then approve 
    *@author adityia@lukison.com
    *@since 1.1.0  

**/
$this->registerJs("
$(document).on('click', '[data-toggle-approve-all]', function(e){

  e.preventDefault();

  var keysSelect = $('#gv-maintain-id').yiiGridView('getSelectedRows');

  if(keysSelect == '')
  {
    alert('sorry your not selected item')
  }else{

  $.ajax({
           url: '/master/draft-plan/approve-all',
           //cache: true,
           type: 'POST',
           data:{keysSelect:keysSelect},
           dataType: 'json',
           success: function(response) {
             if (response == true ){
                  $.pjax.reload({container:'#gv-maintain-id'});
             }
            }
          });
        }

})


",$this::POS_READY);

$this->registerJs("
         $.fn.modal.Constructor.prototype.enforceFocus = function(){};
         $('#modal-day').on('show.bs.modal', function (event) {
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
        'id' => 'modal-day',
        'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title"> SCHEDULE OF CUSTOMER </h4></div>',
        'headerOptions'=>[
                'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
        ],
    ]);
    Modal::end();
$this->registerJs("
         $.fn.modal.Constructor.prototype.enforceFocus = function(){};
         $('#modal-create').on('show.bs.modal', function (event) {
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
        'id' => 'modal-create',
        'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-search-plus"></div><div><h4 class="modal-title">GEOGRAFIS FILTER To PLAN MAINTAIN</h4></div>',
        'headerOptions'=>[
                'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
        ],
    ]);
    Modal::end();
	
	 
	$this->registerJs("	
		window.onload = function(){ 
			 var s= document.getElementById('spn-gv-maintain');
			s.hidden=false;
		};	
		 $(document).on('ajaxStart', function() {
				var s= document.getElementById('spn-actual');
				s.hidden=true;
		  });
		$(document).on('ajaxStop', function() {
			var s= document.getElementById('spn-gv-maintain');
			s.hidden=true;
		});			
     ",$this::POS_READY)
?>

  


    
