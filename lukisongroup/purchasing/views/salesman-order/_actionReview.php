<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;


$this->title = 'Sales Order';
$this->params['breadcrumbs'][] = $this->title;
$this->sideCorp = 'Sales Order';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_customers';

$kode_so = Yii::$app->getRequest()->getQueryParam('id');
$id_so = Yii::$app->getRequest()->getQueryParam('id');
$ary = $aryProviderSoDetail->getModels();

if($ary){
	$cust_nm = $ary[0]['CUST_NM'];
}else{
	$cust_nm = $model_cus->CUST_NM;
}

$city = (new \yii\db\Query())
    			->select(['CITY_NAME'])
   				 ->from('dbc002.c0001g2')
   				 ->where(['CITY_ID'=>$soHeaderData->cust->CITY_ID])
    			 ->one();


	
	/*
	 * Declaration Componen User Permission
	 * Function getPermission
	 * Modul Name[8=SO2]
	*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses(8)){
			return Yii::$app->getUserOpt->Modul_akses(8);
		}else{
			return false;
		}
	}


	/*
	 * SIGNATURE AUTH2 | CHECKED
	 * Status Value Signature1 | PurchaseOrder
	 * Permission Edit [BTN_SIGN1==1] & [Status 0=process 1=CREATED]
	*/
	function SignChecked($soHeader){
		$title = Yii::t('app', 'Sign Hire');
		$options = [ 'id'=>'po-auth2',
					  'data-toggle'=>"modal",
					  'data-target'=>"#so-auth1-sign",
					  'class'=>'btn btn-info btn-xs',
					  'style'=>['width'=>'100px'],
					  'title'=>'Detail'
		];
		$icon = '<span class="glyphicon glyphicon-retweet"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/purchasing/salesman-order/sign-auth2','kdso'=>$soHeader->KD_SO]);
		$content = Html::a($label,$url, $options);
		return $content;
	}

	/**
	 * SIGNATURE AUTH3 | APPROVED
	 * Status Value Signature1 | PurchaseOrder
	 * Permission Edit [BTN_SIGN1==1] & [Status 0=process 1=CREATED]
   	 * if poheader STATUS equal 4 then title reject and title Sign Hire
	*/
	function SignApproved($soHeader){
		$title = Yii::t('app', 'Sign Hire');
		$options = [ 'id'=>'po-auth2',
					  'data-toggle'=>"modal",
					  'data-target'=>"#so-auth2-sign",
					  'class'=>'btn btn-info btn-xs',
					  'style'=>['width'=>'100px'],
					  'title'=>'Detail'
		];
		$icon = '<span class="glyphicon glyphicon-retweet"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/purchasing/salesman-order/sign-auth3','kdso'=>$soHeader->KD_SO]);
		$content = Html::a($label,$url, $options);
		return $content;
	}


  	

	function tombolEditCustom($soHeader){
			$title = Yii::t('app','');
			$options = [ 'id'=>'so-edit-tgl-id',
						  'data-toggle'=>"modal",
						  'data-target'=>"#so-edit-review",
						  'class'=>'btn btn-info btn-xs',
						  'title'=>'SO'
			];
			$icon = '<span class="fa fa-edit fa-lg"></span>';
			$label = $icon . ' ' . $title;
			$url = Url::toRoute(['/purchasing/salesman-order/so-edit-review','kdso'=>$soHeader->KD_SO]);
			$content = Html::a($label,$url, $options);
			return $content;

	}

	/*
	 * LINK SO Note
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.2
	*/
	function PoNote($soHeader){
			$title = Yii::t('app','');
			$options = [ 'id'=>'so-note-id',
						  'data-toggle'=>"modal",
						  'data-target'=>"#so-note-review",
						  'class'=>'btn btn-info btn-xs',
						  'title'=>'SO Note'
			];
			$icon = '<span class="fa fa-plus fa-lg"></span>';
			$label = $icon . ' ' . $title;
			$url = Url::toRoute(['/purchasing/salesman-order/so-note-review','kdso'=>$soHeader->KD_SO]);
			$content = Html::a($label,$url, $options);
			return $content;
	}


	/*
	 * LINK SO shipping
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.2
	*/
	function tombolSoshiping($cust_kd,$kode_so,$user_id,$tgl){
			$title = Yii::t('app','');
			$options = [ 'id'=>'so-shiping-id',
						  'data-toggle'=>"modal",
						  'data-target'=>"#so-shiping-review",
						  'class'=>'btn btn-info btn-xs',
						  'title'=>'SO Note'
			];
			$icon = '<span class="fa fa-edit fa-lg"></span>';
			$label = $icon . ' ' . $title;
			$url = Url::toRoute(['/purchasing/salesman-order/so-shiping-review','cust_kd'=>$cust_kd,'user_id'=>$user_id,'kode_so'=>$kode_so,'tgl'=>$tgl]);
			$content = Html::a($label,$url, $options);
			return $content;
	}


	/*
	 * LINK PO Note TOP
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.2
	*/
	function PoNoteTOP($soHeader){
			$title = Yii::t('app','');
			$options = [ 'id'=>'so-notetop-id',
						  'data-toggle'=>"modal",
						  'data-target'=>"#so-notetop-review",
						  'class'=>'btn btn-info btn-xs',
						  'title'=>'SO Note'
			];
			$icon = '<span class="fa fa-plus fa-lg"></span>';
			$label = $icon . ' ' . $title;
			$url = Url::toRoute(['/purchasing/salesman-order/so-note-top-review','kdso'=>$soHeader->KD_SO]);
			$content = Html::a($label,$url, $options);
			return $content;
	}


