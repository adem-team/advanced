<?php
use kartik\helpers\Html;
use kartik\widgets\Select2;
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
use yii\web\View;
use kartik\detail\DetailView;


use lukisongroup\efenbi\rasasayang\models\TransaksiType;
use lukisongroup\efenbi\rasasayang\models\Store;

$this->sideCorp = 'PT. Efenbi Sukses Makmur';                       	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'efenbi_rasasayang';                                     		/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Marketing Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;  
// $this->registerJs($this->render('modal_item.js'),View::POS_READY);
// echo $this->render('modal_item'); //echo difinition

	// $data=$dataProvider->allModels;
	// print_r($data[0]);
	$vwTransRptDetail=DetailView::widget([		
        'model' => $dataProvider->allModels[0],
        'attributes' => [
    		[
				'columns' => [
					[
						'attribute'=>'OUTLET_ID', 
						'label'=>'OUTLET ID', 
						'displayOnly'=>true,
						'labelColOptions'=>['style'=>'width:20%;text-align:right'],
						'valueColOptions'=>['style'=>'width:30%;text-align:left'],
					],
					[
						//JAM MEMULAI PERJALANAN DARI DISTRIBUTOR/OTHER
						'attribute'=>'TRANS_DATE', 
						//'label'=>'PIC',
						'labelColOptions'=>['style'=>'width:20%;text-align:right'],
						'valueColOptions'=>['style'=>'width:30%;text-align:left'],
						'displayOnly'=>true
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'OUTLET_NM', 
						'label'=>'OUTLET NAME',
						'labelColOptions'=>['style'=>'width:20%;text-align:right'],
						'valueColOptions'=>['style'=>'width:30%;text-align:left'],
						'displayOnly'=>true
					],
					[
						'attribute'=>'TRANS_TIME',
						'label'=>'TRANS_TIME',
						'labelColOptions'=>['style'=>'width:20%;text-align:right'],
						'valueColOptions'=>['style'=>'width:30%;text-align:left'],
						'displayOnly'=>true
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'USER_ID', 
						'label'=>'USER ID',
						'displayOnly'=>true,
						'labelColOptions'=>['style'=>'width:20%;text-align:right'],
						'valueColOptions'=>['style'=>'width:30%;text-align:left'],
					],
					[
						'attribute'=>'USER_ID', 
						'label'=>'USER NAME',
						'labelColOptions'=>['style'=>'width:20%;text-align:right'],
						'valueColOptions'=>['style'=>'width:30%;text-align:left'],
						'displayOnly'=>true
					],
				],
			]				
        ],
		'mode'=>DetailView::MODE_VIEW,
		'enableEditMode'=>false,
		'mainTemplate'=>'{detail}',
		'panel'=>[
			'heading'=>"<i class='fa fa-info-circle fa-1x'></i> DETAIL INFO",
			'type'=>DetailView::TYPE_INFO,
		],		
		
    ]); 
	
	/**
	* GRIDVIEW DETAIL STOCK.
	*/
	$aryStt= [
	  ['STATUS' => 0, 'STT_NM' => 'Disable'],		  
	  ['STATUS' => 1, 'STT_NM' => 'Enable']
	];	
	$valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');
	$bColor='rgba(90, 87, 134, 0.8)';
	$bColor1='rgba(251, 157, 52, 1)';
	$gvAttributeTransRpt=[
		[
			'class'=>'kartik\grid\SerialColumn',
			'contentOptions'=>['class'=>'kartik-sheet-style'],
			'width'=>'10px',
			'header'=>'No.',
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','10px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('center','10px',''),
		],
			
		//ITEM_NM.
		[
			'attribute'=>'ITEM_NM',
			'filter'=>false,
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','150px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','150px',''),
			
		],	
		//QTY_ORDER.
		[
			'attribute'=>'QTY_ORDER',
			'filter'=>false,
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','50px',''),
			
		],		
		//QTY_BUY.
		[
			'attribute'=>'QTY_BUY',
			'filter'=>false,
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','50px',''),
			
		],	
		//QTY_RCVD.
		[
			'attribute'=>'QTY_RCVD',
			'filter'=>false,
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','50px',''),
			
		],	
		//QTY_SELL.
		[
			'attribute'=>'QTY_SELL',
			'filterType'=>false,
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50px',$bColor),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','50px',''),
			
		]		
	];

	$gvTransRptDetailStok=GridView::widget([
		'id'=>'gv-trans-rpt-detail',
		'dataProvider' => $dataProvider,
		//'filterModel' => $searchModel,
		'columns'=>$gvAttributeTransRpt,				
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-trans-rpt-detail',
		    ],						  
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>true,
		'autoXlFormat'=>true,
		'export' => false,
		'panel'=>[''],
		'toolbar' => [
			''
		],
		'panel' => false,
		'summary'=>false,
	]); 
	
	/**
	* GRIDVIEW DETAIL SALES
	*/
	$bColorSales1='rgba(126, 213, 95, 0.9)';
	$gvAttributeTransRptSales=[
		[
			'class'=>'kartik\grid\SerialColumn',
			'contentOptions'=>['class'=>'kartik-sheet-style'],
			'width'=>'10px',
			'header'=>'No.',
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','10px',$bColorSales1),
			'contentOptions'=>Yii::$app->gv->gvContainBody('center','10px',''),
		],
			
		//ITEM_NM.
		[
			'attribute'=>'ITEM_NM',
			'filter'=>false,
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','150px',$bColorSales1),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','150px',''),
			
		],	
		//QTY_ORDER.
		[
			'attribute'=>'QTY_ORDER',
			'filter'=>false,
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColor)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50px',$bColorSales1),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','50px',''),
			
		],		
		//QTY_BUY.
		[
			'attribute'=>'QTY_BUY',
			'filter'=>false,
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColorSales1)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50px',$bColorSales1),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','50px',''),
			
		],	
		//QTY_RCVD.
		[
			'attribute'=>'QTY_RCVD',
			'filter'=>false,
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColorSales1)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50px',$bColorSales1),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','50px',''),
			
		],	
		//QTY_SELL.
		[
			'attribute'=>'QTY_SELL',
			'filterType'=>false,
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColorSales1)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','50px',$bColorSales1),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','50px',''),
			
		]		
	];
	$gvTransRptDetailSales=GridView::widget([
		'id'=>'gv-trans-rpt-detail-sales',
		'dataProvider' => $dataProvider,
		//'filterModel' => $searchModel,
		'columns'=>$gvAttributeTransRptSales,				
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-trans-rpt-detail-sales',
		    ],						  
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>true,
		'autoXlFormat'=>true,
		'export' => false,
		'panel'=>[''],
		'toolbar' => [
			''
		],
		'panel' => false,
		'summary'=>false,
	]);
	
	
?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div class="col-xs-12 col-sm-6 col-dm-6 col-lg-6" style="font-family: tahoma ;font-size: 8pt;">
		<div class="row" style="padding-right:5px" style="font-family: tahoma ;font-size: 8pt;">
			<?=$vwTransRptDetail?>
			<?=$gvTransRptDetailStok?>
		</div>
	</div>
	<div class="col-xs-12 col-sm-6 col-dm-6 col-lg-6" style="font-family: tahoma ;font-size: 8pt;">
		<div class="row" style="padding-right:5px" style="font-family: tahoma ;font-size: 8pt;">
			<?=$gvTransRptDetailSales?>
		</div>
	</div>
	
</div>

