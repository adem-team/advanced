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
	 * AttDinamik-sellIN
	 * AttDinamik-sellOUT
	 * AttDinamik-Stock
	 * AttDinamik-lastStock
	 * AttDinamik-lastSellOut
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
	$hdrLabel2_ALL =[
		'columns'=>[
			[
				'content'=>'Header',
				'options'=>[
					'colspan'=>5,
					'rowspan'=>2,
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
	];

	/* 0 | KODE CUSTOMER ALIAS TOTAL SUM
	 * Key-FIND : AttStatic
	*/
	$attDinamik[]=[
		'attribute' =>'CUST_GRP',
		//'label'=>'PARENT CUSTOMER',
		//'filter'=>$dropSpl,
		// 'hAlign'=>'right',
		// 'vAlign'=>'middle',
		// 'value'=>function($model){
		// 	$nmCustomer=Customers::find()->where(['CUST_KD'=>$model['CUST_GRP']])->one();
		// 	return $nmCustomer->CUST_NM;
		// },
		'group'=>true,
		'groupedRow'=>true, //hide column send row -ptr.nov-

		//'subGroupOf'=>1,
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
			]
		],
		'groupFooter'=>function($model, $key, $index, $widget){
			return [
				'mergeColumns'=>[[1,5]],
				'content'=>[             // content to show in each summary cell
					//1=>$model['CUST_NM'],
					1=>'Summary Total',
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
				],
				'contentOptions'=>[      // content html attributes for each summary cell
					//1=>['style'=>'font-variant:small-caps'],
					1=>['style'=>'text-align:right;font-weight:bold'],
					6=>['style'=>'text-align:right'],
				],
				'options'=>[
					'style'=>[
						'font-weight:bold;background-color:rgba(73, 80, 83, 0.3)'
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
	$attDinamik[]=[
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
	];

	/* 2 KODE CUSTOMER ALIAS
	 * Key-FIND : AttStatic
	 */
	$attDinamik[]=[
		'attribute' => 'TGL',
		'label'=>'Date',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		'noWrap'=>true,
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
			]
		],
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
	 * === SELL IN =======================
	 * Key-FIND : AttDinamik-sellIN
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 * ===================================
	 */
	foreach($attributeField as $key =>$value)
	{
		$colorb= 'rgba(255, 255, 142, 0.2)';
		$kd = explode('.',$key);

		/* SELL-IN ITEMS */
		if ($kd[0]=='IN_BRG'|| $kd[0]=='IN_KRT' ){
			$lbl=$kd[0]=='IN_BRG'? 'PCS':'KRT';
			/* Attribute Dinamik */
			$attDinamik[]=[
				'attribute'=>$key,'label'=>$lbl,
				'hAlign'=>'right',
				'vAlign'=>'middle',
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
			/*hdrLabel1 ITEMS PCS[IN_BRG]+KRT[IN_KRT] Marge 2*/
			if ($kd[0]=='IN_BRG'){
				$lbl=$kd[0]=='IN_BRG'? 'PCS':'KRT';
				$kdBrg=str_replace('IN_BRG','BRG',$key);
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
							 'font-size'=>'8pt',
							 'background-color'=>'rgba(0, 95, 218, 0.3)',
						 ]
					 ],
				];
			}
		}

		/* SELL-IN TOTAL-A */
		if ($key=='IN_TTL_PCS'||$key=='IN_TTL_KRT' || $key=='IN_TTL_PRCNT'){
			if ($key=='IN_TTL_PCS'){$lbl ='PCS';}elseif($key=='IN_TTL_KRT'){$lbl='KRT';}elseif($key=='IN_TTL_PRCNT'){$lbl='%';}
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
			/*hdrLabel1 TOTAL-A  TTL_PCS| TTL_KRT | TTL_PERCENT | Marge 3*/
			if($key=='IN_TTL_PCS'){
				$hdrLabel1[] =[
					'content'=>'TOTAL SELL IN',
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
	 * === SELL OUT =======================
	 * Key-FIND : AttDinamik-sellOUT
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 * ===================================
	 */
	foreach($attributeField as $key =>$value)
	{
		$colorb= 'rgba(255, 255, 142, 0.2)';
		$kd = explode('.',$key);

		if ($kd[0]=='OUT_BRG'|| $kd[0]=='OUT_KRT' ){
			$lbl=$kd[0]=='OUT_BRG'? 'PCS':'KRT';
			$attDinamik[]=[
				'attribute'=>$key,'label'=>$lbl,
				'hAlign'=>'right',
				'vAlign'=>'middle',
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
			/*hdrLabel1 ITEMS PCS[OUT_BRG]+KRT[OUT_KRT] Marge 2*/
			if ($kd[0]=='OUT_BRG'){
				$lbl=$kd[0]=='OUT_BRG'? 'PCS':'KRT';
				$kdBrg=str_replace('OUT_BRG','BRG',$key);
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
							 'font-size'=>'8pt',
							 'background-color'=>'rgba(0, 95, 218, 0.3)',
						 ]
					 ],
				];
			}
		}
		/* SELL-OUT TOTAL-A */
		if ($key=='OUT_TTL_PCS'||$key=='OUT_TTL_KRT' || $key=='OUT_TTL_PRCNT'){
			if ($key=='OUT_TTL_PCS'){$lbl ='PCS';}elseif($key=='OUT_TTL_KRT'){$lbl='KRT';}elseif($key=='OUT_TTL_PRCNT'){$lbl='%';}
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
						'background-color'=>'rgba(157, 255, 132, 1)',
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
			/*hdrLabel1 TOTAL-A  TTL_PCS| TTL_KRT | TTL_PERCENT | Marge 3*/
			if($key=='OUT_TTL_PCS'){
				$hdrLabel1[] =[
					'content'=>'UPDATE SELL OUT',
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
	 * === SELL OUT ADD TOTAL ==========
	 * Key-FIND : AttDinamik-selOUT
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 * ===================================
	 */
	foreach($attributeField as $key =>$value){
		/* SELL OUT TOTAL-B */
		if ($key=='LST_SELLOUT_TTL_PCS1'||$key=='LST_SELLOUT_TTL_KRT1' || $key=='LST_SELLOUT_TTL_PRCNT1'){
			if ($key=='LST_SELLOUT_TTL_PCS1'){$lbl ='PCS';}elseif($key=='LST_SELLOUT_TTL_KRT1'){$lbl='KRT';}elseif($key=='LST_SELLOUT_TTL_PRCNT1'){$lbl='%';}
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

			// hdrLabel1 TOTAL-B  TTL_PCS| TTL_KRT | TTL_PERCENT | Marge 3
			if($key=='LST_SELLOUT_TTL_PCS1'){
				$hdrLabel1[] =[
					'content'=>'LAST STOCK',
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
	 * === LAST STOCK ====================
	 * Key-FIND : AttDinamik-lastSTOCK
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 * ===================================
	 */
	foreach($attributeField as $key =>$value){
		$colorb= 'rgba(255, 255, 142, 0.2)';
		$kd = explode('.',$key);

		if ($kd[0]=='STCK_BRG'|| $kd[0]=='STCK_KRT' ){
			$lbl=$kd[0]=='STCK_BRG'? 'PCS':'KRT';
			$attDinamik[]=[
				'attribute'=>$key,'label'=>$lbl,
				'hAlign'=>'right',
				'vAlign'=>'middle',
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
			/*hdrLabel1 ITEMS PCS[STOCK_BRG]+KRT[STOCK_KRT] Marge 2*/
			if ($kd[0]=='STCK_BRG'){
				$lbl=$kd[0]=='STCK_BRG'? 'PCS':'KRT';
				$kdBrg=str_replace('STCK_BRG','BRG',$key);
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
							 'font-size'=>'8pt',
							 'background-color'=>'rgba(0, 95, 218, 0.3)',
						 ]
					 ],
				];
			}
		}
		/* UPDATE STOCK TOTAL-A */
		if ($key=='STCK_TTL_PCS'||$key=='STCK_TTL_KRT' || $key=='STCK_TTL_PRCNT'){
			if ($key=='STCK_TTL_PCS'){$lbl ='PCS';}elseif($key=='STCK_TTL_KRT'){$lbl='KRT';}elseif($key=='STCK_TTL_PRCNT'){	$lbl='%';}
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
						'background-color'=>'rgba(255, 255, 132, 1)',
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
			/*hdrLabel1 TOTAL-A  TTL_PCS| TTL_KRT | TTL_PERCENT | Marge 3*/
			if($key=='STCK_TTL_PCS'){
				$hdrLabel1[] =[
					'content'=>'UPDATE STOCK',
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
	 * === LAST STOCK ADD TOTAL ==========
	 * Key-FIND : AttDinamik-lastSTOCK
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 * ===================================
	 */
	foreach($attributeField as $key =>$value){
		/* LAST STOCK TOTAL-B */
		if ($key=='LSTSTCK_TTL_PCS'||$key=='LSTSTCK_TTL_KRT' || $key=='LSTSTCK_TTL_PRCNT'){
			if ($key=='LSTSTCK_TTL_PCS'){$lbl ='PCS';}elseif($key=='LSTSTCK_TTL_KRT'){$lbl='KRT';}elseif($key=='LSTSTCK_TTL_PRCNT'){$lbl='%';}
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
			// hdrLabel1 TOTAL-B  TTL_PCS| TTL_KRT | TTL_PERCENT | Marge 3
			if($key=='LSTSTCK_TTL_PCS'){
				$hdrLabel1[] =[
					'content'=>'LAST STOCK',
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
	 * === LAST STOCK ADD TOTAL B =========
	 * Key-FIND : AttDinamik-lastSTOCK
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 * ===================================
	 */
	foreach($attributeField as $key =>$value){
		/* LAST STOCK TOTAL-B */
		if ($key=='LST_SELLOUT_TTL_PCS2'||$key=='LST_SELLOUT_TTL_KRT2' || $key=='LST_SELLOUT_TTL_PRCNT2'){
			if ($key=='LST_SELLOUT_TTL_PCS2'){$lbl ='PCS';}elseif($key=='LST_SELLOUT_TTL_KRT2'){$lbl='KRT';}elseif($key=='LST_SELLOUT_TTL_PRCNT2'){$lbl='%';}
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
						'background-color'=>'rgba(157, 255, 132, 1)',
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

			// hdrLabel1 TOTAL-B  TTL_PCS| TTL_KRT | TTL_PERCENT | Marge 3
			if($key=='LST_SELLOUT_TTL_PCS2'){
				$hdrLabel1[] =[
					'content'=>'LAST SELL OUT',
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