/*
 * Tombol Create
 * 
*/
	//ADD ITEMS
	function tombolCreate($id_so){
		$title1 = Yii::t('app', 'ADD NEW ITEM');
		$options1 = [ 'id'=>'new-add-create',
						'data-toggle'=>"modal",
						'data-target'=>"#new-add",
						'class' => 'btn btn-danger btn-sm',
		];
		$icon1 = '<span class="fa fa-plus fa-lg"></span>';
		//$url = Url::toRoute(['/purchasing/salesman-order/create-new-add','cust_kd'=>$cust_kd,'user_id'=>$user_id,'id'=>$kode_so,'cust_nm'=>$cust_nm,'tgl'=>$tgl]);
		$url = Url::toRoute(['/purchasing/salesman-order/create-new-add','id'=>$id_so]);
		$label1 = $icon1 . ' ' . $title1;
		$content = Html::a($label1,$url,$options1);
		return $content;
	}

	/*
	 * LINK PRINT PDF
	 * @author ptrnov  <piter@lukison.com>
     * @since 1.2
	*/
	function PrintPdf($kode_SO){
			$title = Yii::t('app','Print');
			$options = [ 'id'=>'pdf-print-id',
						  'class'=>'btn btn-default btn-xs',
						  'title'=>'Print PDF'
			];
			$icon = '<span class="fa fa-print fa-fw"></span>';
			$label = $icon . ' ' . $title;
			$url = Url::toRoute(['/purchasing/salesman-order/cetakpdf','id'=>$kode_SO]);
			$content = Html::a($label,$url, $options);
			return $content;
	}



	/*
	 * Tombol Approval Item
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	function tombolApproval($url, $model){
				$title = Yii::t('app', 'Approved');
				$options = [ 'id'=>'approved',
							 'data-pjax' => true,
							 'data-toggle-approved'=>$model->ID,
				];
				$icon = '<span class="glyphicon glyphicon-ok"></span>';
				$label = $icon . ' ' . $title;
				return '<li>' . Html::a($label, '' , $options) . '</li>' . PHP_EOL;
	}


	/*
	 * Tombol Reject Item
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	function tombolReject($url, $model) {
				$title = Yii::t('app', 'Reject');
				$options = [ 'id'=>'reject',
							 'data-pjax'=>true,
							 'data-toggle-reject' => $model->ID
				];
				$icon = '<i class="fa fa-eraser" aria-hidden="true"></i>';
				$label = $icon . ' ' . $title;
				$options['tabindex'] = '-1';
				return '<li>' . Html::a($label, '' , $options) . '</li>' . PHP_EOL;

	}


	/*
	 * Tombol Delete Item
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	function tombolDelete($url, $model) {
				$title = Yii::t('app', 'Delete');
				$options = [ 'id'=>'delete',
							 'data-pjax'=>true,
							 'data-toggle-delete' => $model->ID
				];
				$icon = '<i class="fa fa-trash" aria-hidden="true"></i>';
				$label = $icon . ' ' . $title;
				$options['tabindex'] = '-1';
				return '<li>' . Html::a($label, '' , $options) . '</li>' . PHP_EOL;

	}



	/* author : wawan
	 * STATUS Items
	 * 1. NEW 	= 0 	| Create First items | jika di cancel maka status menjai 0 lagi atau new
	 * 2. APPROVED	= 1 	| Item Approved
	 * 6. DELETE	= 3 	| Data Hidden | Data Di hapus oleh pembuat petama, jika belum di Approved
	 * 7. REJECT	= 4		| Data tidak di setujui oleh manager atau Atasan  lain
	 * 9. UNKNOWN	<>		| Data Tidak valid atau tidak sah
	*/
	function statusItems($model){
		if($model->STATUS==0){
			/*New*/
			return Html::a('<i class="fa fa-square-o fa-md"></i>', '#',['class'=>'btn btn-info btn-xs', 'style'=>['width'=>'50px'],'title'=>'New']);
		}elseif($model->STATUS==1){
			/*Approved*/
			return Html::a('<i class="fa fa-check-square-o fa-md"></i>', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'50px'], 'title'=>'Approved']);
		}elseif ($model->STATUS==3){
				/*DELETE*/
			return Html::a('<i class="glyphicon glyphicon-remove"></i>', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'50px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==4){
			/*REJECT*/
			return Html::a('<i class="fa fa-remove fa-md"></i> ', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'50px'], 'title'=>'Reject']);
		}else{
			return Html::a('<i class="glyphicon glyphicon-question-sign"></i>', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'50px'], 'title'=>'Detail']);
		};
	}

 
	$soDetailColumn= [

	
	/*No Urut*/
	[
		'class'=>'kartik\grid\SerialColumn',
		'contentOptions'=>['class'=>'kartik-sheet-style'],
		'width'=>'10px',
		'header'=>'No.',
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'7pt',
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
	],
	/*CREATE_AT Tanggal Pembuatan*/
	[
		'class'=>'kartik\grid\EditableColumn',
		'attribute'=>'TGL',
		'label'=>'DATE',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'filterType'=>GridView::FILTER_DATE,
		'filter'=>true,
		'filterWidgetOptions'=>[
			'pluginOptions' => [
			   'autoclose'=>true,
				'format' => 'yyyy-mm-dd'
				    ],
				],
		'editableOptions' => [
				'header' => 'Update TGL',
				'inputType' => \kartik\editable\Editable::INPUT_DATE,
				'size' => 'sm',
				'options' => [
						'pluginOptions' => ['todayHighlight' => true,
                           'autoclose'=>true,
                             'format' => 'yyyy-m-dd']
								]
							],
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'90px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'7pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'90px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt'
			]
		],
		
	],	
	/*CREATE_AT Tanggal Pembuatan*/
	[
		'attribute'=>'NM_BARANG',
		'label'=>'SKU',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'250px',
				'font-family'=>'verdana, arial, sans-serif',
				'font-size'=>'7pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'left',
				'width'=>'250px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt'
			]
		]
	],						
	/*NM_UNIT*/
	[
		// 'class'=>'kartik\grid\EditableColumn',
		'attribute'=>'NM_UNIT',
		'label'=>'UNIT',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'group'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'80px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'80px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
			]
		],
	],
	/*QTY_PCS*/
	[
		'attribute'=>'SO_QTY',
		'label'=>'QTY/Pcs',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'group'=>true,
		'format'=>['decimal',2],
		'pageSummaryFunc'=>GridView::F_SUM,
		'pageSummary'=>true,
		'value'=>function($model){
			return round($model['SO_QTY'],0,PHP_ROUND_HALF_UP);
		},
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
			]
		],
		'pageSummaryOptions' => [
			'style'=>[
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'text-align'=>'right',
					'border-left'=>'0px',
			]
		],
	],
	/*UNIT_BRG*/
	[
		'attribute'=>'SO_QTY',
		'label'=>'QTY/Karton',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'group'=>true,
		'value'=>function($model){
			return round($model['UNIT_BRG'],0,PHP_ROUND_HALF_UP);
		},
		'format'=>['decimal',2],
		'pageSummaryFunc'=>GridView::F_SUM,
		'pageSummary'=>true,
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'100px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'100px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
			]
		],
		'pageSummaryOptions' => [
			'style'=>[
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'text-align'=>'right',
					'border-left'=>'0px',
			]
		],
	],
	/*HARGA_SALES_PCS*/
	[

		'attribute'=>'HARGA_SALES',
		'label'=>'PRICE/Pcs',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'group'=>true,
		'format'=>['decimal',2],
		'value'=>function($model){
			return round($model['HARGA_SALES'],0,PHP_ROUND_HALF_UP);
		},
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
			]
		],
	],
	/*SUB TTL SO*/
	[
		'attribute'=>'SUB_TOTAL',
		'label'=>'SUB.TOTAL',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'group'=>true,
		'format'=>['decimal',2],
		'pageSummaryFunc'=>GridView::F_SUM,
		'pageSummary'=>true,
		'value'=>function($model){
			return round($model['SUB_TOTAL'],0,PHP_ROUND_HALF_UP);
		},
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
				'background-color'=>'rgba(97, 211, 96, 0.3)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
			]
		],
		'pageSummaryOptions' => [
			'style'=>[
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'text-align'=>'right',
					'border-left'=>'0px',
			]
		],
	],
	/*SUBMIT_QTY*/
	#editable
	[
		'class'=>'kartik\grid\EditableColumn',
		'attribute'=>'SUBMIT_QTY',
		'refreshGrid'=>true,
		'label'=>'PREMIT QTY/Pcs',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		'editableOptions' => [
			'header' => 'PREMIT QTY/Pcs',
			'inputType' => \kartik\editable\Editable::INPUT_MONEY,
			'size' => 'xs',
			],
		'group'=>true,
		'format'=>['decimal',2],
		'pageSummaryFunc'=>GridView::F_SUM,
		'pageSummary'=>true,
		'value'=>function($model){
			return round($model['ID'],0,PHP_ROUND_HALF_UP);
		},
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
				'background-color'=>'rgba(74, 206, 231, 1)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
			]
		],
		'pageSummaryOptions' => [
			'style'=>[
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'text-align'=>'right',
					'border-left'=>'0px',
			]
		],
	],
	/*SUBMIT_QTY*/
	#editable
	[
		'class'=>'kartik\grid\EditableColumn',
		'attribute'=>'SUBMIT_PRICE',
		'refreshGrid'=>true,
		'label'=>'PREMIT PRICE/Pcs',
		'editableOptions' => [
			'header' => 'PREMIT PRICE/Pcs',
			'inputType' => \kartik\editable\Editable::INPUT_MONEY,
			'size' => 'xs',
			],
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'group'=>true,
		'format'=>['decimal',2],
		'value'=>function($model){
			return round($model['SUBMIT_PRICE'],0,PHP_ROUND_HALF_UP);
		},
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
				'background-color'=>'rgba(74, 206, 231, 1)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
			]
		]
	],
	/*SUB TTL SUBMIT SO*/
	[
		'attribute'=>'SUBMIT_SUB_TOTAL',
		'label'=>'PREMIT SUB.TOTAL',
		'hAlign'=>'right',
		'vAlign'=>'middle',
		//'group'=>true,
		'format'=>['decimal',2],
		'pageSummaryFunc'=>GridView::F_SUM,
		'pageSummary'=>true,
		'value'=>function($model){
			return round($model['SUBMIT_SUB_TOTAL'],0,PHP_ROUND_HALF_UP);
		},
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
				'background-color'=>'rgba(74, 206, 231, 1)',
			]
		],
		'contentOptions'=>[
			'style'=>[
				'text-align'=>'right',
				'width'=>'120px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'7pt',
			]
		],
		'pageSummaryOptions' => [
			'style'=>[
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'text-align'=>'right',
					'border-left'=>'0px',
			]
		],
	],

		[	//COL-1
			/* Attribute Status Detail RO */
			'attribute'=>'STATUS',
			// 'options'=>['id'=>'test-ro'],
			'label'=>'Status',
			'hAlign'=>'center',
			'vAlign'=>'middle',
			'mergeHeader'=>true,
			'contentOptions'=>['style'=>'width: 100px'],
			'format' => 'html',
			'value'=>function ($model, $key, $index, $widget) {
						return statusItems($model);
			},
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(247, 245, 64, 0.6)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'50px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'8pt',
					'background-color'=>'rgba(247, 245, 64, 0.6)',
				]
			],
		],

		/*Action*/
		[
			'class'=>'kartik\grid\ActionColumn',
			'dropdown' => true,
			'template' => '{approve}{reject}{delete}',
			'dropdownOptions'=>['class'=>'pull-right dropup'],
			//'headerOptions'=>['class'=>'kartik-sheet-style'],
			'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
			'buttons' => [
				/* View RO | Permissian All */
				'approve' => function ($url, $model) {
								return tombolApproval($url, $model);
						  },

				/* View RO | Permissian Status 0; 0=process | User created = user login  */
				'reject' => function ($url, $model) {
								return tombolReject($url, $model);
							},

				/* Delete RO | Permissian Status 0; 0=process | User created = user login */
				'delete' => function ($url, $model) {
								return tombolDelete($url, $model);
							},

			],
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'140px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(97, 211, 96, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'140px',
					'height'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
];






