<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\detail\DetailView;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/*[4] GRID VIEW EXPIRED */
	$expired=GridView::widget([
		'id'=>'expired-rpt',
        'dataProvider' => $dataProviderMemo,
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
				'attribute'=>'NM_CUSTOMER',
				'label'=>'CUSTOMERS',
				'headerOptions'=>[
					'style'=>[
						'width'=>'10%',
						'text-align'=>'center',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
				'contentOptions'=>[
					'style'=>[
						'width'=>'30%',
						'text-align'=>'left',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
					]
				],
			],
			[
				'attribute'=>'ISI_MESSAGES',
				'label'=>'NOTES',
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
			]
		],
		'toolbar' => [
			'',
		],
		'panel' => [
			'heading'=>"<i class='fa fa-tags fa-1x'></i> LIST NOTES",  
			'type'=>'info',
			'footer'=>false,
			
		],
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'expired-rpt',
			],
		],
		'hover'=>true, //cursor select
		//'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
    ]);
?>
	<?=$expired?>