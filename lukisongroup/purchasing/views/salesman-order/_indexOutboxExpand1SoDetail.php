<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
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
	
/*
 * INBOX SALESAN ORDER - MD Sales
 * ACTION CHECKED or APPROVED
 * @author ptrnov [piter@lukison]
 * @since 1.2
*/
$_gvOutboxSoDetail= GridView::widget([
	'id'=>'gv-so-detail-md-outbox',
	'dataProvider'=> $aryProviderSoDetailOutbox,
	//'filterModel' => $searchModel,
	'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
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
	'columns' => [
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
						'font-size'=>'9pt',
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
				'attribute'=>'TGL',
				'label'=>'Create At',
				'hAlign'=>'left',
				'vAlign'=>'middle',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'90px',
						'font-family'=>'verdana, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'90px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt'
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
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'width'=>'250px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt'
					]
				],
			],						
			/*QTY/PCS*/
			[
				'attribute'=>'SO_QTY',
				'label'=>'QTY/Pcs',
				'hAlign'=>'right',
				'vAlign'=>'middle',
				//'group'=>true,
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'120px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'width'=>'120px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			/*QTY/PCS*/
			[
				'attribute'=>'SO_QTY',
				'label'=>'QTY/Karton',
				'hAlign'=>'right',
				'vAlign'=>'middle',
				//'group'=>true,
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'120px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'width'=>'120px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			/*HARGA_SALES/PCS*/
			[
				'attribute'=>'HARGA_SALES',
				'label'=>'PRICE/Pcs',
				'hAlign'=>'right',
				'vAlign'=>'middle',
				//'group'=>true,
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'120px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'width'=>'120px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			/*SUB TTL SO*/
			[
				'attribute'=>'HARGA_SALES',
				'label'=>'SUB.TOTAL',
				'hAlign'=>'right',
				'vAlign'=>'middle',
				//'group'=>true,
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'120px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'width'=>'120px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			/*SUBMIT_QTY*/
			[
				'attribute'=>'SUBMIT_QTY',
				'label'=>'PREMIT QTY/Pcs',
				'hAlign'=>'right',
				'vAlign'=>'middle',
				//'group'=>true,
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'120px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(74, 206, 231, 1)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'width'=>'120px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			/*SUBMIT_QTY*/
			[
				'attribute'=>'SUBMIT_PRICE',
				'label'=>'PREMIT PRICE/Pcs',
				'hAlign'=>'right',
				'vAlign'=>'middle',
				//'group'=>true,
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'120px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(74, 206, 231, 1)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'width'=>'120px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			/*SUB TTL SUBMIT SO*/
			[
				'attribute'=>'HARGA_SALES',
				'label'=>'PREMIT SUB.TOTAL',
				'hAlign'=>'right',
				'vAlign'=>'middle',
				//'group'=>true,
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'120px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(74, 206, 231, 1)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'width'=>'120px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
	],
	'pjax'=>true,
	'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-so-detail-md-outbox',
		   ],
	],
	'hover'=>true, //cursor select
	'responsive'=>true,
	'responsiveWrap'=>true,
	'bordered'=>true,
	'striped'=>'4px',
	'autoXlFormat'=>true,
	'export' => false,
	'toolbar'=> [''
			//['content'=>''],
			//'{export}',
			//'{toggleData}',
		],
	'panel'=>[
		'type'=>GridView::TYPE_INFO,
		'heading'=>"<i class='fa fa-cart-plus fa-1x'></i> DETAIL ORDER", 
	],
]);
?>
<?=$_gvOutboxSoDetail?>