$_gvSoDetail= GridView::widget([
	'id'=>'gv-so-detail-md-inbox',
	'dataProvider'=> $aryProviderSoDetail,
	// 'filterModel' => $searchModelDetail,
	'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
	'showPageSummary' => true,
	/*
		'beforeHeader'=>[
			[
				'columns'=>[
					['content'=>'List Permintaan Barang & Jasa', 'options'=>['colspan'=>4, 'class'=>'text-center success']],
					['content'=>'Action Status ', 'options'=>['colspan'=>6, 'class'=>'text-center warning']],
				],
				'options'=>['class'=>'skip-export'] // remove this row from export
			]
		],
	*/
	'columns' => $soDetailColumn,
	'pjax'=>true,
	'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-so-detail-md-inbox',
		   ],
	],
	'hover'=>true, //cursor select
	'responsive'=>true,
	'responsiveWrap'=>true,
	'bordered'=>true,
	'striped'=>'4px',
	'autoXlFormat'=>true,
	'export' => false,
	'toolbar'=> [
		 //['content'=>tombolCreate($cust_kd,$kode_so,$user_id,$cust_nmx,$tgl,$soHeaderData)],
		 ['content'=>tombolCreate($id_so)],
		
	 ],
	'panel'=>[
		'type'=>GridView::TYPE_SUCCESS,
		'heading'=>false,//tombolCreate($cust_kd,$kode_so,$user_id,$ary[0]['CUST_NM'],$tgl),//$this->render('indexTimelineStatus'),//false //'<div> NO.SO :'.date("d-M-Y")
		'before'=>'SO NO : '. $kode_SO,
		'after'=>false,
		'footer'=>'<div>'.$soHeaderData['ISI_MESSAGES'].'</div>'		
	]
]);

 $profile=Yii::$app->getUserOpt->Profile_user();

