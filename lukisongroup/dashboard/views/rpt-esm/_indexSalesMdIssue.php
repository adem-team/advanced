<?php

use kartik\helpers\Html;
use yii\widgets\DetailView;
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

function statusIssue($model){
	if($model->STATUS==1){
		/*REVIEW*/
		return Html::a('<i class="fa fa-square-o fa-md"></i> REVIEW', '#',['class'=>'btn btn-info btn-xs', 'style'=>['width'=>'100px'],'title'=>'Review']);
	}elseif($model->STATUS==2){
		/*PROCESS*/
		return Html::a('<i class="fa fa-check-square-o fa-md"></i> PROCESS', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Process']);
	}elseif ($model->STATUS==3){
		/*CLODED*/
		return Html::a('<i class="glyphicon glyphicon-remove"></i> CLOSED', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Closed']);
	};
}

$btn_srch = Html::button(Yii::t('app', 'Search Date'),
	['value'=>url::to(['ambil-tanggal-issue']),
	'id'=>'modalButtonDashboardIssueTgl',
	'class'=>"btn btn-info btn-sm"						
]);
					  
$gridColumns = [
	[ #serial column
		'class'=>'kartik\grid\SerialColumn',
		'contentOptions'=>['class'=>'kartik-sheet-style'],
		'width'=>'10px',
		'header'=>'No.',
		'noWrap'=>true,
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
		'filter'=>false,
		'noWrap'=>true,
		'mergeHeader'=>true,
		'headerOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'50px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			  'background-color'=>'rgba(126, 189, 188, 0.9)',
			]
		],
		'contentOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'50px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			]
		],
	],
	[
		'attribute' => 'NM_CUSTOMER',
		'label'=>'CUSTOMER',
		'hAlign'=>'left',
		'filterOptions'=>[
			'colspan'=>3,
		],
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
		'attribute' => 'UserNm',
		'label'=>'SALES.NM',
		'hAlign'=>'left',
		'vAlign'=>'top',
		'mergeHeader'=>true,
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
		'attribute' => 'Geonm',
		'label'=>'GEO',
		'hAlign'=>'left',
		'vAlign'=>'top',
		'mergeHeader'=>true,
		'headerOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'50px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			  'background-color'=>'rgba(126, 189, 188, 0.9)',
			]
		],
		'contentOptions'=>[
			'style'=>[
			  'text-align'=>'left',
			  'width'=>'50px',
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
			  'width'=>'400px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			  'background-color'=>'rgba(126, 189, 188, 0.9)',
			]
		],
		'contentOptions'=>[
			'style'=>[
			  'text-align'=>'left',
			  'width'=>'400px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			]
		],
	],
	[	//COL-1
		/* Attribute Status Detail RO */
		'attribute'=>'STATUS',
		'options'=>['id'=>'test-ro'],
		'label'=>'Status',
		'hAlign'=>'center',
		'vAlign'=>'middle',
		'mergeHeader'=>true,
		'contentOptions'=>['style'=>'width: 100px'],
		'format' => 'html',
		'value'=>function ($model, $key, $index, $widget) {
					return statusIssue($model);
		},
		'headerOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'80px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			  'background-color'=>'rgba(126, 189, 188, 0.9)',
			]
		],
		'contentOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'80px',
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
	'filterRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.9); align:center'],
	'columns' => $gridColumns,
	'pjax'=>true,
	'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-dashboard-issue',
		],
	],
	'panel' => [
		'heading'=>false,
		'type'=>'success',
		'before'=> $btn_srch
	],
	'toolbar'=> [
		''
	],
	'summary'=>false,
]); 
?>
<?=$issueMemo?>
<?php

	$this->registerJs("		
        $.fn.modal.Constructor.prototype.enforceFocus = function(){};	
		$(document).on('click','#modalButtonDashboardIssueTgl', function(ehead){ 			  
			$('#modal-dashboard-issue-tgl').modal('show')
			.find('#modalContentDasboardIssueTgl')
			.load(ehead.target.value);
		});		  
			 
	",$this::POS_READY);
	 
     Modal::begin([		
         'id' => 'modal-dashboard-issue-tgl',		
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-search"></div><div><h4 class="modal-title"> SEARCH DATE</h4></div>',	
		 'size' => Modal::SIZE_SMALL,	
         'headerOptions'=>[		
                 'style'=> 'border-radius:5px; background-color: rgba(90, 171, 255, 0.7)',		
         ],		
     ]);		
		echo "<div id='modalContentDasboardIssueTgl'></div>";
     Modal::end();
?>
