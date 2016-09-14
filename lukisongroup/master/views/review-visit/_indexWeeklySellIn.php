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
use kartik\date\DatePicker;
use lukisongroup\hrd\models\Machine;
$aryMachine = ArrayHelper::map(Machine::find()->all(),'TerminalID','MESIN_NM');

	//print_r($dataProvider->getModels());
	//print_r($searchModelRo);
	$gvTest1='';
	/* $gvTest1= GridView::widget([
		'id'=>'gv-test1',
        'dataProvider' => $dataProvider1,
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-test1',
		   ],
		],
		'summary'=>false,
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
    ]); */
	
	$headColomnEvent=[
		['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '10px','label'=>'DATE','align'=>'center','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>true,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>1, 'ATTR' =>['FIELD'=>'SALES_NM','SIZE' => '10px','label'=>'SALES','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>2, 'ATTR' =>['FIELD'=>'SCDL_GRP_NM','SIZE' => '10px','label'=>'AREA','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>3, 'ATTR' =>['FIELD'=>'CUST_ID','SIZE' => '10px','label'=>'CUST.ID','align'=>'center','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
		['ID' =>4, 'ATTR' =>['FIELD'=>'CUST_NM','SIZE' => '10px','label'=>'CUSTOMER','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
	];
	$gvHeadColomn = ArrayHelper::map($headColomnEvent, 'ID', 'ATTR');
	
	/*
	 * === STOCK =======================
	 * @author ptrnov [ptr.nov@gmail.com]
	 * @since 1.2
	 * ===================================
	 */
	if($aryProviderDetailSellIn->allModels){
		//$cnt=count($aryProviderDetailSellIn->allModels)!=0?(count($aryProviderDetailSellIn->allModels)-1):0;
		foreach($aryProviderHeaderSellIn as $key =>$value){
			$colorb= 'rgba(255, 255, 142, 0.2)';
			if($key=='TGL'){
				$lbl="DATE";
				$align="center";
				$width="80px";
				$pageSummary='';
				$gvfilterType=GridView::FILTER_DATE;	
				$gvfilter=true;
				$filterWidgetOpt=[
					'pluginOptions' => [
						'format' => 'yyyy-mm-dd',					 
						'autoclose' => true,
						'todayHighlight' => true,
						//'format' => 'dd-mm-yyyy',
						'autoWidget' => false,
						//'todayBtn' => true,
					]
				];	
				$filterOptCspn=1;
				$filterColor='rgba(0, 95, 218, 0.3)';
				$headeMerge=false;
				$vAlign='middle';
			}elseif($key=='SALES_NM'){
				$lbl="SALES";
				$align="left";
				$width="100px";
				$pageSummary='';
				$gvfilterType=false;
				$gvfilter=true;				
				$filterWidgetOpt=false;		
				$filterOptCspn=2;
				$filterColor='rgba(0, 95, 218, 0.3)';
				$headeMerge=false;
				$vAlign='middle';
			}elseif($key=='SCDL_GRP_NM'){
				$lbl="AREA";
				$align="left";
				$width="50px";
				$pageSummary='';
				$gvfilterType=false;
				$gvfilter=$aryMachine;
				$filterWidgetOpt=false;		
				$filterOptCspn=0;
				$filterColor='rgba(0, 95, 218, 0.3)';
				$headeMerge=true;
				$vAlign='top';
			}elseif ($key=='CUST_ID'){
				$lbl="CUSTOMER.ID";
				$align="center";
				$pageSummary='';
				$gvfilterType=false;
				$gvfilter=true;
				$filterWidgetOpt=false;		
				$filterOptCspn=1;
				$filterColor='rgba(0, 95, 218, 0.3)';
				$headeMerge=false;
				$vAlign='middle';
			}elseif($key=='CUST_NM'){
				$lbl="CUSTOMER";
				$align="left";
				$width="250px";
				$pageSummary='';
				$gvfilterType=false;
				$gvfilter=true;
				$filterWidgetOpt=false;		
				$filterOptCspn=1;
				$filterColor='rgba(0, 95, 218, 0.3)';
				$headeMerge=false;
				$vAlign='middle';
			}else{
				$headeMerge=true;
				$lbl=$key."/pcs";
				$align="right";
				$width="100px";
				$pageSummary='Sub Total';
				$gvfilterType=false;
				$gvfilter=false;
				$filterWidgetOpt=false;		
				$filterOptCspn=1;
				$filterColor='rgba(0, 95, 218, 0.3)';
				$vAlign='middle';
			};
			
			/* Attribute Dinamik */
			$attDinamikSTCK[]=[
				'attribute'=>$key,
				'label'=>$lbl,
				'hAlign'=>'right',
				'vAlign'=>$vAlign,
				'mergeHeader'=>$headeMerge,
				'filter'=>$gvfilter,
				'filterType'=>$gvfilterType,
				'filterWidgetOptions'=>$filterWidgetOpt,	
				'filterOptions'=>[
					'colspan'=>$filterOptCspn,
					'style'=>['background-color'=>$filterColor],
				],			
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
						'width'=>$width,
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
	
	$gvSellInDetailWeekly = GridView::widget([
		'id'=>'gv-weekly-detail-ro',
        'dataProvider' => $aryProviderDetailSellIn,
        'filterModel' => $searchModelRo,
		'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],	
		//'beforeHeader'=>$getHeaderLabelWrap,
		//'showPageSummary' => true,
		'columns' =>$attDinamikSTCK,
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-weekly-detail-ro',
		   ],
		],
		'summary'=>false,
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true
    ]);
?>


<?=$gvTest1?>
<?=$gvSellInDetailWeekly?>