?>


<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
	<div class="col-md-12">
		<div class="col-md-3" style="float:left">
			<div  class="row" >
				<dl>
					<dt style="width:300px; float:left;font-family: verdana, arial, sans-serif ;font-size: 11pt;">
						PT EFENBI SUKSES MAKMUR
					</dt>
					<dt style="width:100px; float:left;"></dt>
					<dt style="width:200px; float:left;">
						Ruko Demansion Blok C12
					</dt>
					<dt style="width:200px; float:left;">
						Jalan jalur Sutera Timur
					</dt>
					<dt style="width:200px; float:left;">
						Alam sutera - Tangerang
					</dt>
					<dt style="width:200px; float:left;">					
						Telp : 021-30448598-99 /fax 021-30448597
					</dt>
				</dl>
			</div>
		</div>
		<div class="col-md-5" style="padding-top:15px;">
		</div>
		<div class="col-md-3" style="float:left;padding-bottom:-100px">
			<div>
					 <?= tombolEditCustom($soHeaderData); ?>
				</div>
			<dl>
				<dt style="width:100px; float:left;">Tanggal </dt>
				<dd>: <?php echo date('d-m-Y'); ?></dd>
				<dt style="width:100px; float:left;">Kode Cust</dt>
				<dd>: <?php echo $cust_kd  ?></dd>
				<dt style="width:100px; float:left;">Customer </dt>
				<dd>: <?php echo $cust_nmx ?></dd>
				<dt style="width:100px; float:left;">Alamat  </dt>
				<dd>: <?php echo $soHeaderData->cust->ALAMAT; ?></dd>
				<dt style="width:100px; float:left;">Telp   </dt>
				<dd>: <?php echo $soHeaderData->cust->TLP1; ?></dd>
				<dt style="width:100px; float:left;">Tgl Kirim  </dt>
				<dd>: <?php echo $soHeaderData->TGL_KIRIM; ?></dd>
			</dl>

		</div>
	</div>
	<!-- HEADER !-->
	<div class="col-md-12 text-center"  style="float:left;font-family: verdana, arial, sans-serif ;font-size: 14pt;">
		<b>SALES ORDER</b>	
	</div>
	<!-- Title Descript !-->
	<div class="col-md-12">
		
	</div>
	<!-- Table Grid List SO Detail !-->
	<div class="col-md-12">
		<?=$_gvSoDetail?>
	</div>

	<!-- Title BOTTEM Descript !-->
	<div  class="row">
		<div class="col-md-12" style="font-family: tahoma ;font-size: 9pt;float:left;">

			<div class="col-md-4" style="float:left;">
			<div>
					 <?= tombolSoshiping($cust_kd,$kode_so,$user_id,$tgl); ?>
				</div>
				<dl>
					<?php
						$shipNm= $model_cus->ALAMAT_KIRIM !='' ? $model_cus->ALAMAT_KIRIM: 'Shipping Not Set';
						$shipAddress= $model_cus->ALAMAT!='' ? $model_cus->ALAMAT :'Address Not Set';
						$shipCity= $city['CITY_NAME']!='' ? $city['CITY_NAME'] : 'City Not Set';
						$shipPhone= $model_cus->TLP1!='' ? $model_cus->TLP1 : 'Phone Not Set';
						$shipFax= $model_cus->FAX!='' ? $model_cus->FAX : 'Fax Not Set';
						$shipPic= $model_cus->PIC!='' ? $model_cus->PIC : 'PIC not Set';
					?>
					<dt><h6><u><b>Shipping Address :</b></u></h6></dt>
					<dt><?=$shipNm; ?></dt>
					<dt><?=$shipCity; ?></dt>
					<dt><?=$shipAddress;?></dt>
					
					<dt style="width:80px; float:left;">Tlp</dt>
					<dd>:	<?=$shipPhone;?></dd>
					<dt style="width:80px; float:left;">FAX</dt>
					<dd>:	<?=$shipFax; ?></dd>
					<dt style="width:80px; float:left;">CP</dt>
					<dd>:	<?=$shipPic; ?></dd>
				</dl>
			</div>
			<div class="col-md-3"></div>
			<div class="col-md-4" style="float:left;">
			</div>
		</div>
	</div>

	<!-- SO Term Of Payment !-->
	<div  class="row">
		<div  class="col-md-12" style="font-family: tahoma ;font-size: 9pt;">
			<dt><b>Term Of Payment :</b></dt>
			<hr style="height:1px;margin-top: 1px; margin-bottom: 1px;font-family: tahoma ;font-size:8pt;">
			<div>
				<div style="float:right;text-align:right;">
					 <?= PoNoteTOP($soHeaderData); ?>
				</div>
				<div style="margin-left:5px">
					<dt style="width:80px; float:left;"><?php echo $soHeaderData->TOP_TYPE; ?></dt>
					<dd><?php echo $soHeaderData->TOP_DURATION; ?></dd>
					<br/>
				</div>
			</div>
		</div>
	</div>

	<!-- PO Note !-->
	<div  class="row">
		<div  class="col-md-12" style="font-family: tahoma ;font-size: 9pt;">
			<dt><b>General Notes :</b></dt>
			<hr style="height:1px;margin-top: 1px; margin-bottom: 1px;font-family: tahoma ;font-size:8pt;">
			<div>
				<div style="float:right;text-align:right;">
					<?php echo PoNote($soHeaderData); ?>
				</div>
				<div style="margin-left:5px">
					<dd><?php echo $soHeaderData->NOTE; ?></dd>
				</div>
			</div>
			<hr style="height:1px;margin-top: 1px;">
		</div>
	</div>
	<!-- Signature !-->
		<div  class="col-md-12">
			<div  class="row" >
				<div class="col-md-6">
					<table id="tblRo" class="table table-bordered" style="font-family: tahoma ;font-size: 8pt;">
						<!-- Tanggal!-->
						 <tr>
							<!-- Tanggal Pembuat RO!-->
							<th  class="col-md-1" style="text-align: center; height:20px">
								<div style="text-align:center;">
									<?php
										$tgl1=$soHeaderData->sign1Tgl!='' ? Yii::$app->ambilKonvesi->convert($soHeaderData->sign1Tgl,'date') :'';
										$signTgl1='<b>Tanggerang</b>, '.$tgl1;
									?>
									<?=$signTgl1?>
								</div>

							</th>
							<!-- Tanggal Pembuat RO!-->
							<th class="col-md-1" style="text-align: center; height:20px">
								<div style="text-align:center;">
									<?php
										$tgl2=$soHeaderData->sign2Tgl!='' ? Yii::$app->ambilKonvesi->convert($soHeaderData->sign2Tgl,'date') :'';
										$signTgl2='<b>Tanggerang</b>, '.$tgl2;
									?>
									<?=$signTgl2?>
								</div>

							</th>
							<!-- Tanggal PO Approved!-->
							<th class="col-md-1" style="text-align: center; height:20px">
								<div style="text-align:center;">
									<?php
										$tgl3=$soHeaderData->sign3Tgl!='' ? Yii::$app->ambilKonvesi->convert($soHeaderData->sign3Tgl,'date') :'';
										$signTgl3='<b>Tanggerang</b>, '.$tgl3;
									?>
									<?=$signTgl3?>
								</div>
							</th>

						</tr>
						<!-- Department|Jbatan !-->
						 <tr>
							<th  class="col-md-1" style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
								<div>
									<b><?php  echo 'Created'; ?></b>
								</div>
							</th>
							<th class="col-md-1"  style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
								<div>
									<b><?php  echo 'Checked'; ?></b>
								</div>
							</th>
							<th class="col-md-1" style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
								<div>
									<b><?php  echo 'Approved'; ?></b>
								</div>
							</th>
						</tr>
						<!-- Signature !-->
						 <tr>
							<th class="col-md-1" style="text-align: center; vertical-align:middle; height:40px">
								<?php

								if($soHeaderData->USER_SIGN1 !='')
								{

									$sign1 = '<img style="width:80; height:40px" src='.$soHeaderData->sign1.'></img>';
								}
								?>
								<?=$sign1?>
							</th>
							<th class="col-md-1" style="text-align: center; vertical-align:middle">
								<?php
								if(getPermission()){
									if(getPermission()->BTN_SIGN2){
										$sign2 = $soHeaderData->USER_SIGN2 ? '<img style="width:80; height:40px" src='.$soHeaderData->sign2.'></img>' : SignChecked($soHeaderData);
								   	 // $sign2 = '<img style="width:80; height:40px" src='.$soHeaderData->sign2.'></img>';
								   }else{
								   	 $sign2 = $soHeaderData->USER_SIGN2 ? '<img style="width:80; height:40px" src='.$soHeaderData->sign2.'></img>':'';
								   }

								}
								   
									// $sign2 = $soHeaderData->sign2!=?'<img style="width:80; height:40px" src='.$profile->emp->SIGSVGBASE64.'></img>' :
								?>
								<?=$sign2?>
							</th>
							<th  class="col-md-1" style="text-align: center; vertical-align:middle">
								<?php

								if(getPermission()){
									if(getPermission()->BTN_SIGN3){
										$sign3 = $soHeaderData->USER_SIGN3 ? '<img style="width:80; height:40px" src='.$soHeaderData->sign3.'></img>' : SignApproved($soHeaderData);
								   	 // $sign2 = '<img style="width:80; height:40px" src='.$soHeaderData->sign2.'></img>';
								   }else{
								   	 $sign3 = $soHeaderData->USER_SIGN3 ? '<img style="width:80; height:40px" src='.$soHeaderData->sign3.'></img>':'';
								   }

								}
								// if($soHeaderData->USER_SIGN2 !='')
								// {
								// 	if($soHeaderData->USER_SIGN3 !=''){
								//    	 $sign3 = '<img style="width:80; height:40px" src='.$soHeaderData->sign3.'></img>';
								//    }else{
								//    	 $sign3 = SignApproved($soHeaderData);
								//    }
								// }


								
									// $sign3 = $soHeaderData->sign3!=''?'<img style="width:80; height:40px" src='.$soHeaderData->sign3.'></img>' :SignApproved($soHeaderData);
								?>
								<?=$sign3?>
							</th>
						</tr>
						<!--Nama !-->
						 <tr>
							<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
								<div>
									<?php
										$sign1NM = $soHeaderData->sign1Nm!=''?$soHeaderData->sign1Nm:'';
									?>
									<?=$sign1NM?>
								</div>
							</th>
							<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
								<div>
									<?php
										$sign2NM = $soHeaderData->sign2Nm!=''?$soHeaderData->sign2Nm:'';
									?>
									<?=$sign2NM?>
								</div>
							</th>
							<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
								<div>
									<?php
										$sign3NM = $soHeaderData->sign3Nm!=''?$soHeaderData->sign3Nm:'';
									?>
									<?=$sign3NM?>
								</div>
							</th>
						</tr>
						<!-- Department|Jbatan !-->
						 <tr>
							<th style="text-align: center; vertical-align:middle;height:20">
								<div>
									<b><?php  echo 'SALES MD'; ?></b>
								</div>
							</th>
							<th style="text-align: center; vertical-align:middle;height:20">
								<div>
									<b><?php  echo 'ADMIN'; ?></b>
								</div>
							</th>
							<th style="text-align: center; vertical-align:middle;height:20">
								<div>
									<b><?php  echo 'CAM'; ?></b>
								</div>
							</th>
						</tr>
					</table>
				</div>
				<!-- Button Submit!-->
				<div style="text-align:right; margin-top:80px; margin-right:15px">
					<a href="/purchasing/salesman-order" class="btn btn-info btn-xs" role="button" style="width:90px">Back</a>
					<?=PrintPdf($kode_SO); ?> 
				</div>
			</div>
		</div>
		<div class="col-lg-12" style="padding-top:40px">
			<div  class="row" >
				<?=$this->render('indexTimelineStatus',[
					'soHeaderData'=>$soHeaderData
				])?>
			</div>
		</div>
