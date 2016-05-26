<?php
use kartik\helpers\Html;
use yii\widgets\DetailView;
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

use lukisongroup\master\models\Customers;
use lukisongroup\master\models\Termcustomers;
use lukisongroup\master\models\Distributor;
use lukisongroup\hrd\models\Corp;

//print_r($model[0]);

//echo $model[0]->NmDis;


	/*==PLAN BUDGET|ACTUAL BUDGET==*/
	$attDinamik =[];
	/*GRIDVIEW ARRAY FIELD HEAD*/
	$headColomnEvent=[
		['ID' =>0, 'ATTR' =>['FIELD'=>'NmCustomer','SIZE' => '50px','label'=>'Trade Investment','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>false,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>1, 'ATTR' =>['FIELD'=>'UPDATE_AT','SIZE' => '10px','label'=>'Periode','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>2, 'ATTR' =>['FIELD'=>'Nmprincipel','SIZE' => '10px','label'=>'Budget Plan','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>3, 'ATTR' =>['FIELD'=>'NmDis','SIZE' => '10px','label'=>'%','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>4, 'ATTR' =>['FIELD'=>'NmDis','SIZE' => '10px','label'=>'Budget Actual','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>5, 'ATTR' =>['FIELD'=>'NmDis','SIZE' => '10px','label'=>'%','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
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
	};
	/*GRIDVIEW EXPAND*/
	$attDinamik[]=[	
		'class'=>'kartik\grid\ExpandRowColumn',
		'width'=>'50px',
		'header'=>'Detail',
		'expandOneOnly'=>true,
		'value'=>function ($model, $key, $index, $column) {
			return GridView::ROW_COLLAPSED;
		},
		'detail'=>function ($model, $key, $index, $column){
			/* RENDER */
			return Yii::$app->controller->renderPartial('_reviewDataExpand'
			); 
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
	];
	/*GRIDVIEW ARRAY ACTION*/
	/* $actionClass='btn btn-info btn-xs';
	$actionLabel='Action';
	$attDinamik[]=[
		'class'=>'kartik\grid\ActionColumn',
		'dropdown' => true,
		'template' => '{view1}',
		'dropdownOptions'=>['class'=>'pull-right dropup','style'=>['disable'=>true]],
		'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
		'dropdownButton'=>[
			'class' => $actionClass,
			'label'=>$actionLabel,
			'caret'=>'<span class="caret"></span>',
		],
		 'buttons' => [
			'view1' =>function($url, $model, $key){
					return  '<li>' .Html::a('<span class="fa fa-search-plus fa-dm"></span>'.Yii::t('app', 'Review'),
												['/purchasing/plan-term/review','id'=>$model->CUST_KD_PARENT],[
												'id'=>'img1-id',
												'data-toggle'=>"modal",
												//'data-target'=>"#img1-visit",
												]). '</li>' . PHP_EOL;
			}
		],
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(249, 215, 100, 1)',
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
	/*GRID VIEW BASE*/
	$gvDetalPlanActual= GridView::widget([
		'id'=>'plan-term-data',
		'dataProvider' => $dataProvider,
		//'filterModel' => $searchModel,					
		//'filterRowOptions'=>['style'=>'background-color:rgba(74, 206, 231, 1); align:center'],
		'beforeHeader'=>[
			[
				'columns'=>[
					['content'=>'ITEMS TRAIDE INVESTMENT', 'options'=>['colspan'=>3,'class'=>'text-center info',]],
					['content'=>'PLAN BUDGET', 'options'=>['colspan'=>2, 'class'=>'text-center info']],
					['content'=>'ACTUAL BUDGET', 'options'=>['colspan'=>2, 'class'=>'text-center info']],
					['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center info']],
					//['content'=>'Action Status ', 'options'=>['colspan'=>1,  'class'=>'text-center info']],
				],
			]
		],
		'columns' => $attDinamik,
		/* [
			['class' => 'yii\grid\SerialColumn'],
			'start',
			'end',
			'title',
			['class' => 'yii\grid\ActionColumn'],
		], */
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'plan-term-data',
			],
		],
		'panel' => [
					'heading'=>'<h3 class="panel-title" style="font-family: verdana, arial, sans-serif ;font-size: 9pt;">TERM PLAN</h3>',
					'type'=>'info',
					//'showFooter'=>false,
		],
		'summary'=>false,
		'toolbar'=>false,
		'panel'=>false,
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
	]);

?>

<div class="row" style="font-family: tahoma ;font-size: 9pt;padding-top:30px">
	<!-- PARTIES/PIHAK !-->
	<div class="col-xs-12 col-sm-6 col-md-3" style="font-family: tahoma ;font-size: 9pt">
		<div>
			<?php //echo pihak($model); ?>
		</div>
		<dl>				
			<dt><h6><u><b>PARTIES/PIHAK BERSANGKUTAN :</b></u></h6></dt>

			<dd>1 :	<?= $model[0]->NmCustomer ?></dd>


			<dd>2 :	<?= $model[0]->Nmprincipel ?></dd>


			<dd>3 :	<?= $model[0]->NmDis ?></dd>
		</dl>
	</div>	

	<!-- PERIODE/JANGKA WAKTU !-->
	<div class="col-xs-12 col-sm-6 col-md-3" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
		<div>
			<?php //echo periode($model); ?>
		</div>
		<dl>
			<dt><h6><u><b>PERIODE/JANGKA WAKTU :</b></u></h6></dt>
			<dt style="width:80px; float:left;"> Dari: </dt>
			<dd>:	<?=$model[0]->PERIOD_START ?></dd>

			<dt style="width:80px; float:left;">Sampai:</dt>
			<dd>:	<?=$model[0]->PERIOD_END ?></dd>
		</dl>
	</div>
	
	<!-- TARGET !-->
	<div class="col-xs-3 col-sm-6col-md-12" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
		<div>
			<?php //echo target($model); ?>
		</div>
		<dl>
			<dt style="width:80px;"><h6><u><b>TARGET :</b></u></h6></dt>
			<dd style="width:80px"> Rp.<?=$model->TARGET_VALUE?></dd>
			<dd><?=$model->TARGET_TEXT ?> Rupiah</dd>

		</dl>
	</div>
</div>
<div style="font-family: tahoma ;font-size: 9pt;padding-top:30px">
	<!-- GRID VIEW DETAIL PLAN AND ACTUAL !-->
	<?=$gvDetalPlanActual;?>
</div>
