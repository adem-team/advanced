<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use kartik\daterange\DateRangePicker;
use yii\db\ActiveRecord;
use yii\data\ArrayDataProvider;
	
	//print_r($dataModelsHeader1);
	/*[1] LIST VIEW INFO */
	$vwHeader1=DetailView::widget([		
        'model' => $dataModelsHeader1[0],
        'attributes' => [
    		[
				'columns' => [
					[
						'attribute'=>'TGL', 
						'label'=>'DATE',
						'displayOnly'=>true,
						'valueColOptions'=>['style'=>'width:30%']
					],
					[
						//JAM MEMULAI PERJALANAN DARI DISTRIBUTOR/OTHER
						'attribute'=>'TIME_DAYSTART', 
						'format'=>'raw',
						'value'=> $dataModelsHeader1[0]['TIME_DAYSTART']!=''?$dataModelsHeader1[0]['TIME_DAYSTART']:"<span class='badge' style='background-color:#ff0000'>ABSENT </span>",
						'label'=>'START TIME',
						'valueColOptions'=>['style'=>'width:30%'], 
						//'displayOnly'=>true
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'USER_NM', 
						'label'=>'USER NAME',
						'valueColOptions'=>['style'=>'width:30%'], 
						'displayOnly'=>true
					],
					[
						//JAM SELESAI PERJALANAN DARI DISTRIBUTOR/OTHER
						'attribute'=>'TIME_DAYEND',
						'format'=>'raw',
						'value'=>$dataModelsHeader1[0]['TIME_DAYEND']!=''?$dataModelsHeader1[0]['TIME_DAYEND']:"<span class='badge' style='background-color:#ff0000'>ABSENT </span>",						
						'label'=>'END TIME',
						'valueColOptions'=>['style'=>'width:30%'], 
						'displayOnly'=>true
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'SCDL_GRP_NM', 
						'label'=>'GROUP',
						'displayOnly'=>true,
						'valueColOptions'=>['style'=>'width:30%']
					],
					[
						//GPS IN -> VALUE AND STATUS
						'attribute'=>'DISTANCE_DAYSTART', 
						'label'=>'IN GPS',
						'format'=>'raw', 
						'value'=>"<span class='badge' style='background-color:#ff0000'>'' </span>".' '.$dataModelsHeader1[0]['DISTANCE_DAYSTART'],
						//'value'=>'<kbd>'.$model->book_code.'</kbd>',
						'valueColOptions'=>['style'=>'width:30%'], 
						'displayOnly'=>true
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'CUST_TIPE_NM', 
						'label'=>'TOTAL TIME',
						'valueColOptions'=>['style'=>'width:30%'], 
						'displayOnly'=>true
					],
					[
						//GPS IN -> VALUE AND STATUS
						'attribute'=>'DISTANCE_DAYEND', 
						'label'=>'OUT GPS',
						'format'=>'raw', 
						'value'=>"<span class='badge' style='background-color:#ff0000'>'' </span>".' '.$dataModelsHeader1[0]['DISTANCE_DAYEND'],
						//'value'=>'<kbd>'.$model->book_code.'</kbd>',
						'valueColOptions'=>['style'=>'width:30%'], 
						'displayOnly'=>true
					],
				],
			],					
        ],
		'mode'=>DetailView::MODE_VIEW,
		'enableEditMode'=>false,
		'mainTemplate'=>'{detail}',
		'panel'=>[
			'heading'=>'[A] USER INFO',
			'type'=>DetailView::TYPE_DANGER,
		],		
		
    ]); 
	
	/*[2] GRID VIEW HEAD 1 */
	$actionClass='btn btn-info btn-xs';
	$actionLabel='View';
	$attDinamik2 =[];
	$headColomnEvent2=[
		//['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '10px','label'=>'Date','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1''value'=>function($models){ return 'x';}]],
		['ID' =>0, 'ATTR' =>['FIELD'=>'CUST_NM','SIZE' => '10px','label'=>'Customer','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1','value'=>function($models){ return $models['CUST_NM'];}]],
		['ID' =>1, 'ATTR' =>['FIELD'=>'CUST_CHKIN','SIZE' => '10px','label'=>'In.Time','align'=>'center','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1','value'=>function($models){ return $models['CUST_CHKIN'];}]],
		['ID' =>2, 'ATTR' =>['FIELD'=>'CUST_CHKOUT','SIZE' => '10px','label'=>'Out.Time','align'=>'center','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1','value'=>function($models){ return $models['CUST_CHKOUT'];}]],
		['ID' =>3, 'ATTR' =>['FIELD'=>'ttl_time_cust','SIZE' => '10px','label'=>'Visit.Time','align'=>'center','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1','value'=>function($models){ return $models['ttl_time_cust']!=''?$models['ttl_time_cust']:"<span class='badge' style='background-color:#ff0000'>ABSENT </span>";}]],
		['ID' =>4, 'ATTR' =>['FIELD'=>'JRK_TEMPUH','SIZE' => '10px','label'=>'Distance.Time','align'=>'center','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1','value'=>function($models){ return $models['JRK_TEMPUH']!=''?$models['JRK_TEMPUH']:"<span class='badge' style='background-color:#ff0000'>ABSENT </span>";}]],
		['ID' =>5, 'ATTR' =>['FIELD'=>'STT_VISIT','SIZE' => '10px','label'=>'Status','align'=>'center','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1','value'=>function($models){ return $models['STT_VISIT']!=''?$models['STT_VISIT']:"<span class='badge' style='background-color:#ff0000'>''</span>";}]],
	];
	$gvHeadColomn2 = ArrayHelper::map($headColomnEvent2, 'ID', 'ATTR');
	$attDinamik2[] =[
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
	foreach($gvHeadColomn2 as $key =>$value[]){
		$attDinamik2[]=[
			'attribute'=>$value[$key]['FIELD'],
			'value'=>$value[$key]['value'],
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
	};
	
	$gvCustDaily= GridView::widget([
		'id'=>'header2-id',
		'export' => false,
		//'panel' => false,
		'dataProvider' => $dataProviderHeader2,
		//'filterModel' => $searchModel,					
		//'filterRowOptions'=>['style'=>'background-color:rgba(74, 206, 231, 1); align:center'],
		'columns' => $attDinamik2,
		'toolbar' => [
			'',
		],
		'panel' => [
			'heading'=>'<h3 class="panel-title">[B] LIST TIME VISITING</h3>',
			'type'=>'danger',
			'footer'=>false,
		],
	]);	
	
	/*[3] GRID VIEW INVENTORY */
	$inventory=GridView::widget([
		'id'=>'inventory-list',
        'dataProvider' => $inventoryProvider,
		//'filterModel' => $searchModelInventory,
        'columns' => [
			[
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
			],
			[
				'attribute'=>'NAME_ITEM',
				'label'=>'ITEMS',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			[
				'attribute'=>'STOCK',
				'label'=>'STOCK/Pcs',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'width'=>'11px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			[
				'attribute'=>'SELL_IN',
				'label'=>'SELL IN/Pcs',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			[
				'attribute'=>'SELL_OUT',
				'label'=>'SELL OUT/Pcs',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			]
		],
		'toolbar' => [
			'',
		],
		'panel' => [
			'heading'=>'<h3 class="panel-title">[C] LIST INVENTORY</h3>',
			'type'=>'danger',
			'footer'=>false,
			
		],
    ]);
	
	/*[4] GRID VIEW EXPIRED */
	$expired=GridView::widget([
		'id'=>'inventory-list',
        'dataProvider' => $inventoryProvider,
		//'filterModel' => $searchModelInventory,
        'columns' => [
			[
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
			],
			[
				'attribute'=>'NAME_ITEM',
				'label'=>'ITEMS',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			[
				'attribute'=>'STOCK',
				'label'=>'STOCK/Pcs',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'width'=>'11px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			[
				'attribute'=>'SELL_IN',
				'label'=>'SELL IN/Pcs',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			[
				'attribute'=>'SELL_OUT',
				'label'=>'SELL OUT/Pcs',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			]
		],
		'toolbar' => [
			'',
		],
		'panel' => [
			'heading'=>'<h3 class="panel-title">[D] LIST EXPIRED</h3>',
			'type'=>'danger',
			'footer'=>false,
			
		],
    ]);
	/*[4] GRID VIEW IMAGE SHOW */
	$visitImage=GridView::widget([
		'id'=>'img-list',
        'dataProvider' => $dataProviderHeader2,
		//'filterModel' => $searchModelImage,
        'columns' => [
			[
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
			],
			[
				'attribute'=>'image_start',
				'format'=>'raw', 
				'label'=>'Image Start',
				//'format'=>['image',['width'=>'100','height'=>'120']],
				'value'=>function($model){				
					$base64 ='data:image/jpg;charset=utf-8;base64,'.$model['IMG_START'];
					//return Html::img($base64,['width'=>'100','height'=>'60','class'=>'img-circle']);
					return $model['IMG_START']!=''?Html::img($base64,['width'=>'140','height'=>'140']):Html::img(Yii::$app->urlManager->baseUrl.'/df.jpg',['width'=>'140','height'=>'140']);
				},
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(74, 206, 231, 1)',
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
			],
			[
				'attribute'=>'image_end',
				'format'=>'raw', 
				'label'=>'Image End',
				//'format'=>['image',['width'=>'100','height'=>'120']],
				'value'=>function($model){				
					$base64 ='data:image/jpg;charset=utf-8;base64,'.$model['IMG_END'];
					return $model['IMG_END']!=''?Html::img($base64,['width'=>'140','height'=>'140']):Html::img(Yii::$app->urlManager->baseUrl.'/df.jpg',['width'=>'140','height'=>'140']);
				},
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(74, 206, 231, 1)',
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
			] 
		
		],
		'toolbar' => [
			'',
		],
		'panel' => [
			'heading'=>'<h3 class="panel-title">LIST IMAGE VISITING</h3>',
			'type'=>'danger',
			'footer'=>false,
		],
    ]);
?>



<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
    <div  class="row" style="margin-top:15px">
        <div class="col-sm-8 col-md-8 col-lg-8">
			<?php
				echo $vwHeader1;
				echo $gvCustDaily;
				echo $inventory;
				echo $expired;
			?>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4">
			<?php
				echo $visitImage;
			?>
		</div>
	</div>
</div>
