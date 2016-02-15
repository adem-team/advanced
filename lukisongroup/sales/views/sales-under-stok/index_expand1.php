<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use lukisongroup\master\models\Barang;
use lukisongroup\master\models\Customers;

$this->sideCorp = 'PT. Efenbi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_sales';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Sales Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


//$dropSpl = ArrayHelper::map(Suplier::find()->all(), 'KD_SUPPLIER', 'NM_SUPPLIER');

	/* ==== Key FIND-SEARCH Page ========== 
	 * AttStatic
	 * Key-FIND : AttDinamik-itemStock
	 * Key-FIND : AttDinamik-Stock
	 * Key-FIND : AttDinamik-lastStock
	 * Key-FIND : AttDinamik-selOUT
	 * BeforeHeader
	 *===============================
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/


	$attDinamik_ex1 =[];
	$hdrLabel1=[];
	$hdrLabel1_ALL_ex1=[];
	$hdrLabel2_ALL_ex1 =[];
	
	/*
	 * HeaderLabelWrap-> hdrLabel2
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 * Key-FIND : BeforeHeader
	*/	
	$hdrLabel1[]=[	
		'content'=>'Header',								
		'options'=>[
			'colspan'=>4,
			//'rowspan'=>1,															
			'style'=>[
				 'vAlign'=>'middle',
				 'text-align'=>'center',
				 'width'=>'30px',
				 'font-family'=>'tahoma',
				 'font-size'=>'8pt',
				 'background-color'=>'rgba(0, 95, 218, 0.3)',								
			 ]
		 ],
	];
	/* $hdrLabel2_ALL_ex1 =[
		'columns'=>[
			[	
				'content'=>'Header',								
				'options'=>[
					'colspan'=>5,
					'rowspan'=>1,															
					'style'=>[
						 'vAlign'=>'middle',
						 'text-align'=>'center',
						 'width'=>'30px',
						 'font-family'=>'tahoma',
						 'font-size'=>'8pt',
						 'background-color'=>'rgba(0, 95, 218, 0.3)',								
					 ]
				 ],
			], 
			[	//INPUT DATA BY SELL IN -> RETURN RESULT REPORT -> STOCK AWAL
				'content'=>'SELL IN',
				'options'=>[
					'colspan'=>13,							
					'style'=>[
						 'text-align'=>'center',
						 'width'=>'30px',
						 'font-family'=>'tahoma',
						 'font-size'=>'8pt',
						 'background-color'=>'rgba(0, 95, 218, 0.3)',								
					 ]
				 ],
			], 
			[	
				//INPUT DATA BY SELL OUT -> RETURN RESULT REPORT -> SELL_OUT
				'content'=>'BY SELL OUT',
				'options'=>[
					'colspan'=>16,							
					'style'=>[
						 'text-align'=>'center',
						 'width'=>'30px',
						 'font-family'=>'tahoma',
						 'font-size'=>'8pt',
						 'background-color'=>'rgba(0, 95, 218, 0.3)',								
					 ]
				 ],
			], 
			[	
				//INPUT DATA BY STOCK -> RETURN RESULT REPORT -> SELL_OUT
				'content'=>'BY LAST STOCK',
				'options'=>[
					'colspan'=>22,							
					'style'=>[
						 'text-align'=>'center',
						 'width'=>'30px',
						 'font-family'=>'tahoma',
						 'font-size'=>'8pt',
						 'background-color'=>'rgba(0, 95, 218, 0.3)',								
					 ]
				 ],
			], 
		]
	]; */
	
	/* 0 | KODE CUSTOMER ALIAS TOTAL SUM
	 * Key-FIND : AttStatic
	*/
	
	
	/* 1 | SerialColumn
	 * Key-FIND : AttStatic
	*/
	 // $attDinamik_ex1[]=[
		// 'class'=>'kartik\grid\SerialColumn',
		// 'contentOptions'=>['class'=>'kartik-sheet-style'],
		// 'width'=>'10px',
		// 'header'=>'No.',
		// 'headerOptions'=>[
			// 'style'=>[
				// 'text-align'=>'center',
				// 'width'=>'10px',
				// 'font-family'=>'verdana, arial, sans-serif',
				// 'font-size'=>'8pt',
				// 'background-color'=>'rgba(97, 211, 96, 0.3)',
			// ]
		// ],
		// 'contentOptions'=>[
			// 'style'=>[
				// 'text-align'=>'center',
				// 'width'=>'10px',
				// 'font-family'=>'tahoma, arial, sans-serif',
				// 'font-size'=>'8pt',
			// ]
		// ],
	// ];

	
	$attDinamik_ex1[]=[
		'attribute' => 'TGL',
		'label'=>'Alias.Id',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		'noWrap'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'80px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'80px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
			]
		],	
	];
	/* 3 | KODE CUSTOMER ALIAS
	 * Key-FIND : AttStatic
	*/
	$attDinamik_ex1[]=[
		'attribute' => 'CUST_KD_ALIAS',
		'label'=>'Alias.Id',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		'noWrap'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'80px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'80px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
			]
		],	
	];

	/* 4 KODE CUSTOMER MASTER ESM
	 * Key-FIND : AttStatic
	*/
	$attDinamik_ex1[]=[
		//'class'=>'kartik\grid\EditableColumn',
		'attribute' => 'KD_CUSTOMERS',
		'label'=>'Customer.Id',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		'noWrap'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'100px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'100px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
			]
		],	
	];
	
	/* 5 | CUSTOMER NAME MASTER ESM
	 * Key-FIND : AttStatic
	*/
	$attDinamik_ex1[]=[
		'attribute' => 'CUST_NM',
		'label'=>'Customer',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		'noWrap'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'350px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'350px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
			]
		],	
	];

	/*
	 * === STOCK =========================
	 * Key-FIND : AttDinamik-itemStock
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 * ===================================
	 */
	foreach($attributeField1 as $key =>$value)
	{	
		$colorb= 'rgba(255, 255, 142, 0.2)';
		$kd = explode('.',$key);

		//  STOCK ITEMS  
		if ($kd[0]=='PCS'|| $kd[0]=='KRT' ){		
			$lbl=$kd[0]=='PCS'? 'PCS':'KRT';
			// Attribute Dinamik 
			$attDinamik_ex1[]=[		
				'attribute'=>$key,'label'=>$lbl,
				'hAlign'=>'right',
				'vAlign'=>'middle',
				'format'=>['decimal', 1],				
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'30px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'30px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						'background-color'=>$colorb,
					]
				],			
			];
			//hdrLabel1 ITEMS PCS[IN_BRG]+KRT[IN_KRT] Marge 2 
			if ($kd[0]=='PCS'){		
				$lbl=$kd[0]=='PCS'? 'PCS':'KRT';
				$kdBrg=str_replace('PCS','BRG',$key);
				$nmBrg=Barang::find()->where("KD_BARANG='".$kdBrg."'")->one();
				$lbl=$nmBrg['NM_BARANG'];
				$hdrLabel1[] =[	
					'content'=>$lbl,
					'options'=>[
						'colspan'=>2,
						'class'=>'text-center info',								
						'style'=>[
							 'text-align'=>'center',
							 'width'=>'30px',
							 'font-family'=>'tahoma',
							 'font-size'=>' 8pt',
							 'background-color'=>'rgba(0, 95, 218, 0.3)',								
						 ]
					 ],
				];
			} 		
		}
		// STOCK TOTAL-A  		
		//Key-FIND : AttDinamik-Stock
		if ($key=='TTL_PCS'||$key=='TTL_KRT' || $key=='TTL_PRCNT'){
			if ($key=='TTL_PCS'){$lbl ='PCS';}elseif($key=='TTL_KRT'){$lbl='KRT';}elseif($key=='TTL_PRCNT'){$lbl='%';}
			$attDinamik_ex1[]=[		
				'attribute'=>$key,'label'=>$lbl,
				'hAlign'=>'right',
				'vAlign'=>'middle',
				'format'=>['decimal', 2],			
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'30px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'width'=>'30px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						'background-color'=>'rgba(255, 167, 157, 1)',
					]
				],
				'pageSummaryFunc'=>GridView::F_SUM,
				'pageSummary'=>true,
				'pageSummaryOptions' => [
					'style'=>[
							'text-align'=>'right',		
							'width'=>'30px',
							'font-family'=>'tahoma',
							'font-size'=>'8pt',	
							//'text-decoration'=>'underline',
							//'font-weight'=>'bold',
							//'border-left-color'=>'transparant',		
							'border-left'=>'0px',									
					]
				],											
				'footer'=>true,			
			];
			//hdrLabel1 TOTAL-A  TTL_PCS| TTL_KRT | TTL_PERCENT | Marge 3 
			if($key=='TTL_PCS'){
				$hdrLabel1[] =[	
					'content'=>'TOTAL STOK',
					'options'=>[
						'colspan'=>3,
						'class'=>'text-center info',								
						'style'=>[
							 'text-align'=>'center',
							 'width'=>'30px',
							 'font-family'=>'tahoma',
							 'font-size'=>'8pt',
							 'background-color'=>'rgba(0, 95, 218, 0.3)',								
						 ]
					 ],
				];		
			} 
		}	
	}
 
	/*
	 * === SELL OUT ==========
	 * Key-FIND : AttDinamik-selOUT
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 * ===================================
	 */	
	foreach($attributeField1 as $key =>$value){	
		// STOCK OUT TOTAL-B 				
		if ($key=='TTL_PCS_OUT'||$key=='TTL_KRT_OUT'|| $key=='TTL_PRCNT_OUT'){
			if ($key=='TTL_PCS_OUT'){$lbl ='PCS';}elseif($key=='TTL_KRT_OUT'){$lbl='KRT';}elseif($key=='TTL_PRCNT_OUT'){$lbl='%';}
			$attDinamik_ex1[]=[		
				'attribute'=>$key,'label'=>$lbl,
				'hAlign'=>'right',
				'vAlign'=>'middle',
				'format'=>['decimal', 2],			
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'30px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'width'=>'30px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						'background-color'=>'rgba(255, 255, 85, 0.5)',			
					]
				],
				'pageSummaryFunc'=>GridView::F_SUM,
				'pageSummary'=>true,
				'pageSummaryOptions' => [
					'style'=>[
							'text-align'=>'right',		
							'width'=>'100px',
							'font-family'=>'tahoma',
							'font-size'=>'8pt',	
							//'text-decoration'=>'underline',
							//'font-weight'=>'bold',
							//'border-left-color'=>'transparant',		
							'border-left'=>'0px',									
					]
				],											
				'footer'=>true,			
			];	
			
			// hdrLabel1 STOCK TOTAL-B  TTL_PCS| TTL_KRT | TTL_PERCENT | Marge 3
			if($key=='TTL_PCS_OUT'){
				$hdrLabel1[] =[	
					'content'=>'SELL OUT',
					'options'=>[
						'colspan'=>3,
						'class'=>'text-center info',								
						'style'=>[
							 'text-align'=>'center',
							 'width'=>'30px',
							 'font-family'=>'tahoma',
							 'font-size'=>'8pt',
							 'background-color'=>'rgba(0, 95, 218, 0.3)',								
						 ]
					 ],
				];		
			}		
		}
	}	
	
	/*
	 * === SELL OUT REAL non MINUS =======
	 * Key-FIND : AttDinamik-selOUT
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 * ===================================
	 */	
	/* foreach($attributeField1 as $key =>$value){	
		// STOCK OUT TOTAL-B 				
		if ($key=='TTL_PCS_OUT_REAL'||$key=='TTL_KRT_OUT_REAL'|| $key=='TTL_PRCNT_OUT_REAL'){
			if ($key=='TTL_PCS_OUT_REAL'){$lbl ='PCS';}elseif($key=='TTL_KRT_OUT_REAL'){$lbl='KRT';}elseif($key=='TTL_PRCNT_OUT_REAL'){$lbl='%';}
			$attDinamik_ex1[]=[		
				'attribute'=>$key,'label'=>$lbl,
				'hAlign'=>'right',
				'vAlign'=>'middle',
				'format'=>['decimal', 2],			
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'30px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'width'=>'30px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'8pt',
						'background-color'=>'rgba(20, 215, 70, 0.4)',			
					]
				],
				'pageSummaryFunc'=>GridView::F_SUM,
				'pageSummary'=>true,
				'pageSummaryOptions' => [
					'style'=>[
							'text-align'=>'right',		
							'width'=>'100px',
							'font-family'=>'tahoma',
							'font-size'=>'8pt',	
							//'text-decoration'=>'underline',
							//'font-weight'=>'bold',
							//'border-left-color'=>'transparant',		
							'border-left'=>'0px',									
					]
				],											
				'footer'=>true,			
			];	
			
			// hdrLabel1 STOCK TOTAL-B  TTL_PCS| TTL_KRT | TTL_PERCENT | Marge 3
			if($key=='TTL_PCS_OUT_REAL'){
				$hdrLabel1[] =[	
					'content'=>'SELL OUT ESTIMATE',
					'options'=>[
						'colspan'=>3,
						'class'=>'text-center info',								
						'style'=>[
							 'text-align'=>'center',
							 'width'=>'30px',
							 'font-family'=>'tahoma',
							 'font-size'=>'8pt',
							 'background-color'=>'rgba(0, 95, 218, 0.3)',								
						 ]
					 ],
				];		
			}		
		}
	} */
	
	/*
	 * ========= CONFIGURATION ===========
	 * Key-FIND : AttDinamik-lastSTOCK
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 * ===================================
	*/		
	$clm=$attDinamik_ex1;
	$hdrLabel1_ALL_ex1 =[
		'columns'=>array_merge($hdrLabel1),
	];
	$getHeaderLabelWrap_ex1=[];
	$getHeaderLabelWrap_ex1 =[
		'rows'=>$hdrLabel2_ALL_ex1,$hdrLabel1_ALL_ex1
	];

	$gvSalesEx1	 = GridView::widget([
		'id'=>'gv-rpt-expand1',
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
		'beforeHeader'=>$getHeaderLabelWrap_ex1,
		'showPageSummary' => true,
		'columns' =>$clm,
		// 'floatHeader'=>GridView::FILTER_POS_BODY,
		// 'floatOverflowContainer'=>GridView::FILTER_POS_BODY,
		 // 'floatHeaderOptions'=>[
			
			// 'scrollingTop'=>'10'
		  // ],
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-rpt-expand1',
		   ],						  
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		//'striped'=>'4px',
		//'autoXlFormat'=>true,
		//'export' => false,
    ]); 
?>
	
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt; margin-left:50px">
	<?php
		echo $gvSalesEx1;
	?>
</div>
