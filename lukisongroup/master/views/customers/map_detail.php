<?php
/*extensions */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\detail\DetailView;
use yii\helpers\Json;
use yii\web\Response;
use kartik\grid\GridView;


/*info*/
  $viewinfo=DetailView::widget([
    'model' => $model_customers,
    'attributes' => [
     [ #CUST_KD
        'attribute' =>'CUST_KD',
        'label'=>'Kode Customers',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
      [ #CUST_NM
        'attribute' =>'CUST_NM',
        'label'=>'Nama Customers',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
      [ #ALAMAT
        'attribute' =>'ALAMAT',
        'label'=>'Alamat',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
      [ #STATUS
        'attribute' =>'STATUS',
        'format'=>'raw',
        'value'=>$model_customers->STATUS ? '<span class="label label-success">InActive</span>' : '<span class="label label-danger">Active</span>',
        'label'=>'Status',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
       [ #LOCK_MAP
        'attribute' =>'LOCK_MAP',
        'label'=>'GPS',
        'format'=>'raw',
        'value'=>$model_customers->LOCK_MAP ? '<span class="label label-primary">Lock</span>' : '<span class="label label-primary">Unlock</span>',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
       [ #LAT
        'attribute' =>'MAP_LAT',
        'label'=>'LAT',
        'value'=>$model_customers->MAP_LAT ? $model_customers->MAP_LAT :'-',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
      [ #LAT
        'attribute' =>'MAP_LNG',
        'label'=>'LNG',
        'value'=>$model_customers->MAP_LNG ? $model_customers->MAP_LNG :'-',
        'labelColOptions' => ['style' => 'text-align:right;width: 30%']
      ],
    ],
  ]);



  /**
	 * GRID VIEW PLAN TREM
	 * @author wawan  
	 * @since 1.0
	*/
	$attDinamik =[];
	/*GRIDVIEW ARRAY FIELD HEAD*/
	$headColomnEvent=[
		['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '50px','label'=>'Tanggal','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>true,'filterwarna'=>'126, 189, 188, 0.9']],
		['ID' =>1, 'ATTR' =>['FIELD'=>'CHECKOUT_LAT','SIZE' => '10px','label'=>'Lat ','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'126, 189, 188, 0.9']],
		['ID' =>2, 'ATTR' =>['FIELD'=>'CHECKOUT_LAG','SIZE' => '10px','label'=>'lng','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'126, 189, 188, 0.9']],

	];
	$gvHeadColomn = ArrayHelper::map($headColomnEvent, 'ID', 'ATTR');
	/*GRIDVIEW SERIAL ROWS*/
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
				'background-color'=>'rgba(249,215,100,1)',
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
	foreach($gvHeadColomn as $key =>$value[]){
		if($value[$key]['FIELD'] == 'TGL')
		{
			$attDinamik[]=[
			'attribute'=>$value[$key]['FIELD'],
			'label'=>$value[$key]['label'],
			'filterType'=>GridView::FILTER_DATE,
			'filter'=>$value[$key]['filter'],
			'filterWidgetOptions'=>[
				'pluginOptions' => [
        				'autoclose'=>true,
        			'format' => 'yyyy-mm-dd'
    				],
			],
			'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
			'hAlign'=>'right',
			'vAlign'=>'middle',
			//'mergeHeader'=>true,
			'noWrap'=>true,
			'group'=>$value[$key]['GRP'],
			'format'=>$value[$key]['FORMAT'],
			'headerOptions'=>[
					'style'=>[
					'text-align'=>'center',
					'width'=>$value[$key]['FIELD'],
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					//'background-color'=>'rgba(74, 206, 231, 1)',
					'background-color'=>'rgba('.$value[$key]['warna'].')',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>$value[$key]['align'],
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					//'background-color'=>'rgba(13, 127, 3, 0.1)',
				]
			],
		];
		}else{
			$attDinamik[]=[
			'attribute'=>$value[$key]['FIELD'],
			'label'=>$value[$key]['label'],
			'filterType'=>$value[$key]['filterType'],
			'filter'=>$value[$key]['filter'],
			'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
			'hAlign'=>'right',
			'vAlign'=>'middle',
			//'mergeHeader'=>true,
			'noWrap'=>true,
			'group'=>$value[$key]['GRP'],
			'format'=>$value[$key]['FORMAT'],
			'headerOptions'=>[
					'style'=>[
					'text-align'=>'center',
					'width'=>$value[$key]['FIELD'],
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					//'background-color'=>'rgba(74, 206, 231, 1)',
					'background-color'=>'rgba('.$value[$key]['warna'].')',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>$value[$key]['align'],
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					//'background-color'=>'rgba(13, 127, 3, 0.1)',
				]
			],
		];
		}
		
	};


	/*GRIDVIEW RadioColumn ROWS*/
	$attDinamik[] =[
		'class'=>'\kartik\grid\RadioColumn',
		'radioOptions' => function($model, $key, $index, $column) use($lock_map) {
				if($lock_map)
				{
					return ['hidden'=>true];
    				
				}else{
					return ['value' => $model->CUST_ID.','.$model->CHECKOUT_LAT.','.$model->CHECKOUT_LAG];
				}
		}
	];
	
	
	/*GRID VIEW BASE*/
	$gvGps= GridView::widget([
		'id'=>'detail-grid-map-id',
		'dataProvider' => $dataProvider,
		// 'filterModel' => $searchModel,
		'filterRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.9); align:center'],
		'columns' => $attDinamik,
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'detail-grid-map-id',
			],
		],
		'panel' => [
					'heading'=>'<h3 class="panel-title" style="font-family: verdana, arial, sans-serif ;font-size: 9pt;">Detail Map</h3>',
					'type'=>'info',
					'before'=> Html::a('<i class="fa fa-clock-o"></i> '.Yii::t('app', 'Pilih'),'',
			                	[
				                    'data-toggle-map-detail-erp'=>'erp-map-detail-id',
				                    'id'=>'erp-all-detail-map-id',
				                    'data-pjax' => true,
				                    'class' => 'btn btn-danger btn-sm'
				                 
				                ]
	           				 )
					//'showFooter'=>false,
		],
		'toolbar'=> '',
	 // ],
		// 'hover'=>true, //cursor select
		 'responsive'=>true,
		// 'responsiveWrap'=>true,
		// 'bordered'=>true,
		// 'striped'=>true,
	]);

  ?>

  <div style="height:100%;font-family: verdana, arial, sans-serif ;font-size: 8pt">
  <div class="row">
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
      <?= $viewinfo ?> 
    </div>
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
     <?= $gvGps ?>
    </div>
    </div>
  </div>


 <?php

 /** *js radio column
    *@author adityia@lukison.com

**/
$this->registerJs("
$(document).on('click', '[data-toggle-map-detail-erp]', function(e){

  e.preventDefault();

  var grid = $('#detail-grid-map-id');

 
  var val  = $('input[name=kvradio]:checked').val();

   if(val != undefined){  
	  $.ajax({
	           url: '/master/customers/update-detail-map',
	           //cache: true,
	           type: 'POST',
	           data:{val:val},
	           dataType: 'json',
	           success: function(result) {
	             if (result == 1){
	                 $('#modal').modal('hide');

	             }
	            }
	          });
        }
   

//   grid.on('grid.radiochecked', function(ev, key, val) {
//     alert(val);
// });

})




",$this::POS_READY);


 ?>