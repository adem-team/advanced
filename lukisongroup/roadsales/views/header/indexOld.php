<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Json;
use yii\web\Request;
use kartik\daterange\DateRangePicker;
use kartik\tabs\TabsX;
use yii\widgets\ListView;
use yii\data\ArrayDataProvider;
use lukisongroup\roadsales\models\SalesRoadHeaderSearch;

$this->sideCorp = 'PT.Effembi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'sales_road';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - SALES ROAD');          				/* title pada header page */
$this->params['breadcrumbs'][] = $this->title; 

	/**
	* COLUMN DATA.
	*/
	$columnRoadHeader=[
		/*No Urut*/
		[
			'class'=>'kartik\grid\SerialColumn',
			'contentOptions'=>['class'=>'kartik-sheet-style'],
			'width'=>'10px',
			'header'=>'No.',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(113, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		[
			'class'=>'kartik\grid\ExpandRowColumn',
			'width'=>'50px',
			'header'=>'Detail',
			'value'=>function ($model, $key, $index, $column) {
				return GridView::ROW_COLLAPSED;
			},
			'detail'=>function ($model, $key, $index, $column){
				$searchModelExpand = new SalesRoadHeaderSearch([
					'USER_ID'=>$model->USER_ID,
					//'CREATED_BY'=>$models->CREATED_BY,
					'CREATED_AT'=>$model->TGL
				]);
				$dataProviderExpand = $searchModelExpand->searchDetail(Yii::$app->request->queryParams);
				
				return Yii::$app->controller->renderPartial('indexExpand',[
					'dataProviderExpand'=>$dataProviderExpand,
					//'searchModelExpand'=>$searchModelExpand
				]); 
			},
			'collapseTitle'=>'Close Exploler',
			'expandTitle'=>'Click to views detail',
			
			//'headerOptions'=>['class'=>'kartik-sheet-style'] ,
			// 'allowBatchToggle'=>true,
			'expandOneOnly'=>true,
			// 'enableRowClick'=>true,
			//'disabled'=>true,
			'headerOptions'=>[
				'style'=>[
					
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(74, 206, 231, 1)',
				]
			],
			'contentOptions'=>[
				'style'=>[
				
					'text-align'=>'center',
					'width'=>'10px',
					'height'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*TGL*/
		[
			'attribute'=>'TGL',
			'label'=>'TGL',
			'hAlign'=>'center',
			'vAlign'=>'middle',
			//'group'=>true,
			//'filter'=>true,
			'filterType' => GridView::FILTER_DATE,
			'filterOptions'=>[
				'style'=>'id:test',
			 ],
            'filterWidgetOptions' => [					
				'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',					 
                    'autoclose' => true,
                    'todayHighlight' => true,
					//'format' => 'dd-mm-yyyy hh:mm',
					'autoWidget' => false,
					//'todayBtn' => true,
                ]
            ],	
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(113, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*USER*/
		[
			'attribute'=>'Username',
			'label'=>'Employee',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'filter'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'100px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(113, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'100px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],		
		/*CUSTOMER*/
		[
			'attribute'=>'CUSTOMER',
			'label'=>'CUSTOMER',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'filter'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'100px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(113, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'100px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*SUBJECT*/
		[
			'attribute'=>'JUDUL',
			'label'=>'SUBJECT',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'filter'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'300px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(113, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'300px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*NOTE*/
		[
			'attribute'=>'CASE_NOTE',
			'label'=>'NOTE',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'filter'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'300px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(113, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'300px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*LATITUDE*/
		[
			'attribute'=>'LAT',
			'label'=>'LAT',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'filter'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(113, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*LONGITUDE*/
		[
			'attribute'=>'LAG',
			'label'=>'LAG',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'filter'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(113, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'50px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
	];

	/*
	 * GRIDVIEW ROAD LIST
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	$_gvRoadHeader= GridView::widget([
		'id'=>'gv-road-header',
		'dataProvider'=> $dataProvider,
		'filterModel' => $searchModel,
		'filterRowOptions'=>['style'=>'background-color:rgba(214, 255, 138, 1); align:center'],
		'columns' =>$columnRoadHeader,		
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-road-header',
			   ],
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false,
		'toolbar'=> ['',
				//['content'=>''],
				//'{export}',
				//'{toggleData}',
				
			],
		'panel'=>[
			'type'=>GridView::TYPE_INFO,
			'heading'=>"<span class='fa fa-motorcycle fa-xs'><b> Sales Road</b></span>",
			'type'=>'info',
			'before'=> false,								
			'footer'=>false,
		],
		'floatOverflowContainer'=>true,
		'floatHeader'=>true,
	]);
?>
<div class="content">
  <div  class="row" style="padding:10px;padding-left:3px ">
		<div class="col-xs-12 col-sm-12 col-lg-12" style="font-family: tahoma ;font-size: 9pt;">
			<?=$_gvRoadHeader?>
		</div>
	</div>
</div>