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

	//print_r($aryProviderDetailRequest);
	//print_r($aryProviderHeaderRequest);
	$headColomnEvent=[
		['ID' =>0, 'ATTR' =>['FIELD'=>'CUST_ID','SIZE' => '10px','label'=>'DATE','align'=>'center','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>true,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>1, 'ATTR' =>['FIELD'=>'CUST_NM','SIZE' => '10px','label'=>'USER NAME','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
	];
	$gvHeadColomn = ArrayHelper::map($headColomnEvent, 'ID', 'ATTR');

	/*
	 * === REQUEST =======================
	 * @author ptrnov [ptr.nov@gmail.com]
	 * @since 1.2
	 * ===================================
	 */
	$attDinamikRequest=[];
	if($aryProviderDetailRequest->allModels){
		foreach($aryProviderHeaderRequest as $key =>$value){
			$colorb= 'rgba(255, 255, 142, 0.2)';
			if ($key!='USER_ID' AND $key!='SCDL_GROUP' AND $key!='TGL' AND $key!='KD_BARANG' AND $key!='NM_BARANG' AND $key!='SO_TYPE' AND $key!='SO_QTY'){	
				if ($key=='CUST_ID'){
					$lbl="CUSTOMER.ID";
					$align="center";
					$pageSummary='Sub Total';
				}elseif($key=='CUST_NM'){
					$lbl="CUSTOMER";
					$align="left";
					$pageSummary='Sub Total';
				}else{
					$lbl=$key;
					$align="right";
					$pageSummary='Sub Total';
				}
				
				/* Attribute Dinamik */
				$attDinamikRequest[]=[
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
		};
	};
	
	$gvStockSummary='';
	$gvStockSummary = GridView::widget([
		'id'=>'gv-request',
        'dataProvider' => $aryProviderDetailRequest,
        //'filterModel' => $searchModel,
		//'beforeHeader'=>$getHeaderLabelWrap,
		//'showPageSummary' => true,
		'columns' =>$attDinamikRequest,
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-request',
		   ],
		],
		'summary'=>false,
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true 
    ]);

?>
	<div style="font-family:tahoma, arial, sans-serif;font-size:9pt;text-align:center;color:red"><b>DETAIL - REQUEST ORDER</b></div>
	<?=$gvStockSummary?>