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

/*[4] GRID VIEW IMAGE SHOW */
	$visitImage=GridView::widget([
		'id'=>'img-list',
		'rowOptions' => function ($model, $key, $index, $grid) {
                return ['id' => $model['ID'], 'onclick' => '
						$(document).ready(function(){
							$("#tampil-image").modal({
								show: "true"
							}); 
						});				
					'	
				];
        },
        'dataProvider' => $dataProviderHeader2,
		//'filterModel' => $searchModelImage,
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
				'attribute'=>'IMG_DECODE_START',
				'format'=>'raw', 
				'label'=>'Image Start',
				//'format'=>['image',['width'=>'100','height'=>'120']],
				'value'=>function($model){				
					$base64 ='data:image/jpg;charset=utf-8;base64,'.$model['IMG_DECODE_START'];
					return $model['IMG_DECODE_START']!=''?Html::img($base64,['width'=>'120','height'=>'120']):Html::img($model['noImage'],['width'=>'120','height'=>'120']);
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
				'attribute'=>'IMG_DECODE_END',
				'format'=>'raw', 
				'label'=>'Image End',
				//'format'=>['image',['width'=>'100','height'=>'120']],
				'value'=>function($model){				
					$base64 ='data:image/jpg;charset=utf-8;base64,'.$model['IMG_DECODE_END'];
					return $model['IMG_DECODE_END']!=''?Html::img($base64,['width'=>'120','height'=>'120']):Html::img($model['noImage'],['width'=>'120','height'=>'120']);
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
			'heading'=>"<i class='fa fa-file-image-o fa-1x'></i> LIST IMAGES",
			'type'=>'danger',
			'footer'=>false,
		],
    ]);
?>
<?=$visitImage?>