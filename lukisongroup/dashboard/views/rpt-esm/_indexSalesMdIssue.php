<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
$gridColumns = [
	[ #serial column
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
				'background-color'=>'rgba(126, 189, 188, 0.9)',
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
	[
		'attribute' => 'TGL',
		'label'=>'TGL',
		'hAlign'=>'center',
		'vAlign'=>'middle',
		'headerOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'10px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			  'background-color'=>'rgba(126, 189, 188, 0.9)',
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
	[
		'attribute' => 'NM_CUSTOMER',
		'label'=>'CUSTOMER',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'headerOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'150px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			  'background-color'=>'rgba(126, 189, 188, 0.9)',
			]
		],
		'contentOptions'=>[
			'style'=>[
			  'text-align'=>'left',
			  'width'=>'150px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			]
		],
	],
	[
		'attribute' => 'NM_USER',
		'label'=>'SALES',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'headerOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'100px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			  'background-color'=>'rgba(126, 189, 188, 0.9)',
			]
		],
		'contentOptions'=>[
			'style'=>[
			  'text-align'=>'left',
			  'width'=>'100px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			]
		],
	],
	[
		'attribute' => 'ISI_MESSAGES',
		'label'=>'ISSUE NOTE',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'headerOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'500px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			  'background-color'=>'rgba(126, 189, 188, 0.9)',
			]
		],
		'contentOptions'=>[
			'style'=>[
			  'text-align'=>'left',
			  'width'=>'500px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			]
		],
	],
];

$issueMemo= GridView::widget([
	'id'=>'gv-dashboard-issue',
	'dataProvider' => $dataProviderIssue,
	'filterModel' => $searchModelIssue,
	'columns' => $gridColumns,
	'pjax'=>true,
	'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-dashboard-issue',
		],
	],
	'summary'=>false,
]); 
?>
<?=$issueMemo?>