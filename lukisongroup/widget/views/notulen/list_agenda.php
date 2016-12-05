<?php

use kartik\helpers\Html;
use yii\helpers\Url;
use dosamigos\gallery\Gallery;
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\bootstrap\Modal;
use lukisongroup\widget\models\NotulenModul;

use lukisongroup\hrd\models\Employe;
use yii\helpers\ArrayHelper;

	/**
	 * LIST Agenda  
	 * PERIODE 23-22
	 * @author wawan
	 * @since 1.2
	*/
	$actionClass='btn btn-info btn-xs';
	$actionLabel='Update';
	$attDinamikNotulen =[];				
	/*GRIDVIEW ARRAY FIELD HEAD*/
	$headColomnNotulen=[
		['ID' =>0, 'ATTR' =>['FIELD'=>'DESCRIPTION','SIZE' => '300px','label'=>'DESCRIPTION','align'=>'left','warna'=>'159, 221, 66, 1']],
		['ID' =>1, 'ATTR' =>['FIELD'=>'DATE_LINE','SIZE' => '20px','label'=>'TimeLine','align'=>'left','warna'=>'159, 221, 66, 1']],				
		['ID' =>2, 'ATTR' =>['FIELD'=>'namePic','SIZE' => '20px','label'=>'Pic','align'=>'left','warna'=>'159, 221, 66, 1']],
		
	];
	$gvHeadColomnNotulen = ArrayHelper::map($headColomnNotulen, 'ID', 'ATTR');
	/*GRIDVIEW NUMBER*/
	$attDinamikNotulen[]=[
		/* Attribute Serial No */
			'class'=>'kartik\grid\SerialColumn',
			'width'=>'5px',
			'header'=>'No.',
			'hAlign'=>'center',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'5px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'5px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
				]
			],
			'pageSummaryOptions' => [
				'style'=>[
					'border-right'=>'0px',
				]
			]
	];
	
	/*GRIDVIEW ARRAY ROWS*/
	foreach($gvHeadColomnNotulen as $key =>$value[]){
		$attDinamikNotulen[]=[		
			'attribute'=>$value[$key]['FIELD'],
			'label'=>$value[$key]['label'],
			'filter'=>true,
			'hAlign'=>'right',
			'vAlign'=>'middle',
			//'mergeHeader'=>true,
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
					'width'=>$value[$key]['SIZE'],
					'text-align'=>$value[$key]['align'],
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					//'background-color'=>'rgba(13, 127, 3, 0.1)',
				]
			],
			//'pageSummaryFunc'=>GridView::F_SUM,
			//'pageSummary'=>true,
			// 'pageSummaryOptions' => [
				// 'style'=>[
						// 'text-align'=>'right',		
						//'width'=>'12px',
						// 'font-family'=>'tahoma',
						// 'font-size'=>'8pt',	
						// 'text-decoration'=>'underline',
						// 'font-weight'=>'bold',
						// 'border-left-color'=>'transparant',		
						// 'border-left'=>'0px',									
				// ]
			// ],	
		];	
	};
	
	
	
	/*SET  GRID VIEW LIST EVENT*/
	 $gvNutulen= GridView::widget([
		'dataProvider' => $dataProvider_agenda,
		// 'filterModel' => $searchModelNotulen,
		'filterRowOptions'=>['style'=>'background-color:rgba(255, 221, 66, 1); align:center'],
		'columns' => $attDinamikNotulen,
		'floatOverflowContainer'=>true,
		'floatHeader'=>true,
		'id'=>'gv-agenda-notulen',
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
				'id'=>'gv-agenda-notulen',
			],
		],
		'panel' => [
					'heading'=>"<span class='fa fa-edit'><b> LIST Agenda</b></span>",
					'type'=>'info',
					'showFooter'=>false,
		],
		'toolbar'=> [
			 ['content'=>tombolCreate($id)],
			//'{items}',
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>true,
	]); 

	?>

	
	<?= $gvNutulen ?>
	