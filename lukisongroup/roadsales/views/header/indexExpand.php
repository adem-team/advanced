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

$this->sideCorp = 'PT.Effembi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'sales_road';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - SALES ROAD');          				/* title pada header page */
$this->params['breadcrumbs'][] = $this->title; 

	//print_r($dataProviderExpand->getModels());
	/**
	* COLUMN DATA.
	*/
	$columnRoadHeaderDetail=[
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
		/*USER
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
		*/
		/*TGL*/
		[
			'attribute'=>'TGL',
			'label'=>'TGL',
			'hAlign'=>'center',
			'vAlign'=>'middle',
			'value'=>function($model){
				return Yii::$app->formatter->asDate($model->CREATED_AT,'php:H:m:s');
			},
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'60px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(113, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'60px',
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
					'width'=>'150px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(113, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'150px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],		
		/*CASE OF*/
		[
			'attribute'=>'CASE_NM',
			'label'=>'CASE OF',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'filter'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'150px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(113, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'150px',
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
	];

	/*
	 * GRIDVIEW ROAD LIST
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	$_gvRoadHeaderExpand= GridView::widget([
		'id'=>'gv-road-header-expand',
		'rowOptions' => function ($model, $key, $index, $grid) {
                return ['id' => $model->ROAD_D, 'onclick' => '						
						$(document).ready(function(){
							var mtgl="'.$model->TGL.'";
							var muser_id="'.$model->USER_ID.'";
							//alert(user_id);
								$.fn.modal.Constructor.prototype.enforceFocus = function(){};
								// e.preventDefault(); 		
								$("#modal-view").modal("show")
								.find("#modalContent")
								.load("/roadsales/header/disply-image?tgl='.$model["TGL"].'&user_id='.$model["USER_ID"].'");
						}); 			
					'	
				];
        },
		'dataProvider'=> $dataProviderExpand,
		//'filterModel' => $searchModelExpand,
		//'filterRowOptions'=>['style'=>'background-color:rgba(214, 255, 138, 1); align:center'],
		'columns' =>$columnRoadHeaderDetail,	
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-road-header-expand',
			   ],
		],		
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false,
		'panel'=>[
			'type'=>GridView::TYPE_INFO,
			'heading'=>false,
			'type'=>'warnning',
			'before'=> false,								
			'footer'=>false,
		],
		// 'floatOverflowContainer'=>true,
		// 'floatHeader'=>true,
	]);
?>
<div class="content">
	<div  class="row" style="padding:10px;padding-left:3px ">
		<div class="col-xs-12 col-sm-12 col-lg-12" style="font-family: tahoma ;font-size: 9pt;">
			<?=$_gvRoadHeaderExpand?>
			<div style="font-family:tahoma,arial, sans-serif;font-size:9pt; color:red;"><b style="font-size:12pt;">*</b><b style="font-size:8pt;"> Klik di dalam table, untuk melihat Gambar.</b></div>
		</div>
	</div>
</div>
			
