<?php
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use kartik\widgets\Spinner;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\helpers\Json;
use yii\web\Response;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;

use app\models\hrd\Dept;
use lukisongroup\master\models\Distributor;

	$dropDist = ArrayHelper::map(Distributor::find()->all(), 'KD_DISTRIBUTOR', 'NM_DISTRIBUTOR');
	/* $aryField= [
		//MAIN DATA 
		['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '50px','label'=>'Date','align'=>'center','vAlign'=>'middle','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>false,'filterType'=>false,'mergeHeader'=>false,'filterColspn'=>0]],
		['ID' =>1, 'ATTR' =>['FIELD'=>'NM_BARANG','SIZE' => '250px','label'=>'SKU NM','align'=>'left','vAlign'=>'top','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>true,'filterType'=>false,'mergeHeader'=>false,'filterColspn'=>7]],
		['ID' =>2, 'ATTR' =>['FIELD'=>'SO_QTY','SIZE' => '50px','label'=>'QTY.PCS','align'=>'right','vAlign'=>'top','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>true,'filterType'=>false,'mergeHeader'=>true,'filterColspn'=>0]],		
		['ID' =>3, 'ATTR' =>['FIELD'=>'UNIT_BARANG','SIZE' => '50px','label'=>'UNIT','align'=>'center','vAlign'=>'top','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>true,'filterType'=>false,'mergeHeader'=>true,'filterColspn'=>0]],
		['ID' =>4, 'ATTR' =>['FIELD'=>'kartonqty','SIZE' => '50px','label'=>'QTY.KARTON','align'=>'right','vAlign'=>'top','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>true,'filterType'=>false,'mergeHeader'=>true,'filterColspn'=>0]],
		['ID' =>5, 'ATTR' =>['FIELD'=>'beratunit','SIZE' => '50px','label'=>'WEIGHT.GRAM','align'=>'right','vAlign'=>'top','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>true,'filterType'=>false,'mergeHeader'=>true,'filterColspn'=>0]],
		['ID' =>6, 'ATTR' =>['FIELD'=>'HARGA_DIS','SIZE' => '50px','label'=>'DIST.PRICE','align'=>'right','vAlign'=>'top','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>true,'filterType'=>false,'mergeHeader'=>true,'filterColspn'=>0]],
		['ID' =>7, 'ATTR' =>['FIELD'=>'subtotaldist','SIZE' => '50px','label'=>'SUB.TTL','align'=>'right','vAlign'=>'top','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>true,'filterType'=>false,'mergeHeader'=>true,'filterColspn'=>0]],
		['ID' =>8, 'ATTR' =>['FIELD'=>'disNm','SIZE' => '100px','label'=>'DISTRIBUTION','align'=>'left','vAlign'=>'top','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>$dropDist,'filterType'=>'GridView::FILTER_SELECT2','mergeHeader'=>false,'filterColspn'=>0]],		
		['ID' =>9, 'ATTR' =>['FIELD'=>'USER_ID','SIZE' => '50px','label'=>'IMPORT.BY','align'=>'left','vAlign'=>'top','warna'=>'255, 255, 48, 4','warnaFilter'=>'255, 255, 255, 1','filter'=>true,'filterType'=>false,'mergeHeader'=>false,'filterColspn'=>0]],
	];
	$valFields = ArrayHelper::map($aryField, 'ID', 'ATTR');
	
	$actionClass='btn btn-info btn-xs';
	$actionLabel='Update';
	$attDinamik =[];
	foreach($valFields as $key =>$value[]){
		$attDinamik[]=[
			'attribute'=>$value[$key]['FIELD'],
			'label'=>$value[$key]['label'],
			'filterType'=>$value[$key]['filterType'],
			'filter'=>$value[$key]['filter'],
			'filterOptions'=>[
				'style'=>'background-color:rgba('.$value[$key]['warnaFilter'].'); align:center',
				'colspan'=>$value[$key]['filterColspn'],
			 ],
			'filterWidgetOptions'=>[
				'pluginOptions'=>[
					'allowClear'=>true,
					'contentOptions'=>[
						'style'=>[
						  'text-align'=>'left',
						  'font-family'=>'tahoma, arial, sans-serif',
						  'font-size'=>'8pt',
						]
					]
				],
			],
			'hAlign'=>'right',
			'vAlign'=>$value[$key]['vAlign'],
			'mergeHeader'=>$value[$key]['mergeHeader'],
			'noWrap'=>true,
			'headerOptions'=>[
					'style'=>[
					'text-align'=>'center',
					'width'=>$value[$key]['SIZE'],
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					//'background-color'=>'rgba(97, 211, 96, 0.3)',
					'background-color'=>'rgba('.$value[$key]['warna'].')',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>$value[$key]['align'],
					'width'=>$value[$key]['SIZE'],
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					//'background-color'=>'rgba(13, 127, 3, 0.1)',
				]
			],
		];
	};  */
	 $attributeManualLatest=[
		//TGL
		[
			'attribute'=>'TGLAlias1',
			'label'=>'Date',
			'filterType'=>GridView::FILTER_DATE,
			'filterWidgetOptions'=>[	
				'pluginOptions' => [				
						'format' => 'yyyy-mm-dd',					 
						'autoclose' => true,
						'todayHighlight' => true,
						//'format' => 'dd-mm-yyyy hh:mm',
						'autoWidget' => false,
						//'todayBtn' => true,
				]
			],
			'filter'=>true,
			'filterOptions'=>[
				
				'style'=>'background-color:rgba(255, 255, 255, 1); align:center',
				'colspan'=>'0',
			],			
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 255, 48, 4)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt'
				]
			],
		],
		//NM_BARANG
		[
			'attribute'=>'KdBrg1',
			'label'=>'SKU NM',
			'filterType'=>GridView::FILTER_SELECT2,
			'filterWidgetOptions'=>[	
				'pluginOptions'=>[
					'allowClear'=>true,
					'contentOptions'=>[
						'style'=>[
						  'text-align'=>'left',
						  'font-family'=>'tahoma, arial, sans-serif',
						  'font-size'=>'8pt',
						]
					]
				],
			],
			'filter'=>$aryBrgID,
			'filterOptions'=>[
				'style'=>'background-color:rgba(255, 255, 255, 1); align:center',
				'colspan'=>'7',
			],		
			'filterInputOptions'=>['placeholder'=>'--Pilih--'],		
			'value'=>function($model){
					return $model['NM_BARANG'];
			},
			'hAlign'=>'right',
			'vAlign'=>'top',
			'mergeHeader'=>false,
			'noWrap'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'250',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 255, 48, 4)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'250',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt'
				]
			],
		],
		//QTY.PCS
		[
			'attribute'=>'SO_QTY',
			'label'=>'QTY.PCS',
			'filterType'=>false,
			'filterWidgetOptions'=>[	
				'pluginOptions'=>[
					'allowClear'=>true,
					'contentOptions'=>[
						'style'=>[
						  'text-align'=>'left',
						  'font-family'=>'tahoma, arial, sans-serif',
						  'font-size'=>'8pt',
						]
					]
				],
			],
			'filter'=>true,
			'filterOptions'=>[
				'style'=>'background-color:rgba(255, 255, 255, 1); align:center',
				'colspan'=>'0',
			],		
			'hAlign'=>'right',
			'vAlign'=>'top',
			'mergeHeader'=>true,
			'noWrap'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 255, 48, 4)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'right',
					'width'=>'50',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt'
				]
			],
		],
		//UNIT_BARANG
		[
			'attribute'=>'UNIT_BARANG',
			'label'=>'UNIT',
			'filterType'=>false,
			'filterWidgetOptions'=>[	
				'pluginOptions'=>[
					'allowClear'=>true,
					'contentOptions'=>[
						'style'=>[
						  'text-align'=>'left',
						  'font-family'=>'tahoma, arial, sans-serif',
						  'font-size'=>'8pt',
						]
					]
				],
			],
			'filter'=>true,
			'filterOptions'=>[
				'style'=>'background-color:rgba(255, 255, 255, 1); align:center',
				'colspan'=>'0',
			],		
			'hAlign'=>'right',
			'vAlign'=>'top',
			'mergeHeader'=>true,
			'noWrap'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 255, 48, 4)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt'
				]
			],
		],
		//QTY-CARTON
		[
			'attribute'=>'kartonqty',
			'label'=>'QTY.CARTON',
			'filterType'=>false,
			'filterWidgetOptions'=>[	
				'pluginOptions'=>[
					'allowClear'=>true,
					'contentOptions'=>[
						'style'=>[
						  'text-align'=>'left',
						  'font-family'=>'tahoma, arial, sans-serif',
						  'font-size'=>'8pt',
						]
					]
				],
			],
			'filter'=>true,
			'filterOptions'=>[
				'style'=>'background-color:rgba(255, 255, 255, 1); align:center',
				'colspan'=>'0',
			],		
			'hAlign'=>'right',
			'vAlign'=>'top',
			'mergeHeader'=>true,
			'noWrap'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 255, 48, 4)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'right',
					'width'=>'50',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt'
				]
			],
		],
		//WEIGHT.GRAM
		[
			'attribute'=>'beratunit',
			'label'=>'QTY.CARTON',
			'filterType'=>false,
			'filterWidgetOptions'=>[	
				'pluginOptions'=>[
					'allowClear'=>true,
					'contentOptions'=>[
						'style'=>[
						  'text-align'=>'left',
						  'font-family'=>'tahoma, arial, sans-serif',
						  'font-size'=>'8pt',
						]
					]
				],
			],
			'filter'=>true,
			'filterOptions'=>[
				'style'=>'background-color:rgba(255, 255, 255, 1); align:center',
				'colspan'=>'0',
			],		
			'hAlign'=>'right',
			'vAlign'=>'top',
			'mergeHeader'=>true,
			'noWrap'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 255, 48, 4)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'right',
					'width'=>'50',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt'
				]
			],
		],
		//HARGA_DIS
		[
			'attribute'=>'HARGA_DIS',
			'label'=>'DIST.PRICE',
			'filterType'=>false,
			'filterWidgetOptions'=>[	
				'pluginOptions'=>[
					'allowClear'=>true,
					'contentOptions'=>[
						'style'=>[
						  'text-align'=>'left',
						  'font-family'=>'tahoma, arial, sans-serif',
						  'font-size'=>'8pt',
						]
					]
				],
			],
			'filter'=>true,
			'filterOptions'=>[
				'style'=>'background-color:rgba(255, 255, 255, 1); align:center',
				'colspan'=>'0',
			],		
			'hAlign'=>'right',
			'vAlign'=>'top',
			'mergeHeader'=>true,
			'noWrap'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 255, 48, 4)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'right',
					'width'=>'50',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt'
				]
			],
		],
		//SUB.TTL
		[
			'attribute'=>'subtotaldist',
			'label'=>'SUB.TTL',
			'filterType'=>false,
			'filterWidgetOptions'=>[	
				'pluginOptions'=>[
					'allowClear'=>true,
					'contentOptions'=>[
						'style'=>[
						  'text-align'=>'left',
						  'font-family'=>'tahoma, arial, sans-serif',
						  'font-size'=>'8pt',
						]
					]
				],
			],
			'filter'=>true,
			'filterOptions'=>[
				'style'=>'background-color:rgba(255, 255, 255, 1); align:center',
				'colspan'=>'0',
			],		
			'hAlign'=>'right',
			'vAlign'=>'top',
			'mergeHeader'=>true,
			'noWrap'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 255, 48, 4)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'right',
					'width'=>'50',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt'
				]
			],
		],
		//DISTRIBUTION
		[
			'attribute'=>'disNm1',
			'label'=>'DISTRIBUTION',			
			'filterType'=>GridView::FILTER_SELECT2,
			'filter'=>$dropDist,
			'filterInputOptions'=>['placeholder'=>'--Pilih--'],
			'filterWidgetOptions'=>[				
				'pluginOptions'=>[
					'allowClear'=>true,
					'maximumInputLength' => 10
				],
			],	
			'filterOptions'=>[
				'style'=>'background-color:rgba(255, 255, 255, 1); align:center; width:100',
				'colspan'=>'0',
			],					
			'hAlign'=>'right',
			'vAlign'=>'top',
			'mergeHeader'=>false,
			'noWrap'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'100',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 255, 48, 4)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'Left',
					'width'=>'100',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt'
				]
			],
		],
		//USER_ID
		[
			'attribute'=>'USER_ID',
			'label'=>'IMPORT.BY',
			'filterType'=>false,
			'filterWidgetOptions'=>[	
				'pluginOptions'=>[
					'allowClear'=>true,
					'contentOptions'=>[
						'style'=>[
						  'text-align'=>'left',
						  'font-family'=>'tahoma, arial, sans-serif',
						  'font-size'=>'8pt',
						]
					]
				],
			],
			'filter'=>true,
			'filterOptions'=>[
				'style'=>'background-color:rgba(255, 255, 255, 1); align:center',
				'colspan'=>'0',
			],		
			'hAlign'=>'right',
			'vAlign'=>'top',
			'mergeHeader'=>true,
			'noWrap'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(255, 255, 48, 4)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'Left',
					'width'=>'50',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt'
				]
			],
		]
	]; 
	
	$gvListImport=GridView::widget([
		'id'=>'gv-data-latest-gudang',
		'dataProvider' => $dataProviderViewImport,
		'filterModel' => $searchModelViewImport,
		'columns'=>$attributeManualLatest,//$attDinamik,					
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-data-latest-gudang',
		    ],						  
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false,
		'panel'=>[''],
		'toolbar' => [
			''
		],
		'panel' => [
			'heading'=>'GUDANG - Lates Data Import <i class="fa fa fa-shield fa-1x"></i>',  
			'type'=>'info',
			'showFooter'=>false,
		],
	]); 
?>
<?=$gvListImport?>