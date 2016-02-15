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


	$attDinamik =[];
	$hdrLabel1=[];
	$hdrLabel1_ALL=[];
	$hdrLabel2_ALL =[];
	
	/*
	 * HeaderLabelWrap-> hdrLabel2
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 * Key-FIND : BeforeHeader
	*/	
	$hdrLabel1[]=[	
		'content'=>'Header',								
		'options'=>[
			'colspan'=>5,
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
	/* $hdrLabel2_ALL =[
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
	$attDinamik[]=[
		'attribute' =>'CUST_GRP',
		//'label'=>'PARENT CUSTOMER',
		//'filter'=>$dropSpl,
		// 'hAlign'=>'right',
		// 'vAlign'=>'middle',
		'value'=>function($model){
			$nmCustomer=Customers::find()->where(['CUST_KD'=>$model['CUST_GRP']])->one();
			return $nmCustomer->CUST_NM;
			/* if ($nmCustomer->CUST_NM=='GIANT (DC CBT JKT GRO-GMS CONV)'){
				$headerNm="GIANT";
			}elseif($nmCustomer->CUST_NM=='STAR (BELTWAY OFFICE PARK)'){
				$headerNm="STARMART";
			}elseif($nmCustomer->CUST_NM=='HARI HARI SWALAYAN (LOKASARI)'){
				$headerNm="HARI HARI";
			}elseif($nmCustomer->CUST_NM=='ROBINSON (MALL TATURA PALU)'){
				$headerNm="ROBINSON";
			}
			return $headerNm; */
			/* 'value'=>function($model){
			if ($model['CUST_NM']='GIANT (DC CBT JKT GRO-GMS CONV)'){
				return $headerNm="GIANT";
			}elseif($model['CUST_NM']='STAR (BELTWAY OFFICE PARK)'){
				$headerNm="STARMART";
			}
			return $headerNm;
			//HARI HARI SWALAYAN (LOKASARI)
			//ROBINSON (MALL TATURA PALU)
			 */
			},
		//},
		'group'=>true,
		//'groupedRow'=>true, //hide column send row -ptr.nov-
		
		//'subGroupOf'=>0,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'60px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		], 
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'60px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
				'font-weight'=>'bold',
				'background-color'=>'rgba(14, 8, 33, 0.2)',
			]
		], 
		 'groupFooter'=>function($model, $key, $index, $widget){ 			
			return [
				'mergeColumns'=>[[0,4]],		
				'content'=>[             // content to show in each summary cell
					1=>$model['CUST_NM'],
					2=>'Summary Total',
					6=>GridView::F_SUM,7=>GridView::F_SUM,8=>GridView::F_SUM,9=>GridView::F_SUM,10=>GridView::F_SUM,
					11=>GridView::F_SUM,12=>GridView::F_SUM,13=>GridView::F_SUM,14=>GridView::F_SUM,15=>GridView::F_SUM,
					16=>GridView::F_SUM,17=>GridView::F_SUM,18=>GridView::F_SUM,19=>GridView::F_SUM,20=>GridView::F_SUM,
					21=>GridView::F_SUM,22=>GridView::F_SUM,23=>GridView::F_SUM,24=>GridView::F_SUM,25=>GridView::F_SUM,
					26=>GridView::F_SUM,27=>GridView::F_SUM,28=>GridView::F_SUM,29=>GridView::F_SUM,30=>GridView::F_SUM,
					31=>GridView::F_SUM,32=>GridView::F_SUM,33=>GridView::F_SUM,34=>GridView::F_SUM,35=>GridView::F_SUM,
					36=>GridView::F_SUM,37=>GridView::F_SUM,38=>GridView::F_SUM,39=>GridView::F_SUM,40=>GridView::F_SUM,
					41=>GridView::F_SUM,42=>GridView::F_SUM,43=>GridView::F_SUM,44=>GridView::F_SUM,45=>GridView::F_SUM,
					46=>GridView::F_SUM,47=>GridView::F_SUM,48=>GridView::F_SUM,49=>GridView::F_SUM,50=>GridView::F_SUM,
					51=>GridView::F_SUM,52=>GridView::F_SUM,53=>GridView::F_SUM,54=>GridView::F_SUM,55=>GridView::F_SUM,
					
				],
				'contentFormats'=>[      // content reformatting for each summary cell
					//6=>['format'=>'number', 'decimals'=>1],
					//4=>['format'=>'number','decimals'=>2],
					5=>['format'=>'number','decimals'=>2],
					6=>['format'=>'number','decimals'=>2],
					7=>['format'=>'number', 'decimals'=>2],8=>['format'=>'number', 'decimals'=>2],
					9=>['format'=>'number', 'decimals'=>2],10=>['format'=>'number', 'decimals'=>2],11=>['format'=>'number', 'decimals'=>2],
					12=>['format'=>'number', 'decimals'=>2],13=>['format'=>'number', 'decimals'=>2],14=>['format'=>'number', 'decimals'=>2],
					15=>['format'=>'number', 'decimals'=>2],16=>['format'=>'number', 'decimals'=>2],17=>['format'=>'number', 'decimals'=>2],
					18=>['format'=>'number', 'decimals'=>2],19=>['format'=>'number', 'decimals'=>2],20=>['format'=>'number', 'decimals'=>2],
					21=>['format'=>'number', 'decimals'=>2],22=>['format'=>'number', 'decimals'=>2],23=>['format'=>'number', 'decimals'=>2],
					24=>['format'=>'number', 'decimals'=>2],25=>['format'=>'number', 'decimals'=>2],26=>['format'=>'number', 'decimals'=>2],
					27=>['format'=>'number', 'decimals'=>2],28=>['format'=>'number', 'decimals'=>2],29=>['format'=>'number', 'decimals'=>2],
					30=>['format'=>'number', 'decimals'=>2],31=>['format'=>'number', 'decimals'=>2],32=>['format'=>'number', 'decimals'=>2],
					33=>['format'=>'number', 'decimals'=>2],34=>['format'=>'number', 'decimals'=>2],35=>['format'=>'number', 'decimals'=>2],
					36=>['format'=>'number', 'decimals'=>2],37=>['format'=>'number', 'decimals'=>2],38=>['format'=>'number', 'decimals'=>2],
					39=>['format'=>'number', 'decimals'=>2],40=>['format'=>'number', 'decimals'=>2],41=>['format'=>'number', 'decimals'=>2],
					42=>['format'=>'number', 'decimals'=>2],43=>['format'=>'number', 'decimals'=>2],44=>['format'=>'number', 'decimals'=>2],
					45=>['format'=>'number', 'decimals'=>2],46=>['format'=>'number', 'decimals'=>2],47=>['format'=>'number', 'decimals'=>2],
					48=>['format'=>'number', 'decimals'=>2],49=>['format'=>'number', 'decimals'=>2],50=>['format'=>'number', 'decimals'=>2],
					51=>['format'=>'number', 'decimals'=>2],52=>['format'=>'number', 'decimals'=>2],53=>['format'=>'number', 'decimals'=>2],
				],
				'contentOptions'=>[      // content html attributes for each summary cell
					//1=>['style'=>'font-variant:small-caps'],
					0=>['style'=>'text-align:right;font-weight:bold;background-color:rgba(14, 8, 33, 0.2'],
					6=>['style'=>'text-align:right'],
				],
				'options'=>[	
					'style'=>[
						'font-weight:bold;background-color:rgba(14, 8, 33, 0.2)'
					]
				],			
			];
		}, 
		/* 'groupHeader'=>function($model, $key, $index, $widget){ 
			return [
				'mergeColumns'=>[[1,5]], 
				'content'=>[             // content to show in each summary cell
					1=>'JUMLAH OUTLET TRANSAKSI',
					6=>GridView::F_COUNT,7=>GridView::F_COUNT,8=>GridView::F_COUNT,9=>GridView::F_COUNT,10=>GridView::F_COUNT,
					11=>GridView::F_COUNT,12=>GridView::F_COUNT,13=>GridView::F_COUNT,14=>GridView::F_COUNT,15=>GridView::F_COUNT,
					16=>GridView::F_COUNT,17=>GridView::F_COUNT,18=>GridView::F_COUNT,19=>GridView::F_COUNT,20=>GridView::F_COUNT,
					21=>GridView::F_COUNT,22=>GridView::F_COUNT,23=>GridView::F_COUNT,24=>GridView::F_COUNT,25=>GridView::F_COUNT,
					26=>GridView::F_COUNT,27=>GridView::F_COUNT,28=>GridView::F_COUNT,29=>GridView::F_COUNT,30=>GridView::F_COUNT,
					31=>GridView::F_COUNT,32=>GridView::F_COUNT,33=>GridView::F_COUNT,34=>GridView::F_COUNT,35=>GridView::F_COUNT,
					
				],
				'contentFormats'=>[      // content reformatting for each summary cell
					
					6=>['format'=>'number'],7=>['format'=>'number'],8=>['format'=>'number'],9=>['format'=>'number'],10=>['format'=>'number'],
					11=>['format'=>'number'],12=>['format'=>'number'],13=>['format'=>'number'],14=>['format'=>'number'],15=>['format'=>'number'],
					16=>['format'=>'number'],17=>['format'=>'number'],18=>['format'=>'number'],19=>['format'=>'number'],20=>['format'=>'number'],
					21=>['format'=>'number'],22=>['format'=>'number'],23=>['format'=>'number'],24=>['format'=>'number'],25=>['format'=>'number'],
					26=>['format'=>'number'],27=>['format'=>'number'],28=>['format'=>'number'],29=>['format'=>'number'],30=>['format'=>'number'],
					31=>['format'=>'number'],32=>['format'=>'number'],33=>['format'=>'number'],34=>['format'=>'number'],35=>['format'=>'number'],
				],
				'contentOptions'=>[      // content html attributes for each summary cell
					1=>['style'=>'font-variant:small-caps'],
					1=>['style'=>'text-align:right'],
				],
				'options'=>[	
					'style'=>[
						'font-weight:bold;background-color:rgba(73, 80, 83, 0.3)'
					]
				],			
			];
		},  */
	];
	
	/* 1 | SerialColumn
	 * Key-FIND : AttStatic
	*/
	/* $attDinamik[]=[
		'class'=>'kartik\grid\SerialColumn',
		'contentOptions'=>['class'=>'kartik-sheet-style'],
		'width'=>'10px',
		'header'=>'No.',
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'8pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'8pt',
			]
		],
	]; */

	/* 2 KODE CUSTOMER ALIAS 
	 * Key-FIND : AttStatic
	 */
	$attDinamik[]=[
		'attribute' => 'TGL',
		'label'=>'Date',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		'noWrap'=>true,
		'group'=>true,
		//'groupedRow'=>true,
		'subGroupOf'=>0,
		'value'=>function($model){
			return substr($model['TGL'], 0, 10);
		},
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
				//'background-color'=>'rgba(14, 8, 33, 0.2)',
			]
		],
		'groupFooter'=>function($model, $key, $index, $widget){ 			
			return [
				'mergeColumns'=>[[1,4]],		
				'content'=>[             // content to show in each summary cell
					//1=>$model['CUST_NM'],
					1=>'Summary Total Stok '.$model['TGL'],
					4=>GridView::F_SUM,
					5=>GridView::F_SUM,
					6=>GridView::F_SUM,7=>GridView::F_SUM,8=>GridView::F_SUM,9=>GridView::F_SUM,10=>GridView::F_SUM,
					11=>GridView::F_SUM,12=>GridView::F_SUM,13=>GridView::F_SUM,14=>GridView::F_SUM,15=>GridView::F_SUM,
					16=>GridView::F_SUM,17=>GridView::F_SUM,18=>GridView::F_SUM,19=>GridView::F_SUM,
					20=>$model['sumTTL_PRCNT_OUT'],	
					21=>GridView::F_SUM,22=>GridView::F_SUM,23=>GridView::F_SUM,24=>GridView::F_SUM,25=>GridView::F_SUM,
					26=>GridView::F_SUM,27=>GridView::F_SUM,28=>GridView::F_SUM,29=>GridView::F_SUM,30=>GridView::F_SUM,
					31=>GridView::F_SUM,32=>GridView::F_SUM,33=>GridView::F_SUM,34=>GridView::F_SUM,35=>GridView::F_SUM,
					36=>GridView::F_SUM,37=>GridView::F_SUM,38=>GridView::F_SUM,39=>GridView::F_SUM,40=>GridView::F_SUM,
					41=>GridView::F_SUM,42=>GridView::F_SUM,43=>GridView::F_SUM,44=>GridView::F_SUM,45=>GridView::F_SUM,
					46=>GridView::F_SUM,47=>GridView::F_SUM,48=>GridView::F_SUM,49=>GridView::F_SUM,50=>GridView::F_SUM,
					51=>GridView::F_SUM,52=>GridView::F_SUM,53=>GridView::F_SUM,54=>GridView::F_SUM,55=>GridView::F_SUM,
					
				],
				'contentFormats'=>[      // content reformatting for each summary cell
					//6=>['format'=>'number', 'decimals'=>1],
					//4=>['format'=>'number', 'decimals'=>2],
					5=>['format'=>'number', 'decimals'=>0],
					6=>['format'=>'number', 'decimals'=>0],
					7=>['format'=>'number', 'decimals'=>0],8=>['format'=>'number', 'decimals'=>0],
					9=>['format'=>'number', 'decimals'=>0],10=>['format'=>'number', 'decimals'=>0],11=>['format'=>'number', 'decimals'=>0],
					12=>['format'=>'number', 'decimals'=>0],13=>['format'=>'number', 'decimals'=>0],14=>['format'=>'number', 'decimals'=>0],
					15=>['format'=>'number', 'decimals'=>0],16=>['format'=>'number', 'decimals'=>1],17=>['format'=>'number', 'decimals'=>0],
					18=>['format'=>'number', 'decimals'=>0],19=>['format'=>'number', 'decimals'=>1],20=>['format'=>'number', 'decimals'=>1],
					21=>['format'=>'number', 'decimals'=>0],22=>['format'=>'number', 'decimals'=>0],23=>['format'=>'number', 'decimals'=>0],
					24=>['format'=>'number', 'decimals'=>0],25=>['format'=>'number', 'decimals'=>0],26=>['format'=>'number', 'decimals'=>0],
					27=>['format'=>'number', 'decimals'=>0],28=>['format'=>'number', 'decimals'=>0],29=>['format'=>'number', 'decimals'=>0],
					30=>['format'=>'number', 'decimals'=>0],31=>['format'=>'number', 'decimals'=>0],32=>['format'=>'number', 'decimals'=>0],
					33=>['format'=>'number', 'decimals'=>0],34=>['format'=>'number', 'decimals'=>0],35=>['format'=>'number', 'decimals'=>0],
					36=>['format'=>'number', 'decimals'=>0],37=>['format'=>'number', 'decimals'=>0],38=>['format'=>'number', 'decimals'=>0],
					39=>['format'=>'number', 'decimals'=>0],40=>['format'=>'number', 'decimals'=>0],41=>['format'=>'number', 'decimals'=>0],
					42=>['format'=>'number', 'decimals'=>0],43=>['format'=>'number', 'decimals'=>0],44=>['format'=>'number', 'decimals'=>0],
					45=>['format'=>'number', 'decimals'=>0],46=>['format'=>'number', 'decimals'=>0],47=>['format'=>'number', 'decimals'=>0],
					48=>['format'=>'number', 'decimals'=>0],49=>['format'=>'number', 'decimals'=>0],50=>['format'=>'number', 'decimals'=>0],
					51=>['format'=>'number', 'decimals'=>0],52=>['format'=>'number', 'decimals'=>0],53=>['format'=>'number', 'decimals'=>0],
				],
				'contentOptions'=>[      // content html attributes for each summary cell
					//1=>['style'=>'font-variant:small-caps'],
					1=>['style'=>'text-align:right;font-weight:bold;background-color:rgba(72, 255, 132, 0.1)'],
					5=>['style'=>'text-align:right;font-weight:bold;background-color:rgba(72, 255, 132, 0.1)'],
					6=>['style'=>'text-align:right;font-weight:bold;background-color:rgba(72, 255, 132, 0.1)'],
					7=>['style'=>'text-align:right;font-weight:bold;background-color:rgba(72, 255, 132, 0.1)'],
					8=>['style'=>'text-align:right;font-weight:bold;background-color:rgba(72, 255, 132, 0.1)'],
					9=>['style'=>'text-align:right;font-weight:bold;background-color:rgba(72, 255, 132, 0.1)'],
				],
				'options'=>[	
					'style'=>[
						'font-weight:bold;background-color:rgba(14, 8, 33, 0.2)'
					]
				],		
			];
		}, 
		//'subGroupOf'=>1,		
	];
	
	/* 3 | KODE CUSTOMER ALIAS
	 * Key-FIND : AttStatic
	*/
	$attDinamik[]=[
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
	$attDinamik[]=[
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
	$attDinamik[]=[
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
	foreach($attributeField as $key =>$value)
	{	
		$colorb= 'rgba(255, 255, 142, 0.2)';
		$kd = explode('.',$key);

		//  STOCK ITEMS  
		if ($kd[0]=='PCS'|| $kd[0]=='KRT' ){		
			$lbl=$kd[0]=='PCS'? 'PCS':'KRT';
			// Attribute Dinamik 
			$attDinamik[]=[		
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
			$attDinamik[]=[		
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
	foreach($attributeField as $key =>$value){	
		// STOCK OUT TOTAL-B 				
		if ($key=='TTL_PCS_OUT'||$key=='TTL_KRT_OUT'|| $key=='TTL_PRCNT_OUT'){
			if ($key=='TTL_PCS_OUT'){$lbl ='PCS';}elseif($key=='TTL_KRT_OUT'){$lbl='KRT';}elseif($key=='TTL_PRCNT_OUT'){$lbl='%';}
			$attDinamik[]=[		
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
	 * ========= CONFIGURATION ===========
	 * Key-FIND : AttDinamik-lastSTOCK
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 * ===================================
	*/		
	$clm=$attDinamik;
	$hdrLabel1_ALL =[
		'columns'=>array_merge($hdrLabel1),
	];
	$getHeaderLabelWrap=[];
	$getHeaderLabelWrap =[
		'rows'=>$hdrLabel2_ALL,$hdrLabel1_ALL
	];

	$gvSales = GridView::widget([
		'id'=>'gv-rpt-sales',
        'dataProvider' => $dataProviderX,
        //'filterModel' => $searchModel,
		'beforeHeader'=>$getHeaderLabelWrap,
		'showPageSummary' => true,
		'columns' =>$clm,
		'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-rpt-sales',
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
	
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
	<?php
		echo $gvSales;
	?>
</div>
