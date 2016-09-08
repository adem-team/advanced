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
	$ro=GridView::widget([
		'id'=>'ro-list',
        'dataProvider' => $requestProvider,
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
			
			/*GRIDVIEW EXPAND*/
			/* [	
				'class'=>'kartik\grid\ExpandRowColumn',
				'width'=>'50px',
				'header'=>'Detail',
				'value'=>function ($model, $key, $index, $column) {
					return GridView::ROW_COLLAPSED;
				},
				'detail'=>function ($model, $key, $index, $column){		
					return $this->render('_expand1RoPerCustomer');
				},
				'collapseTitle'=>'Close Exploler',
				'expandTitle'=>'Click to views detail',				
				'expandOneOnly'=>true,
				'headerOptions'=>[
					'style'=>[
						
						'text-align'=>'center',
						'width'=>'10px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(74, 206, 231, 1)',
					]
				],
				'contentOptions'=>[
					'style'=>[
					
						'text-align'=>'center',
						'width'=>'10px',
						'height'=>'10px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],  */
			[
				'attribute'=>'NAME_ITEM',
				'label'=>'ITEMS',
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
				'label'=>'STOCK/Pcs',
				'value'=>'<button class="btn btn-box-tool" data-toggle="tooltip" title="show/hide" data-widget="collapse"><i class="fa fa-minus"></i>s</button>',
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
				'attribute'=>'SELL_IN',
				'label'=>'SELL IN/Pcs',
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
				'label'=>'SELL OUT/Pcs',
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
			'heading'=>'<h3 class="panel-title">[C] SUMMARY REQUEST ORDER</h3>',
			'type'=>'info',
			'footer'=>false,
			
		],
    ]);
?>
	<?=$ro?>
