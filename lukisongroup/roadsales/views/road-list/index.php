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

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\roadsales\models\SalesRoadListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->sideCorp = 'PT.Effembi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'sales_road';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - CASE LIST ROAD');          				/* title pada header page */
$this->params['breadcrumbs'][] = $this->title; 

	/**
	* STATUS DISABLE/ENABLE
	*/
	function statusList($model){
		if($model['STATUS']==0){
			return Html::a('<i class="fa fa-remove"></i> Disable', '',['class'=>'btn btn-dangger btn-xs', 'style'=>['width'=>'70px','text-align'=>'left'],'title'=>'New']);
		}elseif($model['STATUS']==1){
			return Html::a('<i class="fa fa-check"></i> Enable ', '',['class'=>'btn btn-info btn-xs','style'=>['width'=>'70px','text-align'=>'left'], 'title'=>'Validate']);
		}
	};
	
	/**
	* COLUMN DATA.
	*/
	$columnList=[
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
					'background-color'=>'rgba(221, 235, 29, 0.8)',
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
		/*CASE_NAME*/
		[
			'attribute'=>'CASE_NAME',
			'label'=>'CASE NAME',
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
					'background-color'=>'rgba(221, 235, 29, 0.8)',
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
		/*CASE_DSCRIP*/
		[
			'attribute'=>'CASE_DSCRIP',
			'label'=>'DESCRIPTION',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'filter'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'500px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(221, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'500px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		[
			'attribute'=>'STATUS',
			'label'=>'Status',
			'mergeHeader'=>true,
			'format' => 'raw',
			'hAlign'=>'center',
			'value' => function ($model) {
				return statusList($model);
			},
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'70px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(221, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'70px',
					'height'=>'10px',
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
	$_gvRoadList= GridView::widget([
		'id'=>'gv-road-list',
		'dataProvider'=> $dataProvider,
		'filterModel' => $searchModel,
		'filterRowOptions'=>['style'=>'background-color:rgba(214, 255, 138, 1); align:center'],
		'columns' =>$columnList,		
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-road-list',
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
			'type'=>GridView::TYPE_INFO, //rgba(214, 255, 138, 1)
			'heading'=>"<span class='fa fa-list-ol fa-xs'><b> List Sales Road</b></span>",
			'type'=>'info',
			'before'=>  Html::a('<i class="fa fa-plus"></i> '.
								Yii::t('app', 'New',['modelClass' => 'New',]),'/roadsales/road-list/create',[
									'id'=>'new-list-road',
									'data-toggle'=>"modal",
									'data-target'=>"#model-new-list-road",
									'class' => 'btn btn-success btn-sm'
								]
						).' '.	
						Html::a('<i class="fa fa-download"></i> '.
								Yii::t('app', 'Export',['modelClass' => 'Export',]),'/roadsales/road-list/export-excel',[
									'id'=>'export-list-road',
									'data-pjax' => '1',
									'class' => 'btn btn-info btn-sm'
								]
						),											
			//'footer'=>false,
		],
		'floatOverflowContainer'=>true,
		'floatHeader'=>true,
	]);
?>
<div class="content">
  <div  class="row" style="padding:10px;padding-left:3px ">
		<div class="col-xs-12 col-sm-12 col-lg-12" style="font-family: tahoma ;font-size: 9pt;">
			<?=$_gvRoadList?>
		</div>
	</div>
</div>
