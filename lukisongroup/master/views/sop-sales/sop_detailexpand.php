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
        'model' => $model_header,
        'attributes' => [
    		[
				'columns' => [
					[
						'attribute'=>'SOP_TYPE',
						'value'=>$model_header->sopNm,
						'label'=>'Keterangan',
						'displayOnly'=>true,
						'labelColOptions'=>['style'=>'width:10%;text-align:right'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left']
					],
					[
						//JAM MEMULAI PERJALANAN DARI DISTRIBUTOR/OTHER
						'attribute'=>'KATEGORI', 
						'label'=>'Customer Kategori',
						'labelColOptions'=>['style'=>'width:10%;text-align:right'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left'],
						'displayOnly'=>true
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'TARGET_MONTH', 
						'label'=>'Target Perbulan',
						'labelColOptions'=>['style'=>'width:10%;text-align:right'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left'],
						'displayOnly'=>true
					],
					[
						'attribute'=>'TARGET_DAY',
						'label'=>'Target Perhari',
						'labelColOptions'=>['style'=>'width:10%;text-align:right'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left'],
						'displayOnly'=>true
					],
					// [
					// 	'attribute'=>'TARGET_UNIT',
					// 	'label'=>'Target Perunit',
					// 	'labelColOptions'=>['style'=>'width:10%;text-align:right'],
					// 	'valueColOptions'=>['style'=>'width:40%;text-align:left'],
					// 	'displayOnly'=>true
					// ],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'TGL', 
						'label'=>'Tanggal',
						'displayOnly'=>true,
						'labelColOptions'=>['style'=>'width:10%;text-align:right'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left'],
					],
					[
						'attribute'=>'TARGET_UNIT', 
						'label'=>'Target Perunit',
						'labelColOptions'=>['style'=>'width:10%;text-align:right'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left'],
						'displayOnly'=>true
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'TTL_DAYS', 
						'label'=>'Total Hari',
						'labelColOptions'=>['style'=>'width:10%;text-align:right'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left'],
						'displayOnly'=>true
					],
					[
						'attribute'=>'BOBOT_PERCENT', 
						'label'=>'Nilai',
						'labelColOptions'=>['style'=>'width:10%;text-align:right'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left'],
						'displayOnly'=>true
					],
				],
			],	
        ],
		'mode'=>DetailView::MODE_VIEW,
		'enableEditMode'=>false,
		'mainTemplate'=>'{detail}',
		'panel'=>[
			'heading'=>"<i class='fa fa-info-circle fa-1x'></i> Sales INFO",
			'type'=>DetailView::TYPE_INFO,
		],		
		
    ]); 
?>
	<?=$vwHeader1?>
