<?php
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;

use lukisongroup\hrd\models\Machine;
use lukisongroup\hrd\models\Key_list;
use lukisongroup\hrd\models\Employe;

	/*
	* === REKAP =========================
	* Key-FIND : AttDinamik-Clalender
	* @author ptrnov [piter@lukison.com]
	* @since 1.2
	* ===================================
	*/
	$attDinamik =[];
	$hdrLabel1=[];
	//$hdrLabel2=[];
	$getHeaderLabelWrap=[];

	/*
	 * Terminal ID | Mashine
	 * Colomn 1
	*/
	$attDinamik[]=[
		'attribute'=>'TerminalID','label'=>'Source Machine',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		'filter'=>$aryMachine,
		'filterOptions'=>[
			'style'=>'background-color:rgba(240, 195, 59, 0.4); align:center;',
			'vAlign'=>'middle',
		],
		'value'=>function($model){
			$nmMachine=Machine::find()->where(['TerminalID'=>$model['TerminalID']])->one();
			return $nmMachine!=''?$nmMachine['MESIN_NM']:'Unknown';
		},
		'noWrap'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'20px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(240, 195, 59, 0.4)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'20px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				//'background-color'=>'rgba(13, 127, 3, 0.1)',
			]
		],
		//'pageSummaryFunc'=>GridView::F_SUM,
		//'pageSummary'=>true,
		'pageSummaryOptions' => [
			'style'=>[
					'text-align'=>'right',
					'width'=>'20px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'text-decoration'=>'underline',
					'font-weight'=>'bold',
					'border-left-color'=>'transparant',
					'border-left'=>'0px',
			]
		],
		//'footer'=>true,
	];


	$hdrLabel1[] =[
		'content'=>'Employee Data',
		'options'=>[
			'noWrap'=>true,
			'colspan'=>2,
			'class'=>'text-center info',
			'style'=>[
				 'text-align'=>'center',
				 'width'=>'20px',
				 'font-family'=>'tahoma',
				 'font-size'=>'8pt',
				 'background-color'=>'rgba(0, 95, 218, 0.3)',
			 ]
		 ],
	];

	/*
	 * Employe name
	 * Colomn 2
	*/
	$attDinamik[]=[
		'attribute'=>'EMP_NM','label'=>'Employee',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'filter'=>$aryEmploye,
		'filterOptions'=>[
			'style'=>'background-color:rgba(240, 195, 59, 0.4); align:center;',
			'vAlign'=>'middle',
		],
		'noWrap'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(240, 195, 59, 0.4)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				//'background-color'=>'rgba(13, 127, 3, 0.1)',
			]
		],
		//'pageSummaryFunc'=>GridView::F_SUM,
		//'pageSummary'=>true,
		'pageSummaryOptions' => [
			'style'=>[
					'text-align'=>'right',
					'width'=>'10px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'text-decoration'=>'underline',
					'font-weight'=>'bold',
					'border-left-color'=>'transparant',
					'border-left'=>'0px',
			]
		],
		//'footer'=>true,
	];


	foreach($dataProviderField as $key =>$value)
	{
		$i=2;
		$kd = explode('.',$key);
		if($key!='EMP_NM' AND $key!='TerminalID' AND $kd[0]!='OTIN' AND $kd[0]!='OTOUT'){
			if ($kd[0]=='IN'){$lbl='IN';} elseif($kd[0]=='OUT'){$lbl='OUT';}else {$lbl='';};
			
			/* $x=date('N', $kd[1]);	
			if ($x!=6 or $x!=7){
				$headerColor='rgba(97, 211, 96, 0.3)';
			}else{
				$headerColor='rgba(255, 142, 138, 1)';
			}; */
				$attDinamik[]=[
					'attribute'=>$key,
					'label'=>$lbl,
					/* function(){
							return html::encode($lbl);
					}, */
					'hAlign'=>'right',
					'vAlign'=>'middle',
					'value'=>function($model)use($key){
						return $model[$key]!=''?$model[$key]:'x';
					},
					/* 'filter'=>function()use($kd[1]){
						$date = '2011/10/14';
						$day = date('l', strtotime($date));
						echo $day;
					}, */
					//'filter'=>$kd[0]=='IN'? date('l', strtotime($kd[1])):'',
					/*'filterOptions'=>[
					 'colspan'=>$kd[0]=='IN'? 2:'0',
						'style'=>'background-color:rgba(97, 211, 96, 0.3); align:center;',
						'vAlign'=>'middle',
					], */
					'mergeHeader'=>true,
					'noWrap'=>true,
					'headerOptions'=>[
						//'colspan'=>$kd[0]=='IN'? true:false,
						//'colspan'=>$kd[0]=='IN'? $i:'0',
						//'headerHtmlOptions'=>array('colspan'=>'2'),
						'style'=>[
							'text-align'=>'center',
							//'width'=>'12px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'8pt',
							'background-color'=>$headerColor,//'rgba(97, 211, 96, 0.3)',
						]
					],
					'contentOptions'=>[
						'style'=>[
							'text-align'=>'center',
							//'width'=>'12px',
							'font-family'=>'tahoma, arial, sans-serif',
							'font-size'=>'8pt',
							//'background-color'=>'rgba(13, 127, 3, 0.1)',
						]
					],
					//'pageSummaryFunc'=>GridView::F_SUM,
					//'pageSummary'=>true,
					'pageSummaryOptions' => [
						'style'=>[
								'text-align'=>'right',
								//'width'=>'12px',
								'font-family'=>'tahoma',
								'font-size'=>'8pt',
								'text-decoration'=>'underline',
								'font-weight'=>'bold',
								'border-left-color'=>'transparant',
								'border-left'=>'0px',
						]
					],

				];

				if($kd[0]=='IN'){
					$hdrLabel1[] =[
						'content'=>$kd[1],
						'options'=>[
							'noWrap'=>true,
							'colspan'=>2,
							'class'=>'text-center info',
							'style'=>[
								 'text-align'=>'center',
								 //'width'=>'24px',
								 'font-family'=>'tahoma',
								 'font-size'=>'8pt',
								 'background-color'=>'rgba(0, 95, 218, 0.3)',
							 ]
						 ],
					];
				}
		}

		$i=$i+1;
	}

	$hdrLabel1_ALL =[
		'columns'=>array_merge($hdrLabel1),
	];
	$getHeaderLabelWrap =[
		'rows'=>$hdrLabel1_ALL
	];
	
/*
 * DAILY LOG PERSONAL ABSENSI
 * PERIODE 23-22
 * @author ptrnov  [piter@lukison.com]
 * @since 1.2
*/
echo GridView::widget([
	'id'=>'daily-personal-rekap',
	'dataProvider' => $dataProvider,
	//'filterModel' => $searchModel,
	'beforeHeader'=>$getHeaderLabelWrap,
	//'showPageSummary' => true,
	'columns' =>$attDinamik,
	//'floatHeader'=>true,
	'pjax'=>true,
	'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'daily-personal-rekap',
		],
	],
	'summary'=>false,
	'panel' => false,
	'toolbar'=> false,
	'hover'=>true, //cursor select
	'responsive'=>true,
	'responsiveWrap'=>true,
	'bordered'=>true,
	'striped'=>true,
]);
?>