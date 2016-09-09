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

use lukisongroup\master\models\Barang;

	//print_r($aryProviderDetailReture);

	/*
	 * === RETURE =======================
	 * @author ptrnov [ptr.nov@gmail.com]
	 * @since 1.2
	 * ===================================
	 */
	foreach($aryProviderDetailReture->allModels[0] as $key =>$value){
		$colorb= 'rgba(255, 255, 142, 0.2)';
		if ($key=='CUST_NM'){
			$lbl="Customer Name";
			$align="left";
			$pageSummary='Sub Total';
		}else{
			$kd = explode('_',$key);	
			//echo $kd[1];
			$nmBrg=Barang::find()->where("KD_BARANG='".$kd[1]."'")->one();
			$lblR=$nmBrg['NM_BARANG'];
			$lbl=str_replace('MAXI','',$lblR);	
			$align="center";
			$pageSummary=true;
		}
		
		// Attribute Dinamik 
		$attDinamikReture[]=[
			'attribute'=>$key,
			'label'=>$lbl,
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					//'width'=>'30px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>$align,
					//'width'=>'30px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>$colorb,
				]
			],
			'pageSummaryFunc'=>GridView::F_SUM,
			'pageSummary'=>$pageSummary,
			'pageSummaryOptions' => [
				'style'=>[
						'text-align'=>'center',
						'width'=>'30px',
						'font-family'=>'tahoma',
						'font-size'=>'8pt',
						//'text-decoration'=>'underline',
						//'font-weight'=>'bold',
						//'border-left-color'=>'transparant',
						'border-left'=>'0px',
				]
			],
		];					
	};
	
	$gvReture = GridView::widget([
		'id'=>'gv-reture',
        'dataProvider' => $aryProviderDetailReture,
        //'filterModel' => $searchModel,
		//'beforeHeader'=>$getHeaderLabelWrap,
		'showPageSummary' => true,
		'columns' =>$attDinamikReture,
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-reture',
		   ],
		],
		'summary'=>false,
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		//'striped'=>'4px',
		//'autoXlFormat'=>true,
		//'export' => false,
		/* 'toolbar' =>false,
		'panel' => [
			'heading'=>'<h3 class="panel-title">DETAIL STOCK</h3>',
			'type'=>'info',
			'footer'=>false,			
		], */
    ]);






?>
	<div style="font-family:tahoma, arial, sans-serif;font-size:9pt;text-align:center;color:red"><b>DETAIL - RETURE</b></div>
	<?=$gvReture?>