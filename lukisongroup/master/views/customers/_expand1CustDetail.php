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

	$vwHeader1=DetailView::widget([		
        'model' => $modelCust,
        'attributes' => [
    		[
				'columns' => [
					[
						'attribute'=>'CUST_KD', 
						'label'=>'ID',
						'displayOnly'=>true,
						'labelColOptions'=>['style'=>'width:10%;text-align:right'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left']
					],
					[
						//JAM MEMULAI PERJALANAN DARI DISTRIBUTOR/OTHER
						'attribute'=>'PIC', 
						'label'=>'PIC',
						'labelColOptions'=>['style'=>'width:10%;text-align:right'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left'],
						'displayOnly'=>true
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'CUST_NM', 
						'label'=>'CUSTOMER',
						'labelColOptions'=>['style'=>'width:10%;text-align:right'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left'],
						'displayOnly'=>true
					],
					[
						'attribute'=>'TLP2',
						'label'=>'HP',
						'labelColOptions'=>['style'=>'width:10%;text-align:right'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left'],
						'displayOnly'=>true
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'SIUP', 
						'label'=>'SIUP',
						'displayOnly'=>true,
						'labelColOptions'=>['style'=>'width:10%;text-align:right'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left'],
					],
					[
						'attribute'=>'KTP', 
						'label'=>'NO.KTP',
						'labelColOptions'=>['style'=>'width:10%;text-align:right'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left'],
						'displayOnly'=>true
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'JOIN_DATE', 
						'label'=>'Join Date',
						'labelColOptions'=>['style'=>'width:10%;text-align:right'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left'],
						'displayOnly'=>true
					],
					[
						'attribute'=>'NPWP', 
						'label'=>'NPWP',
						'labelColOptions'=>['style'=>'width:10%;text-align:right'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left'],
						'displayOnly'=>true
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'ALAMAT', 
						'label'=>'ALAMAT',
						'labelColOptions'=>['style'=>'width:10%;text-align:right'],
						'valueColOptions'=>['style'=>'width:90%;text-align:left'],
						'displayOnly'=>true
					]
				],
			],				
        ],
		'mode'=>DetailView::MODE_VIEW,
		'enableEditMode'=>false,
		'mainTemplate'=>'{detail}',
		'panel'=>[
			'heading'=>"<i class='fa fa-info-circle fa-1x'></i> CUSTOMER INFO",
			'type'=>DetailView::TYPE_INFO,
		],		
		
    ]); 
?>
	<?=$vwHeader1?>
