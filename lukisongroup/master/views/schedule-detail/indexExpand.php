<?php
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
	//print_r($modelInvntory);

	echo $cust_id;
	$userInfo=DetailView::widget([		
        'model' => $modelInfo,
        'attributes' => [
            [
				'attribute'=>'CREATE_AT',
				'label'=>'Date Time'
			],
			[
				'attribute'=>'nmuser',
				'label'=>'User Name'
			],
			[
				'attribute'=>'nmgroup',
				'label'=>'Schadule Group'
			],
			[
				'attribute'=>'nmcust', 
				'label'=>'Customer'				
			],
        ],
		'mode'=>DetailView::MODE_VIEW,
		'enableEditMode'=>false,
		'mainTemplate'=>'{detail}',
		'panel'=>[
			'heading'=>'USER INFO',
			'type'=>DetailView::TYPE_DANGER,
		],			
    ]); 

	$inventory=GridView::widget([
		'id'=>'inventory-list',
        'dataProvider' => $dataProviderInventory,
		'filterModel' => $searchModelInventory,
        'columns' => [
			[
				'attribute'=>'NM_BARANG',
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
				'attribute'=>'TGL',
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
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			[
				'attribute'=>'TGL',
				'label'=>'SELL IN',
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
				'attribute'=>'TGL',
				'label'=>'SELL OUT',
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
				'attribute'=>'TGL',
				'label'=>'EXPIRED DATE',
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'text-align'=>'center',
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
			'heading'=>'<h3 class="panel-title">LIST INVENTORY</h3>',
			'type'=>'danger',
		],
    ]);
	
	$visitImage=GridView::widget([
		'id'=>'img-list',
        'dataProvider' => $dataProviderImage,
		'filterModel' => $searchModelImage,
        'columns' => [
			[
				'attribute'=>'image_start',
				'format'=>'raw', 
				'label'=>'Image Start',
				//'format'=>['image',['width'=>'100','height'=>'120']],
				'value'=>function($model){				
					$base64 ='data:image/jpg;charset=utf-8;base64,'.$model->IMG_DECODE_START;
					//return Html::img($base64,['width'=>'100','height'=>'60','class'=>'img-circle']);
					return Html::img($base64,['width'=>'150','height'=>'150']);
				},
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
			],
			[
				'attribute'=>'image_end',
				'format'=>'raw', 
				'label'=>'Image End',
				//'format'=>['image',['width'=>'100','height'=>'120']],
				'value'=>function($model){				
					$base64 ='data:image/jpg;charset=utf-8;base64,'.$model->IMG_DECODE_END;
					return Html::img($base64,['width'=>'150','height'=>'150']);
				},
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
			] 
		
		],
		'toolbar' => [
			'',
		],
		'panel' => [
			'heading'=>'<h3 class="panel-title">LIST IMAGE VISITING</h3>',
			'type'=>'danger',
		],
    ]);

/* 	echo "test expand";
	echo "</br></br>";
	echo $tgl;
	echo "</br></br>";
	echo $cust_id;
	echo "</br></br>";
	echo $user_id; */
?>

<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
    <div  class="row" style="margin-top:15px">
        <div class="col-sm-8 col-md-8 col-lg-8">
			<?php
				echo $userInfo;
				echo $inventory;
			?>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4">
			<?php
				echo $visitImage;
			?>
		</div>
	</div>
</div>