<?php
use kartik\helpers\Html;
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

//print_r($aryproviderDetailSummary);

/*[2] GRID VIEW HEAD 1 */
	$actionClass='btn btn-info btn-xs';
	$actionLabel='View';
	$attDinamik2 =[];
	$headColomnEvent2=[
		//['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '10px','label'=>'Date','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1''value'=>function($models){ return 'x';}]],
		['ID' =>0, 'ATTR' =>['FIELD'=>'CUST_NM','SIZE' => '10px','label'=>'Customer','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1','value'=>function($models){ return $models['CUST_NM'];}]],
		['ID' =>1, 'ATTR' =>['FIELD'=>'NM_BARANG','SIZE' => '10px','label'=>'Items','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1','value'=>function($models){ return $models['NM_BARANG'];}]],
		['ID' =>2, 'ATTR' =>['FIELD'=>'STOCK','SIZE' => '10px','label'=>'Stock','align'=>'right','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1','value'=>function($models){ return $models['STOCK'];}]],
		['ID' =>3, 'ATTR' =>['FIELD'=>'SELL_IN','SIZE' => '10px','label'=>'Sell.In','align'=>'right','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1','value'=>function($models){ return $models['SELL_IN'];}]],
		['ID' =>4, 'ATTR' =>['FIELD'=>'SELL_OUT','SIZE' => '10px','label'=>'Sell.Out','align'=>'right','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1','value'=>function($models){ return $models['SELL_OUT'];}]],
		['ID' =>5, 'ATTR' =>['FIELD'=>'RETURN_INV','SIZE' => '10px','label'=>'Reture','align'=>'right','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1','value'=>function($models){ return $models['RETURN_INV'];}]],
		['ID' =>6, 'ATTR' =>['FIELD'=>'REQUEST_INV','SIZE' => '10px','label'=>'Request.Order','align'=>'right','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1','value'=>function($models){ return $models['REQUEST_INV'];}]],
		
		/* 
		['ID' =>3, 'ATTR' =>['FIELD'=>'ttl_time_cust','SIZE' => '10px','label'=>'Visit.Time','align'=>'center','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1','value'=>function($models){ return $models['ttl_time_cust']!=''?$models['ttl_time_cust']:"<span class='badge' style='background-color:#ff0000'>ABSENT </span>";}]],
		['ID' =>4, 'ATTR' =>['FIELD'=>'JRK_TEMPUH','SIZE' => '10px','label'=>'Distance.Time','align'=>'center','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1','value'=>function($models){ return $models['JRK_TEMPUH']!=''?$models['JRK_TEMPUH']:"<span class='badge' style='background-color:#ff0000'>ABSENT </span>";}]],
		['ID' =>5, 'ATTR' =>['FIELD'=>'STT_VISIT','SIZE' => '10px','label'=>'Status','align'=>'center','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1','value'=>function($models){ return $models['STT_VISIT']!=''?$models['STT_VISIT']:"<span class='badge' style='background-color:#ff0000'>''</span>";}]],
	 */
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
					//'background-color'=>'rgba('.$value[$key]['warna'].')',
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
		'dataProvider' => $aryproviderDetailSummary,
		//'filterModel' => $searchModel,					
		//'filterRowOptions'=>['style'=>'background-color:rgba(74, 206, 231, 1); align:center'],
		'columns' => $attDinamik2,
		'toolbar' => [
			'',
		],
		'panel' => [
			'heading'=>'<h3 class="panel-title">DETAIL VISITING</h3>',
			'type'=>'info',
			'footer'=>false,
		],
	]);	
?>
	<?=$gvCustDaily?>