</div>





<?php
/*
 * JS  CREATED
 * @author wawan
 * @since 1.2
*/
$this->registerJs("
		$.fn.modal.Constructor.prototype.enforceFocus = function() {};
		$('#new-add').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var modal = $(this)
			var title = button.data('title')
			var href = button.attr('href')
			modal.find('.modal-title').html(title)
			modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
			$.post(href)
				.done(function( data ) {
					modal.find('.modal-body').html(data)
				});
			}),
",$this::POS_READY);

Modal::begin([
		'id' => 'new-add',
		'header' => "<div style='font-family:tahoma, arial, sans-serif;font-size:9pt'> <i class='fa fa-info-circle fa-2x'></i>  ADD ITEM PRODUCT </div>",//'<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>New Item</b></h4></div>',
		// 'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:rgba(0,255,0, 1)'
		]
	]);
Modal::end();


/*
	 * JS AUTH1 | CREATED
	 * @author ptrnov <piter@lukison.com>
	 * @since 1.2
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#so-auth1-sign').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var modal = $(this)
				var title = button.data('title')
				var href = button.attr('href')
				modal.find('.modal-title').html(title)
				modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)
					});
				}),
	",$this::POS_READY);

	Modal::begin([
			'id' => 'so-auth1-sign',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Signature Authorize</b></h4></div>',
			'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			]
		]);
	Modal::end();



	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#so-auth2-sign').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var modal = $(this)
				var title = button.data('title')
				var href = button.attr('href')
				modal.find('.modal-title').html(title)
				modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)
					});
				}),
	",$this::POS_READY);

	Modal::begin([
			'id' => 'so-auth2-sign',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Signature Authorize</b></h4></div>',
			'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			]
		]);
	Modal::end();


$this->registerJs("
		$.fn.modal.Constructor.prototype.enforceFocus = function() {};
		$('#so-edit-review').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var modal = $(this)
			var title = button.data('title')
			var href = button.attr('href')
			modal.find('.modal-title').html(title)
			modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
			$.post(href)
				.done(function( data ) {
					modal.find('.modal-body').html(data)
				});
			}),
",$this::POS_READY);

Modal::begin([
		'id' => 'so-edit-review',
		'header' => "<div style='font-family:tahoma, arial, sans-serif;font-size:9pt'> <i class='fa fa-info-circle fa-2x'></i>  Edit </div>",//'<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>New Item</b></h4></div>',
		// 'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color:rgba(0,255,0, 1)'
		]
	]);
Modal::end();



$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#so-note-review').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var modal = $(this)
				var title = button.data('title')
				var href = button.attr('href')
				modal.find('.modal-title').html(title)
				modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)
					});
				}),
		",$this::POS_READY);

		Modal::begin([
			'id' => 'so-note-review',
			//'header' => '<h4 class="modal-title">Entry Request Order</h4>',
			'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Note</h4></div>',
			'size' => 'modal-md',
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
			]
		]);
		Modal::end();


		$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#so-shiping-review').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var modal = $(this)
				var title = button.data('title')
				var href = button.attr('href')
				modal.find('.modal-title').html(title)
				modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)
					});
				}),
		",$this::POS_READY);

		Modal::begin([
			'id' => 'so-shiping-review',
			//'header' => '<h4 class="modal-title">Entry Request Order</h4>',
			'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Note</h4></div>',
			'size' => 'modal-md',
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
			]
		]);
		Modal::end();


		$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#so-notetop-review').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var modal = $(this)
				var title = button.data('title')
				var href = button.attr('href')
				modal.find('.modal-title').html(title)
				modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)
					});
				}),
		",$this::POS_READY);

		Modal::begin([
			'id' => 'so-notetop-review',
			//'header' => '<h4 class="modal-title">Entry Request Order</h4>',
			'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">TOP</h4></div>',
			'size' => 'modal-md',
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
			]
		]);
		Modal::end();



	/*
	 * Action PO Detail
	*/
	$this->registerJs("
		$(document).on('click', '[data-toggle-approved]', function(e){
			e.preventDefault();
			var idx = $(this).data('toggle-approved');
			$.ajax({
					url: '/purchasing/salesman-order/approved-so-detail',
					type: 'POST',
					//contentType: 'application/json; charset=utf-8',
					data:'id='+idx,
					dataType: 'json',
					success: function(result) {
						if (result == 1){
							// Success
							$.pjax.reload({container:'#gv-so-detail-md-inbox'});
						} else {
							// Fail
						}
					}
				});

		});


		$(document).on('click', '[data-toggle-reject]', function(e){
			e.preventDefault();
			var idx = $(this).data('toggle-reject');
			$.ajax({
					url: '/purchasing/salesman-order/reject-so-detail',
					type: 'POST',
					//contentType: 'application/json; charset=utf-8',
					data:'id='+idx,
					dataType: 'json',
					success: function(result) {
						if (result == 1){
							$.pjax.reload({container:'#gv-so-detail-md-inbox'});
						}
					}
				});
		});


		$(document).on('click', '[data-toggle-delete]', function(e){
			e.preventDefault();
			var idx = $(this).data('toggle-delete');
			$.ajax({
					url: '/purchasing/salesman-order/delete-so-detail',
					type: 'POST',
					//contentType: 'application/json; charset=utf-8',
					data:'id='+idx,
					dataType: 'json',
					success: function(result) {
						if (result == 1){
							$.pjax.reload({container:'#gv-so-detail-md-inbox'});
						}
					}
				});
		});
	",$this::POS_READY);