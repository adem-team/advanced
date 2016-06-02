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

//print_r($dataModelsHeader1);
	/*[1] LIST VIEW INFO */
	$vwHeader1=DetailView::widget([		
        'model' => $dataModelsHeader1[0],
        'attributes' => [
    		[
				'columns' => [
					[
						'attribute'=>'TGL', 
						'label'=>'DATE',
						'displayOnly'=>true,
						'valueColOptions'=>['style'=>'width:30%']
					],
					[
						//JAM MEMULAI PERJALANAN DARI DISTRIBUTOR/OTHER
						'attribute'=>'TIME_DAYSTART', 
						'format'=>'raw',
						'value'=> $dataModelsHeader1[0]['TIME_DAYSTART']!=''?$dataModelsHeader1[0]['TIME_DAYSTART']:"<span class='badge' style='background-color:#ff0000'>ABSENT </span>",
						'label'=>'START TIME',
						'valueColOptions'=>['style'=>'width:30%'], 
						//'displayOnly'=>true
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'USER_NM', 
						'label'=>'USER NAME',
						'valueColOptions'=>['style'=>'width:30%'], 
						'displayOnly'=>true
					],
					[
						//JAM SELESAI PERJALANAN DARI DISTRIBUTOR/OTHER
						'attribute'=>'TIME_DAYEND',
						'format'=>'raw',
						'value'=>$dataModelsHeader1[0]['TIME_DAYEND']!=''?$dataModelsHeader1[0]['TIME_DAYEND']:"<span class='badge' style='background-color:#ff0000'>ABSENT </span>",						
						'label'=>'END TIME',
						'valueColOptions'=>['style'=>'width:30%'], 
						'displayOnly'=>true
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'SCDL_GRP_NM', 
						'label'=>'GROUP',
						'displayOnly'=>true,
						'valueColOptions'=>['style'=>'width:30%']
					],
					[
						//GPS IN -> VALUE AND STATUS
						'attribute'=>'DISTANCE_DAYSTART', 
						'label'=>'Radius.In',
						'format'=>'raw', 
						'value'=>$dataModelsHeader1[0]['DISTANCE_DAYSTART'],
						//'value'=>"<span class='badge' style='background-color:#ff0000'>'' </span>".' '.$dataModelsHeader1[0]['DISTANCE_DAYSTART'],
						//'value'=>'<kbd>'.$model->book_code.'</kbd>',
						'valueColOptions'=>['style'=>'width:30%'], 
						'displayOnly'=>true
					],
				],
			],
			[
				'columns' => [
					[
						'attribute'=>'TTL_TIME', 
						'label'=>'TOTAL TIME',
						'valueColOptions'=>['style'=>'width:30%'], 
						'displayOnly'=>true
					],
					[
						//GPS IN -> VALUE AND STATUS
						'attribute'=>'DISTANCE_DAYEND', 
						'label'=>'Radius.Out',
						'format'=>'raw', 
						'value'=>$dataModelsHeader1[0]['DISTANCE_DAYEND'],
						//'value'=>"<span class='badge' style='background-color:#ff0000'>'' </span>".' '.$dataModelsHeader1[0]['DISTANCE_DAYEND'],
						//'value'=>'<kbd>'.$model->book_code.'</kbd>',
						'valueColOptions'=>['style'=>'width:30%'], 
						'displayOnly'=>true
					],
				],
			],					
        ],
		'mode'=>DetailView::MODE_VIEW,
		'enableEditMode'=>false,
		'mainTemplate'=>'{detail}',
		'panel'=>[
			'heading'=>'[A] USER INFO',
			'type'=>DetailView::TYPE_INFO,
		],		
		
    ]); 
?>
	<?=$vwHeader1?>
