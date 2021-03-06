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


	
	/*[3] GRID VIEW INVENTORY */
	$inventory=GridView::widget([
		'id'=>'inventory-list',
        'dataProvider' => $inventoryProvider,
		//'filterModel' => $searchModelInventory,
        'columns' => [
			[
				'class'=>'kartik\grid\SerialColumn',
				//'contentOptions'=>['class'=>'kartik-sheet-style'],
				'width'=>'10px',
				'header'=>'No.',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'verdana, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(249,215,100,1)',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			[
				'attribute'=>'NAME_ITEM',
				'label'=>'ITEMS/Pcs',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'left',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			[
				'attribute'=>'STOCK',
				'label'=>'STOCK',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'width'=>'11px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			[
				'attribute'=>'RETURE',
				'label'=>'RETURE',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			[
				'attribute'=>'REQUEST',
				'label'=>'REQUEST',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			[
				'attribute'=>'SELL_IN',
				'label'=>'SELL-IN',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			[
				'attribute'=>'SELL_OUT',
				'label'=>'SELL-OUT',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'right',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			]			
		],
		'toolbar' => [
			'',
		],
		'panel' => [
			'heading'=>"<i class='fa fa-stack-overflow fa-1x'></i>  SUMMARY INVENTORY",
			'type'=>'info',
			'footer'=>false,
			
		],
    ]);
?>
	<?=$inventory?>
