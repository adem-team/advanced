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
        'model' => $model,//$aryProviderSODetail->getModels(),
        'attributes' => [
    		[
				'columns' => [
					[
						'attribute'=>'KODE_REF', 
						'label'=>'SO.NO',
						'displayOnly'=>true,
						'format'=>'raw',
						'labelColOptions'=>['style'=>'width:10%;text-align:right;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'value'=>"<span style='color:#ff0000;font-weight: bold'>".$model['KODE_REF']."</span>",
					],
					[
						'attribute'=>'PIC', 
						'label'=>'PIC',
						'labelColOptions'=>['style'=>'width:10%;text-align:right;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'displayOnly'=>true
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'CUST_KD', 
						'label'=>'CUSTOMER.ID',
						'displayOnly'=>true,
						'labelColOptions'=>['style'=>'width:10%;text-align:right;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left;font-family:tahoma, arial, sans-serif;font-size:7pt']
					],
					[
						//JAM MEMULAI PERJALANAN DARI DISTRIBUTOR/OTHER
						'attribute'=>'TLP2',
						'label'=>'HP',						
						'labelColOptions'=>['style'=>'width:10%;text-align:right;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'displayOnly'=>true
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'CUST_NM', 
						'label'=>'CUSTOMER',
						'labelColOptions'=>['style'=>'width:10%;text-align:right;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'displayOnly'=>true
					],
					[
						'attribute'=>'KTP', 
						'label'=>'NO.KTP',
						'labelColOptions'=>['style'=>'width:10%;text-align:right;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'displayOnly'=>true
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'JOIN_DATE', 
						'label'=>'Join Date',
						'displayOnly'=>true,
						'labelColOptions'=>['style'=>'width:10%;text-align:right;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left;font-family:tahoma, arial, sans-serif;font-size:7pt'],
					],
					[
						'attribute'=>'NPWP', 
						'label'=>'NPWP',
						'labelColOptions'=>['style'=>'width:10%;text-align:right;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'displayOnly'=>true
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'NM_FIRST', 
						'label'=>'SALES NAME',
						'labelColOptions'=>['style'=>'width:10%;text-align:right;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'displayOnly'=>true
					],
					[
						
						'attribute'=>'SIUP', 
						'label'=>'SIUP',						
						'labelColOptions'=>['style'=>'width:10%;text-align:right;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'valueColOptions'=>['style'=>'width:40%;text-align:left;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'displayOnly'=>true
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'ALAMAT', 
						'label'=>'ALAMAT',
						'labelColOptions'=>['style'=>'width:10%;text-align:right;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'valueColOptions'=>['style'=>'width:90%;text-align:left;font-family:tahoma, arial, sans-serif;font-size:7pt'],
						'displayOnly'=>true
					]
				],
			],				
        ],
		'mode'=>DetailView::MODE_VIEW,
		'enableEditMode'=>false,
		'mainTemplate'=>'{detail}',
		'panel'=>[
			'heading'=>"<div style='font-family:tahoma, arial, sans-serif;font-size:9pt'> <i class='fa fa-info-circle fa-1x'></i> CUSTOMER INFO </div>",
			'type'=>DetailView::TYPE_INFO,
		],			
    ]); 
?>
	<?=$vwHeader1?>
